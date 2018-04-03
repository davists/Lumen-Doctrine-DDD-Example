<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 7/29/17
 * Time: 5:51 PM
 */

namespace Infrastructure\Services\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class Upload
{

    public function put(UploadedFile $file, $path, $name=null)
    {
        $path = strtolower($path);

        if(is_null($name)){
            $filePath = Storage::putFile($path, $file, 'public');
            $fileName = substr($filePath, strrpos($filePath, '/') + 1);
        }

        if(!is_null($name))
        {
            $filePath = Storage::putFileAs($path, $file, $name, 'public');
            $fileName = substr($filePath, strrpos($filePath, '/') + 1);
        }

        $uploadResponse = ['file_url' => Storage::url($filePath),'file_name'=>$fileName];

        return $uploadResponse;
    }

    public function putLocalFileOnS3($pathS3,$filePath)
    {
        $fileName = substr($filePath, strrpos($filePath, '/') + 1);
        $file = new UploadedFile($filePath,$fileName);

        $filePath = Storage::putFileAs($pathS3, $file, $fileName, 'public');
        $uploadResponse = ['file_url' => Storage::url($filePath),'file_name'=>$fileName];

        return $uploadResponse;
    }

}