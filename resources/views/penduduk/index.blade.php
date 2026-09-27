@extends('layouts.app')

@section('title', 'Data Penduduk')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Penduduk</h2>
        <p class="mt-1 text-sm text-gray-500 font-medium">Kelola informasi data warga yang terdaftar di SIMPENDUK.</p>
    </div>
    <div class="flex-shrink-0">
        <a href="{{ route('penduduk.create') }}" class="w-full sm:w-auto inline-flex">
            <x-button variant="primary" class="w-full sm:w-auto justify-center">
                Tambah Penduduk
            </x-button>
        </a>
    </div>
</div>

<!-- Table -->
<x-card>
    <div class="mb-6">
        <form action="{{ route('penduduk.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">
            <select name="per_page" id="per_page" onchange="this.form.submit()" class="rounded-lg border-0 py-2 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 bg-white cursor-pointer hover:bg-gray-50 transition-colors">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
            </select>
            @if(auth()->user()->role !== 'RT')
            <select name="wilayah_id" id="wilayah_id" onchange="this.form.submit()" class="rounded-lg border-0 py-2 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 bg-white cursor-pointer hover:bg-gray-50 transition-colors">
                <option value="">Semua RT</option>
                @foreach($wilayahs as $wilayah)
                    <option value="{{ $wilayah->id }}" {{ request('wilayah_id') == $wilayah->id ? 'selected' : '' }}>{{ $wilayah->nama }}</option>
                @endforeach
            </select>
            @endif
            
            <div class="relative w-64">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" id="search" class="block w-full rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Cari NIK, KK, atau Nama..." value="{{ request('search') }}">
            </div>
            
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                Cari
            </button>
            @if(request()->filled('search'))
            <a href="{{ route('penduduk.index') }}" class="inline-flex items-center justify-center rounded-lg bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 shadow-sm ring-1 ring-inset ring-red-300 hover:bg-red-100 transition-colors">
                Reset
            </a>
            @endif
        </form>
    </div>
    <div class="overflow-x-auto -mx-6 border-t border-gray-100" x-data="{ selectedIds: [] }">
        <!-- Action Bar -->
        <div x-show="selectedIds.length > 0" style="display: none;" class="bg-blue-50 px-6 py-3 border-b border-blue-100 flex items-center justify-between sticky left-0 z-10">
            <span class="text-sm font-medium text-blue-800"><span x-text="selectedIds.length"></span> data dipilih</span>
            <form action="{{ route('penduduk.bulkDestroy') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <template x-for="id in selectedIds" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="submit" onclick="return confirm('Yakin ingin menghapus data yang dipilih?')" class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                    </svg>
                    Hapus Terpilih
                </button>
            </form>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50/80">
                <tr>
                    <th scope="col" class="px-6 py-3 w-10 text-center">
                        @if($penduduks->count() > 0)
                        <input type="checkbox" 
                               @change="selectedIds = $event.target.checked ? {{ $penduduks->pluck('id')->toJson() }} : []"
                               :checked="selectedIds.length > 0 && selectedIds.length === {{ $penduduks->count() }}"
                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 cursor-pointer">
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') === 'asc' ? 'desc' : 'asc']) }}" class="group inline-flex items-center hover:text-gray-700 transition-colors">
                            Penduduk
                            <span class="ml-1 flex-none rounded bg-transparent text-gray-400 group-hover:bg-gray-200 group-hover:text-gray-900 transition-colors">
                                @if(request('sort') === 'asc')
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                @elseif(request('sort') === 'desc')
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIK / No KK</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Wilayah</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($penduduks as $p)
                <tr class="hover:bg-gray-50 transition-colors duration-150" :class="selectedIds.includes({{ $p->id }}) ? 'bg-blue-50/50' : ''">
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="checkbox" value="{{ $p->id }}" x-model="selectedIds" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 cursor-pointer">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 border border-blue-300 flex items-center justify-center text-blue-700 font-bold shadow-sm">
                                    {{ substr($p->nama, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $p->nama }}</div>
                                <div class="text-xs text-gray-500">{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} tahun</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">NIK: {{ $p->nik }}</div>
                        <div class="text-xs text-gray-500">KK: {{ $p->no_kk }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $p->wilayah->nama }}</div>
                        <div class="text-xs text-gray-500">{{ $p->kelurahan }}, {{ $p->kecamatan }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($p->status == 'HIDUP')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                HIDUP
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                MATI
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('penduduk.show', $p->id) }}" class="text-gray-500 hover:text-gray-900 transition-colors" title="Detail">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('penduduk.edit', $p->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('penduduk.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penduduk ini? Data terkait mungkin juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Hapus">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                            </svg>
                            <p class="text-sm font-medium">Belum ada data penduduk</p>
                            <p class="text-xs text-gray-400 mt-1">Silakan tambahkan data penduduk baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($penduduks->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $penduduks->links() }}
    </div>
    @endif
</x-card>
@endsection
