<?php

namespace App\Http\Requests;

use App\DTOs\PengajuanPembelian\IndexPengajuanPembelianDTORequest;
use Illuminate\Foundation\Http\FormRequest;

class IndexPengajuanPembelianRequest extends FormRequest
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
            'status' => ['sometimes', 'string', 'in:pending,approved,rejected,revised'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1'],
            'search' => ['sometimes', 'string'],
        ];
    }

    public function toDTO(): IndexPengajuanPembelianDTORequest
    {
        return new IndexPengajuanPembelianDTORequest(
            stafPengajuId: auth()->user()->staf->id,
            limit: $this->input('per_page', 10),
            offset: $this->input('page', 1),
        );
    }
}
