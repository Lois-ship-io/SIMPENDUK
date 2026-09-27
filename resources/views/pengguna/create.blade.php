@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('pengguna.store') }}" method="POST" x-data="{ role: '{{ old('role', 'RT') }}' }">
        @csrf
        <x-card title="Tambah Pengguna Baru" description="Silakan isi form di bawah ini untuk menambahkan akun pengguna baru.">
            
            <div class="space-y-6">
                <div>
                    <x-label for="name">Nama Lengkap</x-label>
                    <x-input id="name" name="name" value="{{ old('name') }}" required :error="$errors->has('name')" />
                    <x-error :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-label for="email">Email Login</x-label>
                    <x-input id="email" name="email" type="email" value="{{ old('email') }}" required pattern="[a-zA-Z0-9]+@simpenduk\.com" title="Email harus berakhiran @simpenduk.com dan hanya boleh berisi huruf serta angka." :error="$errors->has('email')" />
                    <x-error :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-label for="password">Password</x-label>
                    <x-input id="password" name="password" type="password" required :error="$errors->has('password')" />
                    <x-error :messages="$errors->get('password')" />
                </div>

                <div>
                    <x-label for="role">Peran / Role</x-label>
                    <x-select id="role" name="role" x-model="role" required :error="$errors->has('role')">
                        <option value="SuperAdmin">SuperAdmin</option>
                        <option value="Admin">Admin</option>
                        <option value="RT">RT</option>
                    </x-select>
                    <x-error :messages="$errors->get('role')" />
                </div>

                <div x-show="role === 'RT'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <x-label for="wilayah_id">Wilayah Penugasan (Hanya untuk RT)</x-label>
                    <x-select id="wilayah_id" name="wilayah_id" x-bind:required="role === 'RT'" :error="$errors->has('wilayah_id')">
                        <option value="">-- Pilih Wilayah --</option>
                        @foreach($wilayahs as $w)
                            <option value="{{ $w->id }}" {{ old('wilayah_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->nama }} ({{ $w->ketua_rt }})
                            </option>
                        @endforeach
                    </x-select>
                    <x-error :messages="$errors->get('wilayah_id')" />
                </div>
            </div>

            <x-slot:footer>
                <a href="{{ route('pengguna.index') }}" class="mr-3">
                    <x-button variant="secondary">Batal</x-button>
                </a>
                <x-button type="submit" variant="primary">Simpan Pengguna</x-button>
            </x-slot:footer>
        </x-card>
    </form>
</div>
@endsection
