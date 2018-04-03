<?php
namespace Domain\Services;

use Domain\Abstractions\AbstractDomainService;
use Domain\Contracts\Repository\ProductCategoryRepositoryContract;
use Domain\Contracts\Service\ProductCategoryServiceContract;

class ProductCategoryService extends AbstractDomainService implements ProductCategoryServiceContract
{
    public function __construct(ProductCategoryRepositoryContract $repositoryContract)
    {
        parent::__construct($repositoryContract);
    }

}