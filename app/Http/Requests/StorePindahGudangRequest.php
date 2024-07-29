<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class StorePindahGudangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $gudangTujuan = request()->input('gudang_tujuan');

        return request()->user()->hasRole(Role::ID_ADMIN_STOCK)
            && request()->user()->gudangKerja()->first()->id !== $gudangTujuan
        ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gudang_tujuan' => ['required', 'exists:gudang,id'],
            'tanggal_pemindahan' => ['required', 'date'],
            'barang' => ['required', 'array'],
            'barang.*.id' => ['required', 'exists:barang,id'],
            'barang.*.jumlah_dus' => ['required', 'integer', 'min:0'],
            'barang.*.jumlah_kotak' => ['required', 'integer', 'min:0'],
            'barang.*.jumlah_satuan' => ['required', 'integer', 'min:0'],
            'barang.*.keterangan' => ['nullable', 'string'],
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
            'gudang_tujuan.required' => 'Gudang tujuan harus diisi',
            'gudang_tujuan.exists' => 'Gudang tujuan tidak ditemukan',
            'tanggal_pemindahan.required' => 'Tanggal pemindahan harus diisi',
            'tanggal_pemindahan.date' => 'Tanggal pemindahan harus berupa tanggal',
            'barang.required' => 'Barang harus diisi',
            'barang.array' => 'Barang harus berupa array',
            'barang.*.id.required' => 'Barang harus diisi',
            'barang.*.id.exists' => 'Barang tidak ditemukan',
            'barang.*.jumlah_dus.required' => 'Jumlah dus harus diisi',
            'barang.*.jumlah_dus.integer' => 'Jumlah dus harus berupa angka',
            'barang.*.jumlah_dus.min' => 'Jumlah dus tidak boleh kurang dari 0',
            'barang.*.jumlah_kotak.required' => 'Jumlah kotak harus diisi',
            'barang.*.jumlah_kotak.integer' => 'Jumlah kotak harus berupa angka',
            'barang.*.jumlah_kotak.min' => 'Jumlah kotak tidak boleh kurang dari 0',
            'barang.*.jumlah_satuan.required' => 'Jumlah satuan harus diisi',
            'barang.*.jumlah_satuan.integer' => 'Jumlah satuan harus berupa angka',
            'barang.*.jumlah_satuan.min' => 'Jumlah satuan tidak boleh kurang dari 0',
            'barang.*.keterangan.string' => 'Keterangan harus berupa teks',
        ];
    }
}
