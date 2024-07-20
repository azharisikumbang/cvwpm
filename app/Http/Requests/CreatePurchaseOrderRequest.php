<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role_id === Role::ID_ADMIN_PURCHASING;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier' => ['required', 'string'],
            'barang' => ['required', 'array'],
            'barang.*.id' => ['required', 'integer', 'exists:\App\Models\Barang,id'],
            'barang.*.jumlah_kotak' => ['required', 'integer', 'min:0'],
            'barang.*.jumlah_dus' => ['required', 'integer', 'min:0'],
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
            'supplier.required' => 'Kolom Tujuan PO / Pemasok harus diisi',
            'barang.*.id.required' => 'Barang yang dimaksudan tidak valid',
            'barang.*.id.exists' => 'Barang yang dimasukkan tidak valid',
            'barang.*.jumlah_kotak.required' => 'Kolom Jumlah Kotak harus diisi',
            'barang.*.jumlah_kotak.integer' => 'Kolom Jumlah Kotak harus berupa angka',
            'barang.*.jumlah_kotak.min' => 'Kolom Jumlah Kotak minimal harus 0',
            'barang.*.jumlah_dus.required' => 'Kolom Jumlah Dus harus diisi',
            'barang.*.jumlah_dus.integer' => 'Kolom Jumlah Dus harus berupa angka',
            'barang.*.jumlah_dus.min' => 'Kolom Jumlah Dus minimal harus 0',
        ];
    }
}
