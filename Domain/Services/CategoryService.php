<?php
namespace Domain\Services;

use Domain\Abstractions\AbstractDomainService;
use Domain\Contracts\Repository\CategoryRepositoryContract;
use Domain\Contracts\Service\CategoryServiceContract;

class CategoryService extends AbstractDomainService implements CategoryServiceContract
{
    public function __construct(CategoryRepositoryContract $repositoryContract)
    {
        parent::__construct($repositoryContract);
    }

    public function getCategoriesByCompany($companyId,$filter)
    {
        return  $this->repository->getCategoriesByCompany($companyId,$filter);
    }
}