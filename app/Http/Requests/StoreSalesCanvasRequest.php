<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesCanvasRequest extends FormRequest
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
            'sales' => 'required|exists:staf,id',
            'wilayah' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'barang' => 'required|array',
            'barang.*.id' => 'required|exists:barang,id',
            'barang.*.jumlah_dus' => 'required|integer|min:0',
            'barang.*.jumlah_kotak' => 'required|integer|min:0',
            'barang.*.jumlah_satuan' => 'required|integer|min:0',
            'barang.*.keterangan' => 'nullable|string',
        ];
    }
}
