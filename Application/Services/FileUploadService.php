<?php
namespace Application\Services;

use Illuminate\Support\Facades\Auth;
use Infrastructure\Services\Files\Upload;

class FileUploadService
{
    public $uploadService;

    public function __construct()
    {
        $this->uploadService = new Upload();
    }

    public function upload($post)
    {
        $companyId = $post['companyId'];
        $fileType = $post['fileType'];

        $destination = "company/$companyId/$fileType";

        $uploadResponse = $this->uploadService->put($post['file'], $destination);

        return $uploadResponse;
    }
}