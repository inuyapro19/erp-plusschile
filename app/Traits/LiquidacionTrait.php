<?php

namespace App\Traits;

trait LiquidacionTrait
{
    private $ingresoMinimoMensual = 350000;
    public function calcularLiquidacionSueldo()
    {

    }

    private function calcularGratificacion($salarioMensual, $mesesTrabajados)
    {
        $ingresoMinimoMensual = 350000; // Valor actualizado al 2023
        $gratificacionMaxima = 4.75 * $ingresoMinimoMensual;

        $gratificacion = 0.25 * $salarioMensual * $mesesTrabajados;

        if ($gratificacion > $gratificacionMaxima) {
            $gratificacion = $gratificacionMaxima;
        }

        return $gratificacion;
    }


}

