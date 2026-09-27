@extends('layouts.app')

@section('title', 'Detail Penduduk')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ route('penduduk.index') }}" class="mr-4 text-gray-500 hover:text-gray-900 transition-colors bg-white rounded-full p-2 shadow-sm border border-gray-100 hover:shadow">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Penduduk</h2>
            <p class="mt-1 text-sm text-gray-500">Informasi lengkap kependudukan untuk NIK: <span class="font-semibold text-gray-700">{{ $penduduk->nik }}</span>.</p>
        </div>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-3">
        <a href="{{ route('penduduk.edit', $penduduk->id) }}">
            <x-button variant="secondary">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Data
            </x-button>
        </a>
    </div>
</div>

<x-card>
    <div class="p-2 sm:p-4 space-y-8">
        
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-6">
            <div class="flex items-center">
                <div class="h-20 w-20 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 border border-blue-300 flex items-center justify-center text-blue-700 text-3xl font-bold shadow-sm">
                    {{ substr($penduduk->nama, 0, 1) }}
                </div>
                <div class="ml-6">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $penduduk->nama }}</h3>
                    <p class="text-sm text-gray-500 mt-1">NO KK: <span class="font-medium text-gray-700">{{ $penduduk->no_kk }}</span> &bull; NIK: <span class="font-medium text-gray-700">{{ $penduduk->nik }}</span></p>
                </div>
            </div>
            <div class="mt-4 sm:mt-0">
                @if($penduduk->status == 'HIDUP')
                    <span class="inline-flex items-center rounded-md bg-green-50 px-4 py-2 text-sm font-bold text-green-700 border border-green-200 shadow-sm">Status: HIDUP</span>
                @else
                    <span class="inline-flex items-center rounded-md bg-red-50 px-4 py-2 text-sm font-bold text-red-700 border border-red-200 shadow-sm">Status: MATI</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Data Diri -->
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Data Diri</h4>
                <dl class="space-y-4">
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Tempat, Tgl Lahir</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y') }} <span class="text-gray-500 font-normal">({{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age }} tahun)</span></dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Agama</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->agama }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Status Perkawinan</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->status_perkawinan }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->pekerjaan }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Kewarganegaraan</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->kewarganegaraan }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Kontak & Domisili -->
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Kontak & Domisili</h4>
                <dl class="space-y-4">
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Alamat Lengkap</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->alamat }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Wilayah (RT/RW)</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $penduduk->wilayah->nama }}
                            </span>
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Kel/Desa</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->kelurahan }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-50 pb-3">
                        <dt class="text-sm font-medium text-gray-500">Kecamatan</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->kecamatan }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                        <dd class="text-sm font-semibold text-gray-900 col-span-2">{{ $penduduk->no_telepon ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
</x-card>
@endsection
