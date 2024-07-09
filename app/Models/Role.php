<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use \Sushi\Sushi;

    const ID_ADMIN_WEB = 1;
    const ID_ADMIN_STOCK = 2;
    const ID_ADMIN_PURCHASING = 3;
    const ID_SALES = 4;
    const ID_MANAGER = 5;

    protected $appends = ['displayble_name', 'sidebar_menu_view'];

    protected $rows = [
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
        return ucfirst(
            strtolower(str_replace("_", " ", $this->name))
        );
    }

    public function getDisplaybleNameAttribute()
    {
        return $this->getDisplaybleName();
    }

    public function getSidebarMenuViewAttribute()
    {
        return $this->getSidebarMenuView();
    }

    public function getSidebarMenuView()
    {
        return match ($this->id)
        {
            self::ID_ADMIN_WEB => 'admin-web.components.sidebar-menu',
            self::ID_ADMIN_STOCK => 'admin-stock.components.sidebar-menu',
            self::ID_ADMIN_PURCHASING => 'admin-purchasing.components.sidebar-menu',
            self::ID_SALES => 'sales.components.sidebar-menu',
            self::ID_MANAGER => 'manager.components.sidebar-menu',
        };

    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}