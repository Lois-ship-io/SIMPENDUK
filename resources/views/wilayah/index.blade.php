@extends('layouts.app')

@section('title', 'Data Wilayah')

@section('content')
<div class="mb-8 sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Wilayah</h2>
        <p class="mt-2 text-sm text-gray-500 font-medium">Kelola informasi RT/RW di wilayah ini.</p>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-3">
        <a href="{{ route('wilayah.create') }}">
            <x-button variant="primary">
                Tambah Wilayah
            </x-button>
        </a>
    </div>
</div>

<x-card>

    <div class="overflow-x-auto -mx-6 -mt-6" x-data="{ selectedIds: [] }">
        <!-- Action Bar -->
        <div x-show="selectedIds.length > 0" style="display: none;" class="bg-blue-50 px-6 py-3 border-b border-blue-100 flex items-center justify-between sticky left-0 z-10">
            <span class="text-sm font-medium text-blue-800"><span x-text="selectedIds.length"></span> data dipilih</span>
            <form action="{{ route('wilayah.bulkDestroy') }}" method="POST" class="inline">
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
                        @if($wilayahs->count() > 0)
                        <input type="checkbox" 
                               @change="selectedIds = $event.target.checked ? {{ $wilayahs->pluck('id')->toJson() }} : []"
                               :checked="selectedIds.length > 0 && selectedIds.length === {{ $wilayahs->count() }}"
                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 cursor-pointer">
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Wilayah (RT/RW)</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ketua RT</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Penduduk</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($wilayahs as $w)
                <tr class="hover:bg-gray-50 transition-colors duration-150" :class="selectedIds.includes({{ $w->id }}) ? 'bg-blue-50/50' : ''">
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="checkbox" value="{{ $w->id }}" x-model="selectedIds" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 cursor-pointer">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            {{ $w->nama }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                        {{ $w->ketua_rt }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $w->penduduks_count }} Jiwa
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('wilayah.edit', $w->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('wilayah.destroy', $w->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus wilayah ini? Pastikan wilayah tidak memiliki data penduduk atau akun pengguna terkait.');">
                                @csrf @method('DELETE')
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
                    <td colspan="5" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <p class="text-sm font-medium text-gray-500">Belum ada data wilayah.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection
