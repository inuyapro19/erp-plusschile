<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'parent_id',
        'route',
        'icon',
        'position'
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
                            ->with('children');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_role');
    }

}
