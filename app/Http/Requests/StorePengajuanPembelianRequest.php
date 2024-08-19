<?php

namespace App\Http\Requests;

use App\DTOs\BarangMasuk\BarangMasukBibitDTO;
use App\DTOs\BarangMasuk\BarangMasukDTO;
use App\DTOs\PengajuanPembelian\PengajuanPembelianDTORequest;
use App\DTOs\PengajuanPembelianDTO;
use Contracts\DTOs\Domain\Enum\JenisBarangEnum;
use Contracts\DTOs\Requests\StorePengajuanPembelianRequestDTOInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePengajuanPembelianRequest extends FormRequest
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
            'type' => ['required', Rule::in(JenisBarangEnum::cases())],
            'barang.*.id' => 'required|exists:App\Models\Barang,id',
            'barang.*.kotak' => 'required|integer|min:0',
            'barang.*.dus' => 'required|integer|min:0',
            'barang.*.satuan' => 'nullable|integer|min:0',
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
            'type.required' => 'Jenis barang harus diisi',
            'type.in' => 'Jenis barang tidak sesuai',
            'barang.*.id.required' => 'Barang harus diisi',
            'barang.*.id.exists' => 'Barang tidak ditemukan',
            'barang.*.kotak.required' => 'Kotak harus diisi',
            'barang.*.kotak.integer' => 'Kotak harus berupa angka',
            'barang.*.kotak.min' => 'Kotak tidak boleh kurang dari 0',
            'barang.*.dus.required' => 'Dus harus diisi',
            'barang.*.dus.integer' => 'Dus harus berupa angka',
            'barang.*.dus.min' => 'Dus tidak boleh kurang dari 0',
            'barang.*.satuan.integer' => 'Satuan harus berupa angka',
            'barang.*.satuan.min' => 'Satuan tidak boleh kurang dari 0',
        ];
    }

    public function toDTO(): StorePengajuanPembelianRequestDTOInterface
    {
        $validated = $this->validated();

        return match (JenisBarangEnum::from($validated['type']))
        {
            JenisBarangEnum::BIBIT => new PengajuanPembelianDTORequest(
                JenisBarangEnum::BIBIT,
                array_map(fn($barang) => new BarangMasukBibitDTO(
                    $barang['id'],
                    $barang['kotak'],
                    $barang['dus'],
                    $barang['satuan'],
                ), $validated['barang'])
                // TODO: handle jenis barang yang lain
            ),
            default => throw new \Exception('Jenis barang tidak dikenal', 500),
        };
    }
}
