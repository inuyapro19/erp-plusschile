<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;

trait HandlesImages
{
    /**
     * Sube y optimiza una imagen.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  string $path
     * @param  int $quality
     * @return string
     */
    public function uploadAndOptimizeImage(UploadedFile $file, $path, $quality = 60)
    {
        $nombreArchivo = time() . '.' . $file->getClientOriginalExtension();
        $destinoPath = public_path($path);

        // Crear una instancia de la imagen
        $imagen = Image::make($file);

        // Aquí puedes aplicar otros métodos de manipulación de Intervention Image si es necesario

        // Guardar la imagen optimizada
        $imagen->save($destinoPath . '/' . $nombreArchivo, $quality);

        // Devolver el nombre del archivo para su uso posterior (p.ej., guardarlo en la base de datos)
        return $nombreArchivo;
    }
}
