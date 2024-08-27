<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisionBus extends Model
{
    use HasFactory;

    protected $table = 'revisiones_buses';

    protected $fillable = [
        'bus_id',
        'checklist_id',
        'fecha_revision',
        'kilometraje',
        'observaciones'
    ];

    public $timestamps = false;

}
