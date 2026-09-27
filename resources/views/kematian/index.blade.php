@extends('layouts.app')

@section('title', 'Data Kematian')

@section('content')
<div class="mb-8 sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Catatan Data Kematian</h2>
        <p class="mt-2 text-sm text-gray-500 font-medium">Rekap data penduduk yang telah meninggal dunia.</p>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-3">
        <a href="{{ route('kematian.create') }}">
            <x-button variant="primary">
                Catat Kematian Baru
            </x-button>
        </a>
    </div>
</div>

<x-card>

    @if(auth()->user()->role !== 'RT' && isset($wilayahs) && $wilayahs->count() > 0)
    <div class="mb-6">
        <form action="{{ route('kematian.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">
            <select name="rt_filter" id="rt_filter" onchange="this.form.submit()" class="rounded-lg border-0 py-2 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 bg-white cursor-pointer hover:bg-gray-50 transition-colors">
                <option value="">Semua Wilayah</option>
                @foreach($wilayahs as $w)
                    <option value="{{ $w->id }}" {{ $rtFilter == $w->id ? 'selected' : '' }}>{{ $w->nama }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @endif

    <div class="overflow-x-auto -mx-6" x-data="{ selectedIds: [] }">
        <!-- Action Bar -->
        <div x-show="selectedIds.length > 0" style="display: none;" class="bg-blue-50 px-6 py-3 border-b border-blue-100 flex items-center justify-between sticky left-0 z-10">
            <span class="text-sm font-medium text-blue-800"><span x-text="selectedIds.length"></span> data dipilih</span>
            <form action="{{ route('kematian.bulkDestroy') }}" method="POST" class="inline">
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
                        @if($kematians->count() > 0)
                        <input type="checkbox" 
                               @change="selectedIds = $event.target.checked ? {{ $kematians->pluck('id')->toJson() }} : []"
                               :checked="selectedIds.length > 0 && selectedIds.length === {{ $kematians->count() }}"
                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 cursor-pointer">
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') === 'asc' ? 'desc' : 'asc']) }}" class="group inline-flex items-center hover:text-gray-700 transition-colors">
                            Nama / NIK
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Kematian</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Penyebab & Tempat</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($kematians as $k)
                <tr class="hover:bg-gray-50 transition-colors duration-150" :class="selectedIds.includes({{ $k->id }}) ? 'bg-blue-50/50' : ''">
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="checkbox" value="{{ $k->id }}" x-model="selectedIds" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 cursor-pointer">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900">{{ $k->penduduk->nama }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">NIK: {{ $k->penduduk->nik }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($k->tanggal_kematian)->translatedFormat('d F Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-red-600">{{ $k->penyebab_kematian }}</div>
                        <div class="text-xs text-gray-500 mt-0.5"><span class="font-medium">Tempat:</span> {{ $k->tempat_kematian }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('kematian.edit', $k->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('kematian.destroy', $k->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data kematian ini? Status penduduk akan kembali hidup.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Batalkan">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-500">Belum ada catatan kematian.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection
