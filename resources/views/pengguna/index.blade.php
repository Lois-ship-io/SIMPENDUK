@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('content')
<div class="mb-8 sm:flex sm:items-center sm:justify-between">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Pengguna</h2>
        <p class="mt-2 text-sm text-gray-500 font-medium">Kelola akun dan hak akses pengguna sistem.</p>
    </div>
    <div class="mt-4 sm:mt-0 flex items-center space-x-3">
        <form method="GET" action="{{ route('pengguna.index') }}" class="flex items-center">
            <label for="sort" class="sr-only">Urutkan</label>
            <select name="sort" id="sort" onchange="this.form.submit()" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3 border bg-white cursor-pointer transition-colors text-gray-700">
                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ $sort === 'asc' ? 'selected' : '' }}>Abjad (A - Z)</option>
                <option value="desc" {{ $sort === 'desc' ? 'selected' : '' }}>Abjad (Z - A)</option>
            </select>
        </form>
        <a href="{{ route('pengguna.create') }}">
            <x-button variant="primary">
                Tambah Pengguna
            </x-button>
        </a>
    </div>
</div>

<x-card>

    <div class="overflow-x-auto -mx-6 -mt-6" x-data="{ selectedIds: [] }">
        <!-- Action Bar -->
        <div x-show="selectedIds.length > 0" style="display: none;" class="bg-blue-50 px-6 py-3 border-b border-blue-100 flex items-center justify-between sticky left-0 z-10">
            <span class="text-sm font-medium text-blue-800"><span x-text="selectedIds.length"></span> data dipilih</span>
            <form action="{{ route('pengguna.bulkDestroy') }}" method="POST" class="inline">
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
                        @php
                            $selectableIds = $penggunas->filter(fn($u) => $u->role !== 'SuperAdmin' && $u->id !== auth()->id())->pluck('id');
                        @endphp
                        @if($selectableIds->count() > 0)
                        <input type="checkbox" 
                               @change="selectedIds = $event.target.checked ? {{ $selectableIds->toJson() }} : []"
                               :checked="selectedIds.length > 0 && selectedIds.length === {{ $selectableIds->count() }}"
                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 cursor-pointer">
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Wilayah (RT)</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($penggunas as $user)
                <tr class="hover:bg-gray-50 transition-colors duration-150" :class="selectedIds.includes({{ $user->id }}) ? 'bg-blue-50/50' : ''">
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($user->role !== 'SuperAdmin' && $user->id !== auth()->id())
                        <input type="checkbox" value="{{ $user->id }}" x-model="selectedIds" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 cursor-pointer">
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 border border-blue-300 flex items-center justify-center text-blue-700 font-bold shadow-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $roleColors = [
                                'SuperAdmin' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                'Admin' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'RT' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            ];
                            $badgeClass = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        @endphp
                        <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold border {{ $badgeClass }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                        {{ $user->wilayah ? $user->wilayah->nama : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('pengguna.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Hapus">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-500">Belum ada data pengguna.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection
