<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        Wilayah::whereIn('id', $ids)->delete();

        return back()->with('success', 'Data wilayah yang dipilih berhasil dihapus.');
    }

    public function index()
    {
        $wilayahs = Wilayah::withCount('penduduks')->orderBy('nama', 'asc')->get();
        return view('wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        return view('wilayah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:wilayahs,nama', 'regex:/^RT \d{3}\/RW \d{3}$/'],
            'ketua_rt' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\,\']+$/'],
        ], [
            'nama.regex' => 'Format nama wilayah harus sesuai dengan pola "RT 001/RW 004" (huruf besar, pakai spasi, dan 3 digit angka).',
            'ketua_rt.regex' => 'Nama ketua RT hanya boleh berisi huruf dan spasi.'
        ]);

        Wilayah::create($validated);
        return redirect()->route('wilayah.index')->with('success', 'Data wilayah berhasil ditambahkan.');
    }

    public function edit(Wilayah $wilayah)
    {
        return view('wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:wilayahs,nama,' . $wilayah->id, 'regex:/^RT \d{3}\/RW \d{3}$/'],
            'ketua_rt' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\,\']+$/'],
        ], [
            'nama.regex' => 'Format nama wilayah harus sesuai dengan pola "RT 001/RW 004" (huruf besar, pakai spasi, dan 3 digit angka).',
            'ketua_rt.regex' => 'Nama ketua RT hanya boleh berisi huruf dan spasi.'
        ]);

        $wilayah->update($validated);
        return redirect()->route('wilayah.index')->with('success', 'Data wilayah berhasil diperbarui.');
    }

    public function destroy(Wilayah $wilayah)
    {
        if ($wilayah->penduduks()->count() > 0) {
            return redirect()->route('wilayah.index')->with('error', 'Wilayah tidak dapat dihapus karena masih memiliki data penduduk.');
        }

        if ($wilayah->users()->count() > 0) {
            return redirect()->route('wilayah.index')->with('error', 'Wilayah tidak dapat dihapus karena masih terhubung dengan akun pengguna (RT).');
        }

        $wilayah->delete();
        return redirect()->route('wilayah.index')->with('success', 'Data wilayah berhasil dihapus.');
    }
}
