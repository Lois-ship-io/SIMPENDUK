@extends('layouts.app')

@section('title', 'Tambah Wilayah')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('wilayah.store') }}" method="POST">
        @csrf
        <x-card title="Tambah Wilayah Baru" description="Masukkan data wilayah (RT/RW) dan nama ketua RT.">
            
            <div class="space-y-6">
                <div>
                    <x-label for="nama">Nama Wilayah (Wajib: RT 001/RW 004)</x-label>
                    <x-input id="nama" name="nama" value="{{ old('nama') }}" required :error="$errors->has('nama')" placeholder="RT 001/RW 004" />
                    <x-error :messages="$errors->get('nama')" />
                </div>

                <div>
                    <x-label for="ketua_rt">Nama Ketua RT</x-label>
                    <x-input id="ketua_rt" name="ketua_rt" value="{{ old('ketua_rt') }}" required :error="$errors->has('ketua_rt')" />
                    <x-error :messages="$errors->get('ketua_rt')" />
                </div>
            </div>

            <x-slot:footer>
                <a href="{{ route('wilayah.index') }}" class="mr-3">
                    <x-button variant="secondary">Batal</x-button>
                </a>
                <x-button type="submit" variant="primary">Simpan Wilayah</x-button>
            </x-slot:footer>
        </x-card>
    </form>
</div>
@endsection
