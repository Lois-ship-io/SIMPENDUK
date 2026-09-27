<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePendudukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $penduduk = $this->route('penduduk');
        return [
            'no_kk' => ['required', 'string', 'size:16'],
            'nik' => ['required', 'string', 'size:16', 'unique:penduduks,nik,' . $penduduk->id],
            'nama' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\,\']+$/'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'wilayah_id' => ['required', 'exists:wilayahs,id'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'agama' => ['required', 'in:Islam,Kristen Protestan,Kristen Katolik,Hindu,Buddha,Konghucu'],
            'status_perkawinan' => ['required', 'in:Kawin,Belum Kawin,Cerai'],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'kewarganegaraan' => ['required', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'min:11', 'max:13'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.regex' => 'Nama penduduk hanya boleh berisi huruf dan spasi.',
        ];
    }
}
