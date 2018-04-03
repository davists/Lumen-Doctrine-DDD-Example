<?php
namespace Application\Lumen53\Http\Controllers;

use Application\Lumen53\Http\Controllers\Controller;
use Application\Services\FileUploadService;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function __construct(FileUploadService $applicationService)
    {
        parent::__construct($applicationService);
    }

    public function upload(Request $request)
    {
        $data = $this->applicationService->upload($request->all());
        return $this->sendResponse($data);
    }
}