<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateLaporanPersediaanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO: uncomment this line and change to the following line
        // return auth()->check() && auth()->user()->role_id === Role::ID_MANAGER;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gudang' => ['required', 'exists:gudang,id'],
            'year' => ['sometimes', 'integer', 'min:2024'], // TODO: change to required
            'month' => ['sometimes', 'integer', 'min:1', 'max:12'], // TODO: change to required
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
            'gudang.required' => 'Gudang wajib dipilih',
            'gudang.exists' => 'Gudang tidak ditemukan',
            'year.required' => 'Tahun wajib diisi',
            'year.integer' => 'Tahun harus berupa angka',
            'year.min' => 'Tahun minimal 2024',
            'month.required' => 'Bulan wajib diisi',
            'month.integer' => 'Bulan harus berupa angka',
            'month.min' => 'Bulan minimal bulan januari (01).',
            'month.max' => 'Bulan maksimal bulan desember (12).',
        ];
    }
}
