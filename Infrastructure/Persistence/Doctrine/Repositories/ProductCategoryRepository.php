<?php
namespace Infrastructure\Persistence\Doctrine\Repositories;

use Domain\Contracts\Repository\ProductCategoryRepositoryContract;
use Domain\Entities\ProductCategory;
use Infrastructure\Persistence\Doctrine\Repositories\AbstractRepository;
use Doctrine\ORM\EntityManager;

class ProductCategoryRepository extends AbstractRepository implements ProductCategoryRepositoryContract
{
    public function __construct(EntityManager $em, ProductCategory $entity)
    {
        parent::__construct($em, $entity);
    }

    public function findAllFiltered($filter)
    {
        $qb = $this->em->createQueryBuilder();

        $dependencies = $qb->select('u')
            ->from($this->entityNamespace , 'u')
            //->join('u.periciaAdministrativaFinanceiro','f')
            //->join('f.periciaAdministrativa','p')
            //->where("f.company = $companyId");  @TODO faltou id da empresa
            ;

        if(isset($filter['search'])){
            $term = $this->normalizeSearchTerm($filter['search']);
            $dependencies->andWhere("(   
                c.name LIKE '$term' OR c.name LIKE '$term'
            )");
        }

        return $this->getPaginatedData($dependencies,$filter);
    }


    public function deleteCategoriesByProductId($productId)
    {
        $this->deleteByFieldAndId('product',$productId);
    }
}