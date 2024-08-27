<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistStructure extends Model
{
    use HasFactory;

    protected $table = 'checklist_structure';

    protected $fillable = [
        'category_id',
        'type_id',
    ];

    public function category()
    {
        return $this->belongsTo(ChecklistCategory::class);
    }

    public function type()
    {
        return $this->belongsTo(ChecklistTypes::class);
    }

}
