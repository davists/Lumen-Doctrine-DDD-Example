<?php
namespace Application\Lumen53\Http\Controllers;

use Application\Lumen53\Http\Controllers\Controller;
use Application\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(ProductService $applicationService)
    {
        parent::__construct($applicationService);
    }

    public function getProductsByCompany($companyId,Request $request)
    {
        $filter = $request->all();
        $filter = $this->removeEmpty($filter);

        $products = $this->applicationService->getProductsByCompany($companyId,$filter);
        return $this->sendResponse($products);
    }
}