<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\AttendanceSetting;
use App\Models\Participants;
use App\Models\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Attendances::with('participant');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('participant', function ($q) use ($search) {
                $q->where('participant.name', 'like', "%{$search}%");
            });
        }


        if ($request->filled('gender')) {
            $query->whereHas('participant', function ($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }


        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy(
                    Participants::select('name')
                        ->whereColumn('participants.id', 'attendances.participant_id'),
                    'asc'
                );
                break;

            case 'name_desc':
                $query->orderBy(
                    Participants::select('name')
                        ->whereColumn('participants.id', 'attendances.participant_id'),
                    'desc'
                );
                break;

            case 'created_asc':
                $query->orderBy('attended_at', 'asc');
                break;

            case 'created_desc':
                $query->orderBy('attended_at', 'desc');
                break;

            default:
                $query->orderBy('attended_at', 'desc');
                break;
        }

        $attendances = $query->paginate(10);

        return view('admin.presensi.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $now = \Carbon\Carbon::now();


        $activeSetting = AttendanceSetting::where('is_active', true)
            ->whereRaw('? BETWEEN start_time AND end_time', [$now])
            ->first();


        $closedCount = AttendanceSetting::where('is_active', true)
            ->where('end_time', '<', $now)
            ->update([
                'is_active' => false,
                'updated_at' => $now
            ]);


        if ($closedCount > 0) {
            Log::info("Auto-closed {$closedCount} expired attendance settings at {$now}");
        }


        $query = Participants::query();


        if ($activeSetting) {
            $query->with([
                'attendances' => function ($q) use ($activeSetting) {
                    $q->where('attendances_setting_id', $activeSetting->id)
                    ->orderBy('created_at', 'desc');
                }
            ]);
        }


        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }


        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }


        $sortColumn = 'created_at';
        $sortDirection = 'desc';

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $sortColumn = 'name';
                    $sortDirection = 'asc';
                    break;
                case 'name_desc':
                    $sortColumn = 'name';
                    $sortDirection = 'desc';
                    break;
                case 'created_asc':
                    $sortColumn = 'created_at';
                    $sortDirection = 'asc';
                    break;
                case 'created_desc':
                default:
                    $sortColumn = 'created_at';
                    $sortDirection = 'desc';
                    break;
            }
        }

        $participants = $query
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10)
            ->withQueryString(); // Maintain query parameters in pagination


        $stats = null;
        if ($activeSetting) {
            $stats = [
                'total_participants' => $participants->total(),
                'attended' => Attendances::where('attendances_setting_id', $activeSetting->id)->count(),
                'not_attended' => $participants->total() - Attendances::where('attendances_setting_id', $activeSetting->id)->count(),
                'time_remaining' => $now->diffInMinutes(\Carbon\Carbon::parse($activeSetting->end_time), false),
                'is_closing_soon' => $now->diffInMinutes(\Carbon\Carbon::parse($activeSetting->end_time)) <= 30
            ];
        }

        return view('admin.presensi.create', compact(
            'participants',
            'activeSetting',
            'stats'
        ));
    }

    /**
     * Helper method untuk cek apakah attendance setting masih aktif
     */
    private function isAttendanceActive($attendanceSetting)
    {
        if (!$attendanceSetting || !$attendanceSetting->is_active) {
            return false;
        }

        $now = \Carbon\Carbon::now();
        $startTime = \Carbon\Carbon::parse($attendanceSetting->start_time);
        $endTime = \Carbon\Carbon::parse($attendanceSetting->end_time);

        return $now->between($startTime, $endTime);
    }

    /**
     * Method untuk tutup attendance setting yang expired
     * Bisa dijadikan scheduled job yang berjalan setiap menit
     */
    public function closeExpiredAttendance()
    {
        $now = \Carbon\Carbon::now();

        $expired = AttendanceSetting::where('is_active', true)
            ->where('end_time', '<', $now)
            ->get();

        foreach ($expired as $setting) {
            $setting->update([
                'is_active' => false,
                'updated_at' => $now
            ]);

            Log::info("Attendance setting #{$setting->id} auto-closed at {$now}");



        }

        return response()->json([
            'success' => true,
            'closed_count' => $expired->count(),
            'message' => "{$expired->count()} attendance settings have been closed."
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->autoDeactivateExpired();


        $validated = $request->validate([
            'participant_id' => 'required|exists:participants,id',
        ]);

        $now = \Carbon\Carbon::now(); //Gunakan Carbon untuk datetime penuh


        $activeSetting = AttendanceSetting::where('is_active', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->first();


        if (!$activeSetting) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Presensi belum dibuka atau sudah ditutup',
            ]);
        }


        $exists = Attendances::where('attendances_setting_id', $activeSetting->id)
            ->where('participant_id', $request->participant_id)
            ->exists();

        if ($exists) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Peserta sudah melakukan presensi sebelumnya.',
            ]);
        }

        try {

            Attendances::create([
                'attendances_setting_id' => $activeSetting->id,
                'participant_id'        => $request->participant_id,
                'method'                => 'manual',
                'attended_at'           => $now,
            ]);


            $participant = Participants::find($request->participant_id);

            return back()->with([
                'status'  => 'success',
                'message' => "Presensi {$participant->name} berhasil dicatat.",
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to store attendance: ' . $e->getMessage());

            return back()->with([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan presensi. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Auto-deactivate expired attendance settings
     */



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

    public function settingPage()
{

    $this->autoDeactivateExpired();

    $now = \Carbon\Carbon::now();


    $presensi = AttendanceSetting::where('is_active', true)
        ->where('start_time', '<=', $now)
        ->where('end_time', '>=', $now)
        ->first();


    if (!$presensi) {
        $presensi = AttendanceSetting::where('is_active', true)
            ->orderBy('start_time', 'desc')
            ->first();
    }


    $presensiLog = AttendanceSetting::latest()->take(10)->get();


    $peserta = Participants::all();


    $presensiAktif = false;

    if ($presensi) {
        $presensiAktif = true;
    }

    return view('admin.presensi.setting', compact(
        'presensi',
        'presensiAktif',
        'peserta',
        'presensiLog'
    ));
}

/**
 * Save/Activate attendance setting
 */
    public function setting(Request $request)
    {

        $this->autoDeactivateExpired();


        $validated = $request->validate([
            'start_time' => 'required|date|after_or_equal:now',
            'end_time'   => 'required|date|after:start_time',
        ], [
            'start_time.required' => 'Waktu mulai wajib diisi',
            'start_time.after_or_equal' => 'Waktu mulai tidak boleh di masa lalu',
            'end_time.required' => 'Waktu selesai wajib diisi',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai',
        ]);

        try {
            $startTime = \Carbon\Carbon::parse($validated['start_time']);
            $endTime = \Carbon\Carbon::parse($validated['end_time']);


            $durationInMinutes = $startTime->diffInMinutes($endTime);
            if ($durationInMinutes < 5) {
                return back()->withInput()->with([
                    'status' => 'error',
                    'message' => 'Durasi presensi minimal 5 menit',
                ]);
            }


            if ($durationInMinutes > 1440) { // 24 jam
                return back()->withInput()->with([
                    'status' => 'error',
                    'message' => 'Durasi presensi maksimal 24 jam',
                ]);
            }


            $overlapping = AttendanceSetting::where('is_active', true)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->exists();

            if ($overlapping) {
                return back()->withInput()->with([
                    'status' => 'error',
                    'message' => 'Waktu presensi bertabrakan dengan presensi aktif lainnya',
                ]);
            }

            DB::beginTransaction();


            AttendanceSetting::where('is_active', true)
                ->update(['is_active' => false]);



            $newSetting = AttendanceSetting::create([
                'start_time' => $startTime,
                'end_time'   => $endTime,
                'is_active'  => true,
            ]);


            Log::info('Attendance setting activated', [
                'id' => $newSetting->id,
                'start_time' => $startTime->toDateTimeString(),
                'end_time' => $endTime->toDateTimeString(),
                'duration_minutes' => $durationInMinutes,
            ]);

            DB::commit();

            return redirect()
                ->route('presensi.setting.page')
                ->with([
                    'status'  => 'success',
                    'message' => 'Presensi berhasil diaktifkan dari ' .
                                $startTime->format('d M Y H:i') . ' sampai ' .
                                $endTime->format('d M Y H:i'),
                ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to activate attendance setting', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengaktifkan presensi. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Ambil presensi yang sedang aktif (TIME AWARE)
     */
    public function active()
    {
        $this->autoDeactivateExpired();

        $now = now()->format('H:i:s');

        return AttendanceSetting::where('is_active', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->first();
    }

    public function nonaktif()
    {
        try {
            DB::beginTransaction();

            $activeSetting = AttendanceSetting::where('is_active', true)->first();

            if (!$activeSetting) {
                return back()->with([
                    'status' => 'error',
                    'message' => 'Tidak ada presensi yang aktif',
                ]);
            }


            $activeSetting->update(['is_active' => false]);


            Log::info('Attendance setting deactivated', [
                'id' => $activeSetting->id,
            ]);

            DB::commit();

            return redirect()
                ->route('presensi.setting.page')
                ->with([
                    'status'  => 'success',
                    'message' => 'Presensi berhasil dinonaktifkan',
                ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to deactivate attendance setting: ' . $e->getMessage());

            return back()->with([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menonaktifkan presensi',
            ]);
        }
    }

    private function autoDeactivateExpired()
    {
        $now = \Carbon\Carbon::now();

        $deactivated = AttendanceSetting::where('is_active', true)
            ->where('end_time', '<', $now)
            ->update([
                'is_active' => false,
                'updated_at' => $now
            ]);

        if ($deactivated > 0) {
            Log::info("Auto-deactivated {$deactivated} expired attendance settings");
        }

        return $deactivated;
    }

}
