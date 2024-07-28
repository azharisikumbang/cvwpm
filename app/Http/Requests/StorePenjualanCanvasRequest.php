<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class StorePenjualanCanvasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole(Role::ID_SALES);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'canvas' => 'required|exists:App\Models\SalesCanvas,id',
            'nama_toko' => 'required|string',
            'alamat_toko' => 'required|string',
            'tanggal_transaksi' => 'required|date',
            'barang' => 'required|array',
            'barang.*.id' => 'required|exists:barang,id',
            'barang.*.jumlah_dus' => 'required|integer|min:0',
            'barang.*.jumlah_kotak' => 'required|integer|min:0',
            'barang.*.jumlah_satuan' => 'required|integer|min:0',
            'barang.*.keterangan' => 'nullable|string',
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
            'sales.required' => 'Sales harus diisi.',
            'sales.exists' => 'Sales tidak ditemukan.',
            'nama_toko.required' => 'Nama toko harus diisi.',
            'nama_toko.string' => 'Nama toko harus berupa string.',
            'alamat_toko.required' => 'Alamat toko harus diisi.',
            'alamat_toko.string' => 'Alamat toko harus berupa string.',
            'tanggal_transaksi.required' => 'Tanggal penjualan harus diisi.',
            'tanggal_transaksi.date' => 'Tanggal penjualan harus berupa tanggal.',
            'barang.required' => 'Barang harus diisi.',
            'barang.array' => 'Barang harus berupa array.',
            'barang.*.id.required' => 'Barang harus diisi.',
            'barang.*.id.exists' => 'Barang tidak ditemukan.',
            'barang.*.jumlah_dus.required' => 'Jumlah dus harus diisi.',
            'barang.*.jumlah_dus.integer' => 'Jumlah dus harus berupa angka.',
            'barang.*.jumlah_dus.min' => 'Jumlah dus tidak boleh kurang dari 0.',
            'barang.*.jumlah_kotak.required' => 'Jumlah kotak harus diisi.',
            'barang.*.jumlah_kotak.integer' => 'Jumlah kotak harus berupa angka.',
            'barang.*.jumlah_kotak.min' => 'Jumlah kotak tidak boleh kurang dari 0.',
            'barang.*.jumlah_satuan.required' => 'Jumlah satuan harus diisi.',
            'barang.*.jumlah_satuan.integer' => 'Jumlah satuan harus berupa angka.',
            'barang.*.jumlah_satuan.min' => 'Jumlah satuan tidak boleh kurang dari 0.',
            'barang.*.keterangan.string' => 'Keterangan harus berupa string.',
        ];
    }
}
