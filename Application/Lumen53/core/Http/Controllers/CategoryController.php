<?php
namespace Application\Lumen53\Http\Controllers;

use Application\Lumen53\Http\Controllers\Controller;
use Application\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(CategoryService $applicationService)
    {
        parent::__construct($applicationService);
    }

    public function getCategoriesByCompany($companyId,Request $request)
    {
        $filter = $request->all();
        $filter = $this->removeEmpty($filter);

        $products = $this->applicationService->getCategoriesByCompany($companyId,$filter);
        return $this->sendResponse($products);
    }

}