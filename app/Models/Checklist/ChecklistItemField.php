<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItemField extends Model
{
    use HasFactory;

    protected $table = 'checklist_item_fields';

    protected $fillable = [
        'item_id',
        'field_type_id',
        'label',
        'options',
    ];

    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo(FieldType::class, 'field_type_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
