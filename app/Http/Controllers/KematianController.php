<?php

namespace App\Http\Controllers;

use App\Models\Kematian;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KematianController extends Controller
{
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $user = Auth::user();
        
        $query = Kematian::whereIn('id', $ids);
        if ($user->role === 'RT') {
            $query->whereHas('penduduk', function($q) use ($user) {
                $q->where('wilayah_id', $user->wilayah_id);
            });
        }
        
        $kematians = $query->get();
        foreach ($kematians as $kematian) {
            $kematian->penduduk->update(['status' => 'HIDUP']);
            $kematian->delete();
        }

        return back()->with('success', 'Data kematian yang dipilih berhasil dihapus dan status penduduk dikembalikan.');
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Kematian::with('penduduk.wilayah');

        if ($user->role === 'RT') {
            $query->whereHas('penduduk', function($q) use ($user) {
                $q->where('wilayah_id', $user->wilayah_id);
            });
        }

        $rtFilter = $request->get('rt_filter');
        if ($rtFilter && $user->role !== 'RT') {
            $query->whereHas('penduduk', function($q) use ($rtFilter) {
                $q->where('wilayah_id', $rtFilter);
            });
        }

        $kematians = $query->latest()->get();

        $sort = $request->get('sort');
        if ($sort === 'asc') {
            $kematians = $kematians->sortBy(function($k) {
                return $k->penduduk->nama;
            })->values();
        } elseif ($sort === 'desc') {
            $kematians = $kematians->sortByDesc(function($k) {
                return $k->penduduk->nama;
            })->values();
        }
        
        $wilayahs = collect();
        if ($user->role !== 'RT') {
            $wilayahs = \App\Models\Wilayah::orderBy('nama')->get();
        }

        return view('kematian.index', compact('kematians', 'wilayahs', 'rtFilter'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $query = Penduduk::where('status', 'HIDUP');
        $wilayahs = collect();
        $rtFilter = $request->get('rt_filter');

        if ($user->role === 'RT') {
            $query->where('wilayah_id', $user->wilayah_id);
        } else {
            $wilayahs = \App\Models\Wilayah::orderBy('nama')->get();
            if ($rtFilter) {
                $query->where('wilayah_id', $rtFilter);
            }
        }

        $penduduks = $query->get();

        return view('kematian.create', compact('penduduks', 'wilayahs', 'rtFilter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduks,id',
            'tanggal_kematian' => 'required|date',
            'penyebab_kematian' => 'required|string|max:255',
            'tempat_kematian' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $penduduk = Penduduk::findOrFail($request->penduduk_id);
        
        $user = Auth::user();
        if ($user->role === 'RT' && $penduduk->wilayah_id !== $user->wilayah_id) {
            abort(403);
        }

        Kematian::create($validated);
        $penduduk->update(['status' => 'MATI']);

        return redirect()->route('kematian.index')->with('success', 'Data kematian berhasil ditambahkan.');
    }

    public function edit(Kematian $kematian)
    {
        $user = Auth::user();
        if ($user->role === 'RT' && $kematian->penduduk->wilayah_id !== $user->wilayah_id) {
            abort(403);
        }

        return view('kematian.edit', compact('kematian'));
    }

    public function update(Request $request, Kematian $kematian)
    {
        $user = Auth::user();
        if ($user->role === 'RT' && $kematian->penduduk->wilayah_id !== $user->wilayah_id) {
            abort(403);
        }

        $validated = $request->validate([
            'tanggal_kematian' => 'required|date',
            'penyebab_kematian' => 'required|string|max:255',
            'tempat_kematian' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $kematian->update($validated);
        return redirect()->route('kematian.index')->with('success', 'Data kematian berhasil diperbarui.');
    }

    public function destroy(Kematian $kematian)
    {
        $user = Auth::user();
        if ($user->role === 'RT' && $kematian->penduduk->wilayah_id !== $user->wilayah_id) {
            abort(403);
        }

        $kematian->penduduk->update(['status' => 'HIDUP']);
        $kematian->delete();

        return redirect()->route('kematian.index')->with('success', 'Data kematian berhasil dihapus dan status penduduk dikembalikan.');
    }
}
