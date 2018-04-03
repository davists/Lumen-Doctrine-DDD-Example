<?php
namespace Application\Services;

use Application\Core\Exceptions\ApplicationException;
use Domain\Contracts\Service\ProductServiceContract;

class ProductService
{
    private $modalityService;

    public function __construct(ProductServiceContract $modalityService)
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
        $product = $post;

        if(isset($post['categories'])){
            $product['category'] = $post['categories'];  //call addCategory in the model for each item in array
        }else{
            throw new ApplicationException('Selecione uma categoria para o produto',403);
        }

        return $this->modalityService->create($product);
    }

    public function update($modalityId, $post)
    {
        $product = $post;

        if(isset($post['categories'])){
            $product['category'] = $post['categories'];
        }

        return $this->modalityService->update($modalityId, $product);
    }

    public function delete($modalityId)
    {
        return $this->modalityService->delete($modalityId);
    }

    public function count($companyId)
    {
        return $this->modalityService->count($companyId);
    }

    public function getProductsByCompany($companyId,$filter)
    {
        return $this->modalityService->getProductsByCompany($companyId,$filter);
    }
}