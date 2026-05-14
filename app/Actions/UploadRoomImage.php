<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;
use Cloudinary\Cloudinary;

class UploadRoomImage
{
    protected Cloudinary $cld;

    public function __construct()
    {
        $this->cld = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ]
        ]);
    }

    /**
     * Sube una o varias imágenes a Cloudinary.
     *
     * @param UploadedFile[] $imagenes
     * @return array Lista de URLs seguras de las imágenes subidas.
     */
    public function handle(array $imagenes): array
    {
        $urls = [];

        foreach ($imagenes as $imagen) {
            if ($imagen instanceof UploadedFile) {
                $result = $this->cld->uploadApi()->upload(
                    $imagen->getRealPath(),
                    ['folder' => 'habitaciones']
                );

                $urls[] = $result['secure_url'];
            }
        }

        return $urls;
    }
}
