@extends('layouts.app')

@section('title', 'Catat Kematian')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('kematian.store') }}" method="POST">
            @csrf
        <x-card title="Catat Kematian Penduduk" description="Penduduk yang dicatat kematiannya akan diubah statusnya menjadi MATI.">
            
            <div class="space-y-6">
                @if(auth()->user()->role !== 'RT' && isset($wilayahs) && $wilayahs->count() > 0)
                <div>
                    <x-label for="rt_filter">Filter Wilayah (RT)</x-label>
                    <x-select id="rt_filter" onchange="window.location.href='{{ route('kematian.create') }}?rt_filter=' + this.value">
                        <option value="">-- Semua Wilayah --</option>
                        @foreach($wilayahs as $w)
                            <option value="{{ $w->id }}" {{ request('rt_filter') == $w->id ? 'selected' : '' }}>
                                {{ $w->nama }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
                @endif

                <div>
                    <x-label for="penduduk_id">Pilih Penduduk</x-label>
                    <x-select id="penduduk_id" name="penduduk_id" required :error="$errors->has('penduduk_id')">
                        <option value="">-- Pilih Penduduk --</option>
                        @foreach($penduduks as $p)
                            <option value="{{ $p->id }}" {{ old('penduduk_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nik }} - {{ $p->nama }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-error :messages="$errors->get('penduduk_id')" />
                </div>

                <div>
                    <x-label for="tanggal_kematian">Tanggal Kematian</x-label>
                    <x-input id="tanggal_kematian" name="tanggal_kematian" type="date" value="{{ old('tanggal_kematian') }}" required :error="$errors->has('tanggal_kematian')" />
                    <x-error :messages="$errors->get('tanggal_kematian')" />
                </div>

                <div>
                    <x-label for="penyebab_kematian">Penyebab Kematian</x-label>
                    <x-input id="penyebab_kematian" name="penyebab_kematian" value="{{ old('penyebab_kematian') }}" required :error="$errors->has('penyebab_kematian')" />
                    <x-error :messages="$errors->get('penyebab_kematian')" />
                </div>

                <div>
                    <x-label for="tempat_kematian">Tempat Kematian</x-label>
                    <x-input id="tempat_kematian" name="tempat_kematian" value="{{ old('tempat_kematian') }}" required :error="$errors->has('tempat_kematian')" />
                    <x-error :messages="$errors->get('tempat_kematian')" />
                </div>
                
                <div>
                    <x-label for="keterangan">Keterangan Tambahan (Opsional)</x-label>
                    <textarea id="keterangan" name="keterangan" rows="3" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border py-2.5 px-3">{{ old('keterangan') }}</textarea>
                    <x-error :messages="$errors->get('keterangan')" />
                </div>
            </div>

            <x-slot:footer>
                <a href="{{ route('kematian.index') }}" class="mr-3">
                    <x-button variant="secondary">Batal</x-button>
                </a>
                <x-button type="submit" variant="danger">Simpan Kematian</x-button>
            </x-slot:footer>
        </x-card>
    </form>
</div>
@endsection
