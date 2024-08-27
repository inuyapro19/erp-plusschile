<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistResponse extends Model
{
    use HasFactory;

    protected $table = 'checklist_responses';

    protected $fillable = [
        'checklist_id',
        'item_id',
        'respuesta',
        'observaciones',
        'respuesta_add',
        'images',
        'valor',
        'nro_asiento'
    ];

    public $timestamps = false;

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function checklist()
    {
        return $this->belongsTo(CheckList::class, 'checklist_id', 'id');
    }


}
