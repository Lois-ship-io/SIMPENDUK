@extends('layouts.app')

@section('title', 'Edit Wilayah')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('wilayah.update', $wilayah->id) }}" method="POST">
        @csrf @method('PUT')
        <x-card title="Edit Data Wilayah" description="Perbarui informasi nama wilayah atau ketua RT.">
            
            <div class="space-y-6">
                <div>
                    <x-label for="nama">Nama Wilayah (Wajib: RT 001/RW 004)</x-label>
                    <x-input id="nama" name="nama" value="{{ old('nama', $wilayah->nama) }}" required :error="$errors->has('nama')" placeholder="RT 001/RW 004" />
                    <x-error :messages="$errors->get('nama')" />
                </div>

                <div>
                    <x-label for="ketua_rt">Nama Ketua RT</x-label>
                    <x-input id="ketua_rt" name="ketua_rt" value="{{ old('ketua_rt', $wilayah->ketua_rt) }}" required :error="$errors->has('ketua_rt')" />
                    <x-error :messages="$errors->get('ketua_rt')" />
                </div>
            </div>

            <x-slot:footer>
                <a href="{{ route('wilayah.index') }}" class="mr-3">
                    <x-button variant="secondary">Batal</x-button>
                </a>
                <x-button type="submit" variant="primary">Simpan Perubahan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
</div>
@endsection
