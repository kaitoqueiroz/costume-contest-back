<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;

class FileController extends Controller
{

    /**
     * Renders a stored image
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderImage($name)
    {
        $path = storage_path('app/'.$name);

        $mime = \File::mimeType($path);

        header('Content-type: ' . $mime);

        return readfile($path);
    }
}
