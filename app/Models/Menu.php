<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'group_name',
        'route_name',
        'menu_url',
        'menu_icon',
        'menu_order',
        'parent_menu_id',
        'is_active',
        'visible_to_all_user',
    ];

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function scopeMainMenu($query)
    {
        $query->whereNull('parent_menu_id');
    }

    public function parentMenu()
    {
        return $this->belongsTo(Menu::class, 'parent_menu_id');
    }

    public function childMenus()
    {
        return $this->hasMany(Menu::class, 'parent_menu_id');
    }
}
