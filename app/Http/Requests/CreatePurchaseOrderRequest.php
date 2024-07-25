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
            'nomor' => ['required', 'string', 'unique:purchase_orders,nomor'],
            'tanggal' => ['required', 'date'],
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
            'nomor.required' => 'Nomor PO wajib diisi.',
            'nomor.unique' => 'Nomor PO sudah digunakan.',
            'tanggal.required' => 'Tanggal PO wajib diisi.',
            'tanggal.date' => 'Tanggal PO harus berupa tanggal.',
            'barang.*.id.required' => 'Barang wajib diisi.',
            'barang.*.id.integer' => 'Barang harus berupa angka.',
            'barang.*.id.exists' => 'Barang tidak ditemukan.',
            'barang.*.jumlah_kotak.required' => 'Jumlah kotak wajib diisi.',
            'barang.*.jumlah_kotak.integer' => 'Jumlah kotak harus berupa angka.',
            'barang.*.jumlah_kotak.min' => 'Jumlah kotak minimal 0.',
            'barang.*.jumlah_dus.required' => 'Jumlah dus wajib diisi.',
            'barang.*.jumlah_dus.integer' => 'Jumlah dus harus berupa angka.',
            'barang.*.jumlah_dus.min' => 'Jumlah dus minimal 0.',
        ];
    }
}
