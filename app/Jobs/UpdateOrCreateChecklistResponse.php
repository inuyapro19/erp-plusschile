<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateOrCreateChecklistResponse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Ejemplo de una operación de inserción o actualización raw
        DB::table('checklist_responses')->updateOrInsert(
            ['checklist_id' => $this->data['checklist_id'], 'item_id' => $this->data['item_id']],
            [
                'respuesta' => $this->data['respuesta'] ?? null,
                'observaciones' => $this->data['observaciones'],
                'respuesta_add' => $this->data['respuesta_add'],
                'images' => $this->data['images'] ?? null, // Agregar este campo
                'valor' => $this->data['valor'] ?? null, // Agregar este campo
                'created_at'=> now(),
                'updated_at' => now()
            ]
        );
    }
}

