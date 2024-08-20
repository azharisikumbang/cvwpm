<?php

namespace App\Policies;

use App\Models\PengajuanPembelian;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PengajuanPembelianPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PengajuanPembelian $pengajuanPembelian): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PengajuanPembelian $pengajuanPembelian): Response
    {
        return $user->staf->gudangKerja->id === $pengajuanPembelian->stafPengaju->gudangKerja->id
            ? Response::allow()
            : Response::denyWithStatus(401, 'Anda tidak dapat mengubah pengajuan pembelian yang bukan dari gudang Anda.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PengajuanPembelian $pengajuanPembelian): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PengajuanPembelian $pengajuanPembelian): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PengajuanPembelian $pengajuanPembelian): bool
    {
        //
    }
}
