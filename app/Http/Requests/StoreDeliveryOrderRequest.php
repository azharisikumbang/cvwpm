<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryOrderRequest extends FormRequest
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
            'nomor' => 'required|string',
            'tanggal_penerimaan' => 'required|date',
            'barang' => 'required|array',
            'barang.*.id' => 'required|integer|exists:barang,id',
            'barang.*.jumlah_dus' => 'required|integer|min:0',
            'barang.*.jumlah_satuan' => 'required|integer|min:0',
            'barang.*.jumlah_kotak' => 'required|integer|min:0',
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
            'nomor.required' => 'Nomor DO harus diisi',
            'tanggal_penerimaan.required' => 'Tanggal penerimaan belum diisi',
            'barang.required' => 'Barang harus diisi',
            'barang.*.id.required' => 'Barang harus diisi',
            'barang.*.jumlah_dus.required' => 'Jumlah dus harus diisi',
            'barang.*.jumlah_satuan.required' => 'Jumlah satuan harus diisi',
            'barang.*.jumlah_kotak.required' => 'Jumlah kotak harus diisi',
        ];
    }
}
