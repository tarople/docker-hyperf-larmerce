<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Controller\AbstractController;
use App\Request\Backend\UploadRequest;
use Hyperf\Utils\Str;
use  League\Flysystem\Filesystem;

class UploadController extends AbstractController
{   

    public function image(UploadRequest $request, Filesystem $filesystem)
    {   
        sleep(3);

        $file = $request->file('image');

        if (!$file) {
            return [
                'code' => 0,
                'msg' => 'image is required',
                'data' => [],
            ];
        }

        // upload path        
        $storePath = '/uploads/image/' . date('Ymd') . '/';
        $storeName = time() . Str::random(10) . "." . $file->getExtension();
        $stream = fopen($file->getRealPath(), 'r+');
        $filesystem->writeStream(
            $storePath . $storeName,
            $stream
        );
        fclose($stream);        

        return [
            'code' => 1,
            'msg' => 'upload success',
            'data' => [
                'show_image' => env('APP_URL') . $storePath . $storeName,
                'save_image' => $storePath . $storeName,
            ],
        ];            
        
    }   
    
}
