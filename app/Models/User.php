<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'role_id'
    ];

    protected $appends = [
        'jabatan',
        'nama'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string|int|Role $role): bool
    {
        if (is_int($role) && $this->hasRoleId($role))
            return true;

        return $this->role->id == $role || $this->role->name == $role || $this->role == $role;
    }

    public function hasRoleId(int $role): bool
    {
        return $this->role_id === $role;
    }

    public function getJabatanAttribute(): string
    {
        return $this->staf ? $this->staf->jabatan : $this->role->displayble_name;
    }

    public function staf(): BelongsTo
    {
        return $this->belongsTo(Staf::class, 'id', 'user_id');
    }

    public function getNamaAttribute(): string
    {
        return $this->staf ? $this->staf->gudangKerja->nama . ' / ' . $this->staf->nama : '-';
    }

    public function gudangKerja(): Gudang
    {
        return $this->staf->gudangKerja;
    }

    public function cekKepemilikanGudangKerja(): bool
    {
        return $this->staf->cekKepemilikanGudangKerja($this->gudangKerja());
    }

    public function isAdminWeb(): bool
    {
        return $this->hasRole(Role::ID_ADMIN_WEB);
    }
}
