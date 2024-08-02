<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHargaBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO change this to check if the user is authorized to update the harga of the barang
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'harga' => ['required', 'numeric', 'min:0']
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
            'harga.required' => 'Harga barang harus diisi.',
            'harga.numeric' => 'Harga barang harus berupa angka.',
            'harga.min' => 'Harga barang tidak boleh kurang dari 0.'
        ];
    }
}
