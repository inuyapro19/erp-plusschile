<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistObservations extends Model
{
    use HasFactory;

    protected $table = 'checklist_observations';

    protected $fillable = [
        'checklist_id',
        'observation',
    ];


}
