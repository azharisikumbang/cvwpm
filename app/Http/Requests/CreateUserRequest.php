<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'staf' => 'required|exists:staf,id',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
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
            'staf.required' => 'Staf harus diisi.',
            'staf.exists' => 'Staf tidak ditemukan.',
            'username.required' => 'Username harus diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari :max karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal :min karakter.',
            'password.max' => 'Password tidak boleh lebih dari :max karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
