<?php

namespace App\Imports;

use App\Models\Checklist\Item;
use App\Models\Checklist\ChecklistItemField;
use App\Models\Checklist\CheckListTypes;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log; // Importa el facade Log

class ItemImport implements ToModel, WithHeadingRow
{
    private $errores = [];
    private $filasErroneas = 0;

    public function model(array $row)
    {
        try {
            /*if (!isset($row['TIPO_ID'])) {
                $this->filasErroneas++;
                $this->errores[] = ['fila' => $row, 'error' => 'Falta TIPO_ID'];
                return null;
            }*/

            // Siempre crea/actualiza CheckListTypes
            /*$type = CheckListTypes::updateOrCreate(
                ['id' => $row['TIPO_ID']],
                [
                    'name' => $row['TIPO_NAME'],
                    'description' => $row['DESCRIPCION_TYPE'] ?? '',
                    'category_id' => $row['CATEGORIA_ID'] ?? null,
                ]
            );*/


            // Crea/actualiza Item y ChecklistItemField solo si se proporcionan datos necesarios
            if (!empty($row['ITEM_ID']) && !empty($row['ITEM_NAME'])) {
                $item = Item::updateOrCreate(
                    ['id' => $row['ITEM_ID']],
                    [
                        'name' => $row['ITEM_NAME'],
                        'description' => $row['DESCRIPCION_ITEM'] ?? '',
                        'type_id' => $row['TIPO_ID'],
                        'order_item' => $row['ORDER_ITEM'] ?? null,
                        'area_id' => $row['AREA_ID'] ?? null,
                        'critical' => $row['CRITICO'] ?? null,
                    ]
                );

                $field = ChecklistItemField::updateOrCreate(
                    ['item_id' => $item->id],
                    [
                        'field_type_id' => 1,
                        'label' => $item->name,
                        'options' => $row['OPTIONS'] ?? '',
                    ]
                );

                return $item;
            }


        } catch (\Exception $e) {
            $this->filasErroneas++;
            $this->errores[] = ['fila' => $row, 'error' => $e->getMessage()];
            return null;
        }
    }
    public function getErrores()
    {
        return $this->errores;
    }

    public function getFilasErroneas()
    {
        return $this->filasErroneas;
    }

    public function headingRow(): int
    {
        return 1;
    }
}

