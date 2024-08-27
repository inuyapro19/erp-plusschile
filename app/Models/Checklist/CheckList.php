<?php

namespace App\Models\Checklist;

use App\Models\Buses;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class CheckList extends Model
{
    use HasFactory;

    protected $table = 'checklists';

    protected $fillable = [
        'category_id',
        'user_id',
        'bus_id',
        'folio',
        'status',
        'origen_id',
        'destino_id',
        'tipo_servicio',
        'fecha',
        'hora_salida',
        'observaciones'
    ];

    public function category()
    {
        return $this->belongsTo(CheckListCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bus()
    {
        return $this->belongsTo(Buses::class);
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }

    //relacion con tabla intermedia checklist_response y checklist_item
    public function items()
    {
        return $this->belongsToMany(Item::class, 'checklist_responses', 'checklist_id', 'item_id');
    }

    public function responses()
    {
        return $this->hasMany(CheckListResponse::class);
    }

    public function users()
    {
        //checklist_users_signed
        return $this->belongsToMany(User::class, 'checklist_users_signed', 'checklist_id', 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'checklist_id');
    }

}
