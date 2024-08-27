<?php
namespace App\Traits;

use App\Models\Trabajador;
use App\Models\TrabajadorViaje;

trait TrabajadorViajeTrait
{
    public function createTrabajadorViajeFromArray(array $trabajadorData,$viaje_id)
    {
         TrabajadorViaje::create([
            'viaje_id' => $viaje_id,
            'trabajador_id' => $trabajadorData['trabajador_id'],
            'reemplazo_id' => $trabajadorData['reemplazo_id'] ?? null,
            'tipo_tripulante' => $trabajadorData['tipo_tripulante'],
            'orden' => $trabajadorData['orden'],
        ]);

        /***** CONDUCTORES Y AUXILIARES SE LES CAMBIA SU CONDICION DE DISPONIBLE A EN RUTA ****/
        $trabajador = Trabajador::where('id','=',$trabajadorData['trabajador_id'])->first();
        $trabajador->condicion = 'en ruta';
        $trabajador->save();

         return 'success';
    }
}
