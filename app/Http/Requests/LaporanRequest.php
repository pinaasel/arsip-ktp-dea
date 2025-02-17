<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'jenis_laporan' => 'required|in:kehilangan,kerusakan,pembaruan',
            'ktp_id' => 'required|exists:ktps,id',
            'deskripsi' => 'required|string|min:10',
        ];

        if ($this->isMethod('post')) {
            $rules['petugas_id'] = 'required|exists:users,id';
        }

        if ($this->routeIs('laporan.updateStatus')) {
            $rules = [
                'status' => 'required|in:baru,diproses,selesai',
                'catatan' => 'nullable|string',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'jenis_laporan.required' => 'Jenis laporan wajib dipilih',
            'jenis_laporan.in' => 'Jenis laporan tidak valid',
            'ktp_id.required' => 'KTP wajib dipilih',
            'ktp_id.exists' => 'KTP tidak ditemukan',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter',
            'petugas_id.required' => 'Petugas wajib dipilih',
            'petugas_id.exists' => 'Petugas tidak ditemukan',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ];
    }
}
