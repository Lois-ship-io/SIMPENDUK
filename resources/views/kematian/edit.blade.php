@extends('layouts.app')

@section('title', 'Edit Data Kematian')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('kematian.update', $kematian->id) }}" method="POST">
        @csrf @method('PUT')
    <x-card title="Edit Data Kematian" description="Perbarui rincian informasi kematian penduduk.">
        
        <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Informasi Penduduk:</h4>
            <div class="flex items-center">
                <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold border border-red-200">
                    {{ substr($kematian->penduduk->nama, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-gray-900">{{ $kematian->penduduk->nama }}</p>
                    <p class="text-xs text-gray-500">NIK: {{ $kematian->penduduk->nik }}</p>
                </div>
            </div>
        </div>
            
            <div class="space-y-6">
                <div>
                    <x-label for="tanggal_kematian">Tanggal Kematian</x-label>
                    <x-input id="tanggal_kematian" name="tanggal_kematian" type="date" value="{{ old('tanggal_kematian', \Carbon\Carbon::parse($kematian->tanggal_kematian)->format('Y-m-d')) }}" required :error="$errors->has('tanggal_kematian')" />
                    <x-error :messages="$errors->get('tanggal_kematian')" />
                </div>

                <div>
                    <x-label for="penyebab_kematian">Penyebab Kematian</x-label>
                    <x-input id="penyebab_kematian" name="penyebab_kematian" value="{{ old('penyebab_kematian', $kematian->penyebab_kematian) }}" required :error="$errors->has('penyebab_kematian')" />
                    <x-error :messages="$errors->get('penyebab_kematian')" />
                </div>

                <div>
                    <x-label for="tempat_kematian">Tempat Kematian</x-label>
                    <x-input id="tempat_kematian" name="tempat_kematian" value="{{ old('tempat_kematian', $kematian->tempat_kematian) }}" required :error="$errors->has('tempat_kematian')" />
                    <x-error :messages="$errors->get('tempat_kematian')" />
                </div>
                
                <div>
                    <x-label for="keterangan">Keterangan Tambahan (Opsional)</x-label>
                    <textarea id="keterangan" name="keterangan" rows="3" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3">{{ old('keterangan', $kematian->keterangan) }}</textarea>
                    <x-error :messages="$errors->get('keterangan')" />
                </div>
            </div>

            <x-slot:footer>
                <a href="{{ route('kematian.index') }}" class="mr-3">
                    <x-button variant="secondary">Batal</x-button>
                </a>
                <x-button type="submit" variant="primary">Simpan Perubahan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
</div>
@endsection
