<?php

namespace App\Traits;

use App\Models\Checklist\CheckList;
use App\Models\Checklist\Ticket;
use Illuminate\Support\Facades\DB;

trait GeneratesFoliosTrait
{
    /**
     * Genera un folio único basado en la categoría y el año.
     *
     * @param int $categoryId El ID de la categoría para el folio.
     * @return string El folio generado.
     */
    public function createUniqueFolio($categoryId)
    {
        $year = date("Y");
        $prefix = $this->getPrefixForCategoryId($categoryId);

        try {
            $lastFolio = CheckList::where('category_id', $categoryId)
                ->where('folio', 'LIKE', "$prefix-$year-%")
                ->orderByDesc('folio')
                ->limit(1)
                ->value('folio');

            $number = 1;
            if ($lastFolio) {
                $lastNumber = intval(substr($lastFolio, strrpos($lastFolio, '-') + 1));
                $number = $lastNumber + 1;
            }

            $newFolio = sprintf("%s-%s-%08d", $prefix, $year, $number);

            return $newFolio;
        } catch (\Exception $e) {
            // Manejo de error
            report($e);
            return null; // O manejar el error como prefieras
        }
    }

    public function createUniqueNroTicket($categoryId)
    {
        $year = date("Y");
        $prefix = $this->getPrefixForCategoryId($categoryId);

        try {
            return DB::transaction(function () use ($prefix, $year, $categoryId) {
                $lastNroTicket = Ticket::where('category', $categoryId)
                    ->where('nro_ticket', 'LIKE', "$prefix-$year-%")
                    ->lockForUpdate() // Bloqueo de fila para transacciones concurrentes
                    ->orderByDesc('nro_ticket')
                    ->limit(1)
                    ->value('nro_ticket');

                \Log::info("Last nro_ticket: $lastNroTicket");

                $number = 1;
                if ($lastNroTicket) {
                    $lastNumber = intval(substr($lastNroTicket, strrpos($lastNroTicket, '-') + 1));
                    \Log::info("Last number: $lastNumber");
                    $number = $lastNumber + 1;
                }

                $newNroTicket = sprintf("%s-%s-%08d", $prefix, $year, $number);

                \Log::info("New nro_ticket: $newNroTicket");

                return $newNroTicket;
            });
        } catch (\Exception $e) {
            // Error handling
            report($e);
            return null; // Or handle the error as you prefer
        }
    }


    /**
     * Obtiene el prefijo para la categoría basado en category_id.
     *
     * @param int $categoryId El ID de la categoría.
     * @return string El prefijo de la categoría.
     */
    private function getPrefixForCategoryId($categoryId)
    {
        // Aquí deberías obtener el prefijo para la categoría basado en category_id
        $prefixMap = [
            1 => 'CA',
            2 => 'PRE',
            // etc.
        ];

        return $prefixMap[$categoryId] ?? 'GEN'; // 'GEN' como prefijo genérico por defecto
    }
}

