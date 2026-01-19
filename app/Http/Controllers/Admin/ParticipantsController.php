<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participants;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Participants::with('attendances');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('attendances', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // 🎯 Filter: Jenis Kelamin
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // ↕️ Sorting
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest(); // default: created_at desc
                break;
        }

        $participants = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.peserta.index', compact('participants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.peserta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:P,L',
        ]);

        try{
            $participant = new Participants();
            $participant->name = $request->name;
            $participant->gender = $request->gender;
            $participant->save();

            return redirect()->route('peserta.index')->with([
                'status' => 'success',
                'message' => 'Peserta berhasil ditambahkan.'
            ]);
        }catch(\Exception $e){
            return redirect()->route('peserta.index')
                ->with([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan peserta: ' . $e->getMessage(),
                    'code' => 500,
                ]
            );
        }
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
        $participants = Participants::findOrFail($id);
        return view('admin.peserta.edit', compact('participants', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:P,L',
        ]);

        try{
            $participant = Participants::findOrFail($id);
            $participant->name = $request->name;
            $participant->gender = $request->gender;
            $participant->save();
            return redirect()->route('peserta.index')->with([
                'status' => 'success',
                'message' => 'Peserta berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('peserta.index')
                ->with(
                    [
                        'status' => 'error',
                        'message' => 'Gagal memperbarui peserta: ' . $e->getMessage(),
                        'code' => 500,
                    ]
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $participant = Participants::findOrFail($id);
            $participant->delete();

            return redirect()->route('peserta.index')->with([
                'status' => 'success',
                'message' => 'Peserta berhasil dihapus.'
            ]);
        }catch(\Exception $e){
            return redirect()->route('peserta.index')
                ->with([
                    'status' => 'error',
                    'message' => 'Gagal menghapus peserta: ' . $e->getMessage(),
                    'code' => 500,
                ]
            );
        }
    }
}
