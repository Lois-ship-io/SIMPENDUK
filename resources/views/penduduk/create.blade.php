@extends('layouts.app')

@section('title', 'Tambah Penduduk')

@section('content')
<div class="mb-6 flex items-center">
    <a href="{{ route('penduduk.index') }}" class="mr-4 text-gray-500 hover:text-gray-900 transition-colors bg-white rounded-full p-2 shadow-sm border border-gray-100 hover:shadow">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Tambah Data Penduduk</h2>
        <p class="mt-1 text-sm text-gray-500">Masukkan informasi detail kependudukan untuk warga baru.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <form action="{{ route('penduduk.store') }}" method="POST">
        @csrf
        <div class="p-6 sm:p-8 space-y-8">
            <!-- Informasi Utama -->
            <div>
                <h3 class="text-lg leading-6 font-bold text-gray-900 border-b border-gray-100 pb-3 mb-5">Informasi Utama</h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                    
                    <div class="sm:col-span-3">
                        <x-label for="no_kk">Nomor Kartu Keluarga (KK) <span class="text-red-500">*</span></x-label>
                        <x-input id="no_kk" name="no_kk" value="{{ old('no_kk') }}" required :error="$errors->has('no_kk')" placeholder="Masukkan 16 digit KK" />
                        <x-error :messages="$errors->get('no_kk')" />
                    </div>

                    <div class="sm:col-span-3">
                        <x-label for="nik">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></x-label>
                        <x-input id="nik" name="nik" value="{{ old('nik') }}" required :error="$errors->has('nik')" placeholder="Masukkan 16 digit NIK" />
                        <x-error :messages="$errors->get('nik')" />
                    </div>

                    <div class="sm:col-span-6">
                        <x-label for="nama">Nama Lengkap <span class="text-red-500">*</span></x-label>
                        <x-input id="nama" name="nama" value="{{ old('nama') }}" required :error="$errors->has('nama')" placeholder="Sesuai KTP" />
                        <x-error :messages="$errors->get('nama')" />
                    </div>

                    <div class="sm:col-span-3">
                        <x-label for="tempat_lahir">Tempat Lahir <span class="text-red-500">*</span></x-label>
                        <x-input id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required :error="$errors->has('tempat_lahir')" placeholder="Kota/Kabupaten kelahiran" />
                        <x-error :messages="$errors->get('tempat_lahir')" />
                    </div>

                    <div class="sm:col-span-3">
                        <x-label for="tanggal_lahir">Tanggal Lahir <span class="text-red-500">*</span></x-label>
                        <x-input id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}" required :error="$errors->has('tanggal_lahir')" />
                        <x-error :messages="$errors->get('tanggal_lahir')" />
                    </div>

                    <div class="sm:col-span-3">
                        <x-label for="jenis_kelamin">Jenis Kelamin <span class="text-red-500">*</span></x-label>
                        <x-select id="jenis_kelamin" name="jenis_kelamin" required :error="$errors->has('jenis_kelamin')">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </x-select>
                        <x-error :messages="$errors->get('jenis_kelamin')" />
                    </div>
                    
                    <div class="sm:col-span-3">
                        <x-label for="agama">Agama <span class="text-red-500">*</span></x-label>
                        <x-select id="agama" name="agama" required :error="$errors->has('agama')">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen Protestan" {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                            <option value="Kristen Katolik" {{ old('agama') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </x-select>
                        <x-error :messages="$errors->get('agama')" />
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak & Domisili -->
            <div>
                <h3 class="text-lg leading-6 font-bold text-gray-900 border-b border-gray-100 pb-3 mb-5">Kontak & Domisili</h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                    
                    <div class="sm:col-span-6">
                        <x-label for="alamat">Alamat Lengkap <span class="text-red-500">*</span></x-label>
                        <textarea id="alamat" name="alamat" rows="3" required class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Jalan, No. Rumah, Blok, dll.">{{ old('alamat') }}</textarea>
                        <x-error :messages="$errors->get('alamat')" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label for="wilayah_id">Wilayah RT/RW <span class="text-red-500">*</span></x-label>
                        <x-select id="wilayah_id" name="wilayah_id" required :error="$errors->has('wilayah_id')">
                            <option value="">Pilih RT/RW</option>
                            @foreach($wilayahs as $w)
                                <option value="{{ $w->id }}" {{ old('wilayah_id') == $w->id ? 'selected' : '' }}>{{ $w->nama }}</option>
                            @endforeach
                        </x-select>
                        <x-error :messages="$errors->get('wilayah_id')" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label for="kelurahan">Kelurahan/Desa <span class="text-red-500">*</span></x-label>
                        <x-input id="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}" required :error="$errors->has('kelurahan')" />
                        <x-error :messages="$errors->get('kelurahan')" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label for="kecamatan">Kecamatan <span class="text-red-500">*</span></x-label>
                        <x-input id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" required :error="$errors->has('kecamatan')" />
                        <x-error :messages="$errors->get('kecamatan')" />
                    </div>
                    
                    <div class="sm:col-span-3">
                        <x-label for="no_telepon">No. Telepon / HP</x-label>
                        <x-input id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" :error="$errors->has('no_telepon')" placeholder="Mulai dengan 08..." />
                        <x-error :messages="$errors->get('no_telepon')" />
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div>
                <h3 class="text-lg leading-6 font-bold text-gray-900 border-b border-gray-100 pb-3 mb-5">Informasi Tambahan</h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                    
                    <div class="sm:col-span-2">
                        <x-label for="status_perkawinan">Status Perkawinan <span class="text-red-500">*</span></x-label>
                        <x-select id="status_perkawinan" name="status_perkawinan" required :error="$errors->has('status_perkawinan')">
                            <option value="">Pilih Status</option>
                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                        </x-select>
                        <x-error :messages="$errors->get('status_perkawinan')" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label for="pekerjaan">Pekerjaan <span class="text-red-500">*</span></x-label>
                        <x-input id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" required :error="$errors->has('pekerjaan')" />
                        <x-error :messages="$errors->get('pekerjaan')" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-label for="kewarganegaraan">Kewarganegaraan <span class="text-red-500">*</span></x-label>
                        <x-select id="kewarganegaraan" name="kewarganegaraan" required :error="$errors->has('kewarganegaraan')">
                            <option value="WNI" {{ old('kewarganegaraan') == 'WNI' ? 'selected' : (old('kewarganegaraan') == null ? 'selected' : '') }}>WNI (Warga Negara Indonesia)</option>
                            <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA (Warga Negara Asing)</option>
                        </x-select>
                        <x-error :messages="$errors->get('kewarganegaraan')" />
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-100">
            <a href="{{ route('penduduk.index') }}">
                <x-button type="button" variant="secondary">Batal</x-button>
            </a>
            <x-button type="submit" variant="primary">Simpan Penduduk</x-button>
        </div>
    </form>
</div>
@endsection
