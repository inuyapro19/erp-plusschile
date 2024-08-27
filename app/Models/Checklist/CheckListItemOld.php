<?php

namespace App\Models\Checklist;

use App\Models\Areas;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListItemOld extends Model
{
    use HasFactory;

    protected $table = 'checklist_items';

    protected $fillable = [
        'name',
        'description',
        'type_id',
        'parent_id',
        'order_item',
        'area_id',
        'is_observations',
        'is_attachement',
        'is_seats',
        'is_tripulacion',
        'is_conteo',
        'critical',
        'prioridad',
        'is_active',
    ];

    public $timestamps = false;

    public function field()
    {
        return $this->hasOne(ChecklistItemField::class, 'item_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(CheckListTypes::class, 'type_id', 'id');
    }

    public function responsables()
    {
        return $this->belongsToMany(User::class, 'checklist_item_users', 'item_id', 'user_id');
    }

    public function area()
    {
        return $this->belongsTo(Areas::class, 'area_id', 'id');
    }
    //response
    public function responses()
    {
        return $this->hasMany(ChecklistResponse::class, 'item_id', 'id');
    }

    //parent_id
    public function parent()
    {
        return $this->belongsTo(CheckListItemOld::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(CheckListItemOld::class, 'parent_id');
    }
    public function getTypeNameAttribute()
    {
        return $this->type->name;
    }

    public function scopeFiltros(Builder $query){
        if (empty(request('filtro'))){
            return;
        }

        $filtros = request('filtro');

        foreach($filtros as $filtro => $value){
            $query->where($filtro, $value);
        }

    }



}
