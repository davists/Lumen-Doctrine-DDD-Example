<?php
namespace Application\Services;

use Domain\Contracts\Service\CategoryServiceContract;

class CategoryService
{
    private $modalityService;

    public function __construct(CategoryServiceContract $modalityService)
    {
        $this->modalityService = $modalityService;
    }

    public function findAll($filter)
    {
        return $this->modalityService->findAllFiltered($filter);
    }

    public function find($modalityId)
    {
        return $this->modalityService->find($modalityId);
    }

    public function create($post)
    {
        return $this->modalityService->create($post);
    }

    public function update($modalityId, $post)
    {
        return $this->modalityService->update($modalityId, $post);
    }

    public function delete($modalityId)
    {
        return $this->modalityService->delete($modalityId);
    }

    public function count($companyId)
    {
        return $this->modalityService->count($companyId);
    }

    public function getCategoriesByCompany($companyId,$filter)
    {
        return $this->modalityService->getCategoriesByCompany($companyId,$filter);
    }
}