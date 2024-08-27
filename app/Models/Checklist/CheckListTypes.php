<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListTypes extends Model
{
    use HasFactory;

    protected $table = 'checklist_types';


    protected $fillable = [
        'name',
        'description',
        'category_id',
        'status',
        'order_type',
        'created_by',
        'updated_by',
    ];

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class, 'type_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(CheckListCategory::class, 'category_id', 'id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }




}
