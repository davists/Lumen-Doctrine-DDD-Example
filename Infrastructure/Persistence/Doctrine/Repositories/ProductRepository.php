<?php
namespace Infrastructure\Persistence\Doctrine\Repositories;

use Domain\Contracts\Repository\ProductRepositoryContract;
use Domain\Entities\Product;
use Infrastructure\Persistence\Doctrine\Repositories\AbstractRepository;
use Doctrine\ORM\EntityManager;

class ProductRepository extends AbstractRepository implements ProductRepositoryContract
{
    public function __construct(EntityManager $em, Product $entity)
    {
        parent::__construct($em, $entity);
    }

    public function findAllFiltered($filter)
    {
        $qb = $this->em->createQueryBuilder();

        $dependencies = $qb->select('u')
            ->from($this->entityNamespace , 'u')
            //->join('u.category','c')
            //->where("u.company = $companyId");
            ;

        if(isset($filter['search'])){
            $term = $this->normalizeSearchTerm($filter['search']);
            $dependencies->andWhere("(   
                u.name LIKE '$term' OR c.name LIKE '$term'
            )");
        }

        return $this->getPaginatedData($dependencies,$filter);
    }

    public function getProductsByCompany($companyId,$filter)
    {
        $qb = $this->em->createQueryBuilder();

        $dependencies = $qb->select('u')
            ->from($this->entityNamespace , 'u')
            //->join('u.category','c')
            ->where("u.companyId = $companyId");
        ;

        if(isset($filter['search'])){
            $term = $this->normalizeSearchTerm($filter['search']);
            $dependencies->andWhere("(   
                u.name LIKE '$term' OR c.name LIKE '$term'
            )");
        }

        return $this->getPaginatedData($dependencies,$filter);
    }
}