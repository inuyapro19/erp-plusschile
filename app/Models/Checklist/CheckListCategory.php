<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListCategory extends Model
{
    use HasFactory;


    protected $table = 'checklist_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    public function structure()
    {
        return $this->hasMany(ChecklistStructure::class, 'category_id', 'id');
    }

}
