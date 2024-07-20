<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanPembelianRequest extends FormRequest
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
            'barang.*.barang_id' => 'required|exists:App\Models\Barang,id',
            'barang.*.jumlah_kotak' => 'required|integer|min:0',
            'barang.*.jumlah_dus' => 'required|integer|min:0',
            'catatan' => 'nullable|string',
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
            'barang.*.barang_id.required' => 'Barang harus diisi',
            'barang.*.barang_id.exists' => 'Barang tidak ditemukan',
            'barang.*.jumlah_kotak.required' => 'Jumlah kotak harus diisi',
            'barang.*.jumlah_kotak.integer' => 'Jumlah kotak harus berupa angka',
            'barang.*.jumlah_kotak.min' => 'Jumlah kotak minimal 0',
            'barang.*.jumlah_dus.required' => 'Jumlah dus harus diisi',
            'barang.*.jumlah_dus.integer' => 'Jumlah dus harus berupa angka',
            'barang.*.jumlah_dus.min' => 'Jumlah dus minimal 0',
            'catatan.string' => 'Catatan harus berupa teks',
        ];
    }
}
