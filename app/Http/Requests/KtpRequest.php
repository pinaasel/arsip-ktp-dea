<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KtpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'foto_ktp' => 'image|max:2048', // max 2MB
        ];

        // NIK validation only for create
        if ($this->isMethod('post')) {
            $rules['nik'] = 'required|string|size:16|unique:ktps';
            $rules['foto_ktp'] .= '|required';
        }

        if ($this->isMethod('put')) {
            $rules['status'] = 'required|in:aktif,nonaktif';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'foto_ktp.required' => 'Foto KTP wajib diupload',
            'foto_ktp.image' => 'File harus berupa gambar',
            'foto_ktp.max' => 'Ukuran foto maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ];
    }
}
