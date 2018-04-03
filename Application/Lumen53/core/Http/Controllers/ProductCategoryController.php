<?php
namespace Application\Lumen53\Http\Controllers;

use Application\Lumen53\Http\Controllers\Controller;
use Application\Services\ProductCategoryService;

class ProductCategoryController extends Controller
{
    public function __construct(ProductCategoryService $applicationService)
    {
        parent::__construct($applicationService);
    }
}