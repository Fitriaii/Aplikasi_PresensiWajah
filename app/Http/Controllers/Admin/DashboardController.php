<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\AttendanceSetting;
use App\Models\Participants;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeSession = AttendanceSetting::where('is_active', true)
            ->latest()
            ->first();

        $totalPeserta = Participants::count();

        $totalHadir = $activeSession
            ? Attendances::where('attendances_setting_id', $activeSession->id)->count()
            : 0;

        $totalBelumHadir = $totalPeserta - $totalHadir;

        // ✅ Persentase Kehadiran
        $persentaseHadir = $totalPeserta > 0
            ? round(($totalHadir / $totalPeserta) * 100, 1)
            : 0;

        $attendanceLogs = Attendances::with([
                'participant:id,name',
                'attendanceSetting:id,start_time,end_time,created_at'
            ])
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact(
            'activeSession',
            'totalPeserta',
            'totalHadir',
            'totalBelumHadir',
            'persentaseHadir',
            'attendanceLogs'
        ));
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
