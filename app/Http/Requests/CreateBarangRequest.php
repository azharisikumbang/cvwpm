<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBarangRequest extends FormRequest
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
            'nama' => 'required|string|unique:barang,nama',
            'kemasan' => 'required|array',
            'kemasan.*.varian' => 'required|string',
            'kemasan.*.harga' => 'required|numeric|min:0',
            'kemasan.*.satuan_per_dus' => 'required|numeric|min:0',
            'kemasan.*.satuan_per_kotak' => 'required|numeric|min:0',
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
            'nama.unique' => 'Nama barang sudah terdaftar',
            'kemasan.required' => 'Kemasan wajib diisi',
            'kemasan.*.varian.required' => 'Varian kemasan wajib diisi',
            'kemasan.*.harga.required' => 'Harga kemasan wajib diisi',
            'kemasan.*.harga.numeric' => 'Harga kemasan harus berupa angka',
            'kemasan.*.harga.min' => 'Harga kemasan tidak boleh kurang dari 0',
            'kemasan.*.satuan_per_dus.required' => 'Satuan per dus wajib diisi',
            'kemasan.*.satuan_per_dus.numeric' => 'Satuan per dus harus berupa angka',
            'kemasan.*.satuan_per_dus.min' => 'Satuan per dus tidak boleh kurang dari 0',
            'kemasan.*.satuan_per_kotak.required' => 'Satuan per kotak wajib diisi',
            'kemasan.*.satuan_per_kotak.numeric' => 'Satuan per kotak harus berupa angka',
            'kemasan.*.satuan_per_kotak.min' => 'Satuan per kotak tidak boleh kurang dari 0',
            'satuan.required' => 'Satuan wajib diisi',
        ];
    }
}
