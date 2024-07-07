<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use \Sushi\Sushi;

    const ID_NONE = 1;
    const ID_ADMIN_WEB = 2;
    const ID_ADMIN_STOCK = 3;
    const ID_ADMIN_PURCHASING = 4;
    const ID_SALES = 5;
    const ID_MANAGER = 6;

    protected $rows = [
        ['id' => self::ID_NONE, 'name' => 'NONE', 'path' => '/logout'],
        ['id' => self::ID_ADMIN_WEB, 'name' => 'ADMIN_WEB', 'path' => '/admin-web'],
        ['id' => self::ID_ADMIN_STOCK, 'name' => 'ADMIN_STOCK', 'path' => '/admin-stock'],
        ['id' => self::ID_ADMIN_PURCHASING, 'name' => 'ADMIN_PURCHASING', 'path' => '/admin-purchasing'],
        ['id' => self::ID_SALES, 'name' => 'SALES', 'path' => '/sales'],
        ['id' => self::ID_MANAGER, 'name' => 'MANAGER', 'path' => '/manager']
    ];

    protected function sushiShouldCache()
    {
        return true;
    }


    public function getRedirectRoute()
    {
        return $this->path;
    }

    public function getDisplaybleName()
    {
        return ucfirst(str_replace("_", " ", $this->name));
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}