<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Auth;

class PendudukController extends Controller
{
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $user = Auth::user();
        if ($user->role === 'RT') {
            Penduduk::whereIn('id', $ids)->where('wilayah_id', $user->wilayah_id)->delete();
        } else {
            Penduduk::whereIn('id', $ids)->delete();
        }

        return back()->with('success', 'Data penduduk yang dipilih berhasil dihapus.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Penduduk::with('wilayah');

        if ($user->role === 'RT') {
            $query->where('wilayah_id', $user->wilayah_id);
            $wilayahs = collect();
        } else {
            $wilayahs = Wilayah::orderBy('nama', 'asc')->get();
            if ($request->filled('wilayah_id')) {
                $query->where('wilayah_id', $request->wilayah_id);
            }
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%')
                  ->orWhere('no_kk', 'like', '%' . $request->search . '%');
            });
        }

        $perPage = $request->input('per_page', 10);
        $allowedPerPage = [10, 20, 50, 100, 1000];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $sort = $request->get('sort', 'latest');
        if ($sort === 'asc') {
            $query->orderBy('nama', 'asc');
        } elseif ($sort === 'desc') {
            $query->orderBy('nama', 'desc');
        } else {
            $query->latest();
        }

        $penduduks = $query->paginate($perPage)->withQueryString();
        return view('penduduk.index', compact('penduduks', 'wilayahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        if ($user->role === 'RT') {
            $wilayahs = Wilayah::where('id', $user->wilayah_id)->get();
        } else {
            $wilayahs = Wilayah::orderBy('nama', 'asc')->get();
        }

        return view('penduduk.create', compact('wilayahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePendudukRequest $request)
    {
        $user = Auth::user();
        
        // Ensure RT can only add to their wilayah
        if ($user->role === 'RT' && (int)$request->wilayah_id !== $user->wilayah_id) {
            abort(403, 'Anda tidak berhak menambahkan penduduk di wilayah ini.');
        }

        Penduduk::create($request->validated());

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penduduk $penduduk)
    {
        $user = Auth::user();
        if ($user->role === 'RT' && $penduduk->wilayah_id !== $user->wilayah_id) {
            abort(403);
        }

        return view('penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penduduk $penduduk)
    {
        $user = Auth::user();
        if ($user->role === 'RT' && $penduduk->wilayah_id !== $user->wilayah_id) {
            abort(403);
        }

        if ($user->role === 'RT') {
            $wilayahs = Wilayah::where('id', $user->wilayah_id)->get();
        } else {
            $wilayahs = Wilayah::orderBy('nama', 'asc')->get();
        }

        return view('penduduk.edit', compact('penduduk', 'wilayahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePendudukRequest $request, Penduduk $penduduk)
    {
        $user = Auth::user();
        if ($user->role === 'RT' && $penduduk->wilayah_id !== $user->wilayah_id) {
            abort(403);
        }

        if ($user->role === 'RT' && (int)$request->wilayah_id !== $user->wilayah_id) {
            abort(403, 'Anda tidak berhak memindahkan penduduk ke wilayah ini.');
        }

        $penduduk->update($request->validated());

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penduduk $penduduk)
    {
        $user = Auth::user();
        if ($user->role === 'RT' && $penduduk->wilayah_id !== $user->wilayah_id) {
            abort(403);
        }

        $penduduk->delete();

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }
}
