<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        User::whereIn('id', $ids)
            ->where('id', '!=', auth()->id())
            ->where('role', '!=', 'SuperAdmin')
            ->delete();

        return back()->with('success', 'Data pengguna yang dipilih berhasil dihapus.');
    }

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'latest');
        $query = User::with('wilayah');

        if ($sort === 'asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'desc') {
            $query->orderBy('name', 'desc');
        } else {
            $query->latest();
        }

        $penggunas = $query->get();
        return view('pengguna.index', compact('penggunas', 'sort'));
    }

    public function create()
    {
        $wilayahs = Wilayah::whereDoesntHave('users')->orderBy('nama', 'asc')->get();
        return view('pengguna.create', compact('wilayahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\,\']+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9]+@simpenduk\.com$/'],
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['SuperAdmin', 'Admin', 'RT'])],
            'wilayah_id' => 'required_if:role,RT|nullable|exists:wilayahs,id|unique:users,wilayah_id',
        ], [
            'name.regex' => 'Nama pengguna hanya boleh berisi huruf dan spasi.',
            'email.regex' => 'Email harus berakhiran @simpenduk.com dan hanya boleh berisi huruf dan angka (tanpa simbol).',
            'wilayah_id.unique' => 'Wilayah RT ini sudah ditugaskan kepada pengguna lain.'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        if ($validated['role'] !== 'RT') {
            $validated['wilayah_id'] = null;
        }

        User::create($validated);
        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil ditambahkan.');
    }

    public function show(User $pengguna)
    {
        //
    }

    public function edit(User $pengguna)
    {
        $wilayahs = Wilayah::whereDoesntHave('users', function ($query) use ($pengguna) {
            $query->where('id', '!=', $pengguna->id);
        })->orderBy('nama', 'asc')->get();
        return view('pengguna.edit', compact('pengguna', 'wilayahs'));
    }

    public function update(Request $request, User $pengguna)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\,\']+$/'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pengguna->id), 'regex:/^[a-zA-Z0-9]+@simpenduk\.com$/'],
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(['SuperAdmin', 'Admin', 'RT'])],
            'wilayah_id' => [
                'required_if:role,RT',
                'nullable',
                'exists:wilayahs,id',
                Rule::unique('users')->ignore($pengguna->id)
            ],
        ], [
            'name.regex' => 'Nama pengguna hanya boleh berisi huruf dan spasi.',
            'email.regex' => 'Email harus berakhiran @simpenduk.com dan hanya boleh berisi huruf dan angka (tanpa simbol).',
            'wilayah_id.unique' => 'Wilayah RT ini sudah ditugaskan kepada pengguna lain.'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($validated['role'] !== 'RT') {
            $validated['wilayah_id'] = null;
        }

        $pengguna->update($validated);
        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return redirect()->route('pengguna.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $pengguna->delete();
        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
