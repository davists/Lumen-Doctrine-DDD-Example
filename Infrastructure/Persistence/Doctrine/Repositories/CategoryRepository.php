<?php
namespace Infrastructure\Persistence\Doctrine\Repositories;

use Domain\Contracts\Repository\CategoryRepositoryContract;
use Domain\Entities\Category;
use Infrastructure\Persistence\Doctrine\Repositories\AbstractRepository;
use Doctrine\ORM\EntityManager;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryContract
{
    public function __construct(EntityManager $em, Category $entity)
    {
        parent::__construct($em, $entity);
    }

    public function findAllFiltered($filter)
    {
        $qb = $this->em->createQueryBuilder();

        $dependencies = $qb->select('u')
            ->from($this->entityNamespace , 'u')
            //->where("f.company = $companyId");  @TODO faltou id da empresa
            ;

        if(isset($filter['search'])){
            $term = $this->normalizeSearchTerm($filter['search']);
            $dependencies->andWhere("   
                u.name LIKE '$term'
            ");
        }

        return $this->getPaginatedData($dependencies,$filter);
    }

    public function getCategoriesByCompany($companyId,$filter)
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