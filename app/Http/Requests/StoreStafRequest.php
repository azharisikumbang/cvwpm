<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStafRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdminWeb();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string'],
            'jabatan' => ['required', Rule::in(Role::pluck('id'))],
            'kontak' => ['required', 'string'],
            'gudang_kerja' => ['required', 'exists:gudang,id'],
            'user_id' => ['nullable', 'exists:users,id']
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
            'nama.required' => 'Nama harus diisi',
            'jabatan.required' => 'Jabatan harus diisi',
            'jabatan.in' => 'Jabatan tidak valid',
            'kontak.required' => 'Kontak harus diisi',
            'gudang_kerja.required' => 'Gudang kerja harus diisi',
            'gudang_kerja.exists' => 'Gudang kerja tidak valid'
        ];
    }
}
