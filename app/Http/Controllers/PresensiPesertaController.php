<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use App\Models\AttendanceSetting;
use App\Models\Participants;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PresensiPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = now();

        // 1️⃣ Ambil presensi AKTIF & VALID WAKTU
        $activeSetting = AttendanceSetting::where('is_active', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->first();

        // 2️⃣ Ambil peserta
        $participants = Participants::select('id', 'name', 'face_images')
            ->with([
                'attendances' => function ($q) use ($activeSetting) {

                    // PENTING: filter attendance HANYA sesi aktif
                    if ($activeSetting) {
                        $q->where('attendances_setting_id', $activeSetting->id);
                    } else {
                        // Supaya attendances kosong (tidak kebaca presensi lama)
                        $q->whereRaw('1 = 0');
                    }
                }
            ])
            ->orderBy('name')
            ->get();

        return view('participants.landingPage', compact(
            'participants',
            'activeSetting'
        ));
    }

    public function train(string $id)
    {
        $peserta = Participants::findOrFail($id);
        return view('participants.register-face', compact('peserta'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $client = new Client([
            'base_uri'     => rtrim(config('services.facerec.url'), '/') . '/',
            'timeout'      => 8,
            'http_errors'  => false,
        ]);

        try {
            $response = $client->post('api/check', [
                'json' => [
                    'image' => $request->image,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $raw = (string) $response->getBody();

            Log::debug('FASTAPI RESPONSE', [
                'status_code' => $statusCode,
                'raw' => $raw,
            ]);

            $decoded = json_decode($raw, true);

            // ================================
            // Guard: response bukan JSON
            // ================================
            if (!is_array($decoded)) {
                return response()->json([
                    'status' => 'searching',
                    'can_register' => false,
                    'message' => 'Invalid response from face service',
                ]);
            }

            // ================================
            // NORMALISASI STATUS
            // ================================
            $statusMap = [
                'searching'        => 'searching',
                'too_far'          => 'too_far',
                'too_close'        => 'too_close',
                'too_dark'         => 'too_dark',
                'too_bright'       => 'too_bright',
                'good'             => 'good',

                // alias / variasi
                'ok'               => 'good',
                'face_ok'          => 'good',
                'face_too_far'     => 'too_far',
                'face_too_close'   => 'too_close',
                'dark'             => 'too_dark',
                'bright'           => 'too_bright',
            ];

            $rawStatus = $decoded['status'] ?? 'searching';
            $status = $statusMap[$rawStatus] ?? 'searching';

            return response()->json([
                'status'        => $status,
                'can_register'  => (bool) ($decoded['can_register'] ?? false),
                'message'       => $decoded['message'] ?? null,
            ]);

        } catch (\Throwable $e) {
            Log::error('FACE CHECK ERROR', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'searching',
                'can_register' => false,
                'message' => 'Face service unavailable',
            ]);
        }
    }

    public function faceRegister(Request $request, string $id)
    {
        $peserta = Participants::findOrFail($id);

        $request->validate([
            'face_images' => 'required|array|min:5',
            'face_images.*' => 'string',
        ]);

        try {
            $client = new Client([
                'base_uri' => rtrim(config('services.facerec.url'), '/') . '/',
                'timeout'  => 30,
                'http_errors' => false,
            ]);

            foreach ($request->face_images as $i => $image) {
                $response = $client->post('api/register', [
                    'json' => [
                        'peserta_id' => (string) $peserta->id,
                        'name'    => $peserta->name,
                        'image'   => $image,
                    ],
                ]);

                $body = json_decode((string) $response->getBody(), true);

                if (empty($body['success'])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Registrasi wajah gagal di frame ke-' . ($i + 1),
                    ], 500);
                }
            }

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Face recognition service tidak tersedia',
            ], 503);
        }

        // ✅ PENENTU STATUS REGISTER ADA DI SINI
        $peserta->face_images = $request->face_images;
        $peserta->save();

        return response()->json([
            'pesertaId' => $peserta->id,
            'status' => 'success',
            'message' => 'Wajah berhasil didaftarkan',
            'redirect' => route('landing.page'),
        ]);
    }


    public function showCaptureForm($id)
    {
        $peserta = Participants::findOrFail($id);

        return view('participants.attendancePage', [
            'peserta'  => $peserta,
            'presensi' => null,
        ]);
    }

    public function faceAttendance(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|string',
        ]);

        try {
            /*
            |--------------------------------------------------------------------------
            | 1. Normalisasi & kirim ke Face API
            |--------------------------------------------------------------------------
            */

            $image = $validated['image'];

            if (str_contains($image, ',')) {
                $image = explode(',', $image, 2)[1];
            }

            $client = new Client([
                'base_uri'    => rtrim(config('services.facerec.url'), '/') . '/',
                'timeout'     => 20,
                'http_errors' => false,
            ]);

            $response = $client->post('api/recognize', [
                'json' => ['image' => $image],
            ]);

            $status = $response->getStatusCode();
            $body   = json_decode((string) $response->getBody(), true);

            Log::info('📥 FaceAPI Response', compact('status', 'body'));

            /*
            |--------------------------------------------------------------------------
            | 2. Validasi Face API
            |--------------------------------------------------------------------------
            */

            if ($status !== 200 || empty($body['success'])) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $body['message'] ?? 'Wajah tidak dikenali',
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | 3. Ambil peserta_id (INI KUNCI)
            |--------------------------------------------------------------------------
            */

            $pesertaId = $body['peserta_id'] ?? null;

            if (!$pesertaId) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Wajah belum terdaftar',
                ], 404);
            }

            $participant = Participants::find((int) $pesertaId);

            if (!$participant) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Peserta tidak ditemukan',
                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | 4. Cek presensi aktif
            |--------------------------------------------------------------------------
            */

            $now = now();

            $activeSetting = AttendanceSetting::where('is_active', true)
                ->where('start_time', '<=', $now)
                ->where('end_time', '>=', $now)
                ->first();

            if (!$activeSetting) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Presensi belum dibuka',
                ], 403);
            }

            /*
            |--------------------------------------------------------------------------
            | 5. Cegah presensi ganda
            |--------------------------------------------------------------------------
            */

            if (
                $participant->attendances()
                    ->where('attendances_setting_id', $activeSetting->id)
                    ->exists()
            ) {
                return response()->json([
                    'status'  => 'info',
                    'message' => 'Sudah presensi',
                ], 200);
            }

            /*
            |--------------------------------------------------------------------------
            | 6. Simpan presensi
            |--------------------------------------------------------------------------
            */

            $participant->attendances()->create([
                'attendances_setting_id' => $activeSetting->id,
                'method'                => 'faceRec',
                'attended_at'           => now(),
            ]);

            return response()->json([
                'status'                => 'success',
                'message'               => 'Presensi berhasil',
                'participant_id'        => $participant->id,
                'attendances_setting_id' => $activeSetting->id,
            ], 200);

        } catch (\Throwable $e) {

            Log::error('🔥 FaceAttendance Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
