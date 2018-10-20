<?php

namespace App\Admin\Controllers;

use App\Exceptions\UploadException;
use App\Http\Controllers\Controller;
use App\Services\UploadServe;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * @param UploadServe $uploadServe
     * @return array
     */
    public function uploadByEditor(UploadServe $uploadServe)
    {
        $disk = 'public';

        try {
            $files = $uploadServe->setFileInput('pictures')
                                 ->setMaxSize('10M')
                                 ->setExtensions(['jpg', 'jpeg', 'png', 'bmp', 'gif'])
                                 ->validate()
                                 ->storeMulti('upload/editor', compact('disk'));

            $files = collect($files)->map(function ($file) use ($disk) {
                return Storage::disk($disk)->url($file);
            })->all();


        } catch (UploadException $e) {

            return ['errno' => 1, 'msg' => $e->getMessage()];
        }

        return ['errno' => 0, 'data' => $files];
    }
}
