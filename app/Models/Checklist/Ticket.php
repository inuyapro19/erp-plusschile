<?php

namespace App\Models\Checklist;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    protected $fillable = [
        'id',
        'nro_ticket',
        'checklist_id',
        'reported_by',
        'assigned_to',
        'status',
        'status_validate',
        'observacion_validate',
        'category',
        'title',
        'description',
        'resolved_at',
        'resolution_summary',
        'item_id',
        'priority',
        'created_at',
        'updated_at',
    ];

    public function checklist()
    {
        return $this->belongsTo(CheckList::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function checklistItem() {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
