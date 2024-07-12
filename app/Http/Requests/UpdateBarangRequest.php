<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'harga' => 'required|integer|min:0',
            'satuan' => 'required|string',
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
            'nama.required' => 'Nama barang wajib diisi',
            'nama.string' => 'Nama barang harus berupa string',
            'harga.required' => 'Harga barang wajib diisi',
            'harga.integer' => 'Harga barang harus berupa angka',
            'harga.min' => 'Harga barang minimal Rp. 0',
            'satuan.required' => 'Satuan barang wajib diisi',
            'satuan.string' => 'Satuan barang tidak boleh angka',
        ];
    }
}
