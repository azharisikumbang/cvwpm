<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGudangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdminWeb();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_gudang' => 'required|string|unique:gudang,kode_gudang',
            'nama' => ['required', 'string'],
            'lokasi' => ['required', 'string'],
            'penanggung_jawab' => ['nullable', 'exists:staf,id']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kode_gudang.required' => 'Kode gudang wajib diisi karena akan digunakan sebagai kode produk.',
            'kode_gudang.unique' => 'Kode gudang sudah digunakan',
            'nama.required' => 'Nama wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'penanggung_jawab.exists' => 'Penanggung jawab tidak valid'
        ];
    }
}
