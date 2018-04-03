<?php

namespace Infrastructure\Persistence\Doctrine\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use LaravelDoctrine\ORM\Serializers\Jsonable;

/**
 * Class AbsctractRepository
 * @package Infrastructure\Doctrine\Repositories\AbsctractRepository
 */
abstract class AbstractRepository
{
    use Jsonable;
    /**
     * @var
     */
    protected $entity;
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var string
     */
    protected $entityNamespace;

    public function getProximaPericia($companyId)
    {
        $query = $this->em->createQueryBuilder();

        $atual = $query->select('count(u.id)')
            ->from($this->entityNamespace,'u')
            ->where("u.company = $companyId")
            ->getQuery()
            ->getSingleScalarResult();

        $proxima = $atual + 1;
        return $proxima;
    }

    public function getPaginatedData(QueryBuilder $query, $filter)
    {
        $page = 1;

        if(isset($filter['page'])){
            $page = $filter['page'];
        }

        if($page == 'all'){
            return $this->returnWithoutPagination($query);
        }

        $query->orderBy('u.id', 'DESC');
        $query = $this->em->createQuery($query->getDQL());
        $paginatedData = (new Paginator($query, $page))->getData();

        //dd($paginatedData);

        $normalizedItems = [];

        foreach ($paginatedData['items'] as $page){

            if(is_array($page) && isset($page[0])){
                unset($page[0]);
                $normalizedItems[] = $page;
            }else{
                $normalizedItems[] = $page;
            }
        }

        unset($paginatedData['items']);
        $paginatedData['items'] = $normalizedItems;

        return $paginatedData;
    }

    public function returnWithoutPagination($query)
    {
        $result = $this->em->createQuery($query->getDQL());
        $result = $result->getResult();

        $normalizedItems = [];
        foreach ($result as $page){
            if(is_array($page) && isset($page[0])){
                unset($page[0]);
                $normalizedItems[] = $page;
            }else{
                $normalizedItems[] = $page;
            }
        }

        return $normalizedItems;
    }

    /**
     * AbsctractRepository constructor.
     * @param EntityManager $em
     * @param $entity
     */
    public function __construct(EntityManager $em, $entity)
    {
        $this->em = $em;
        $this->entity = $entity;
        $this->entityNamespace = get_class($entity);
    }

    /**
     * @param int $entityId
     * @return null|object
     */
    public function find( $entityId)
    {
        return $this->em->find($this->entityNamespace, $entityId);
    }

    /**
     * @return null|object
     */
    public function findByActive()
    {
        return $this->em->getRepository($this->entityNamespace)->findBy(['active'=>1]);
    }

    /**
     * @param $arrKeyValue
     * @return null|object
     */
    public function findBy($arrKeyValue)
    {
        return $this->em->getRepository($this->entityNamespace)->findOneBy($arrKeyValue);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->em->getRepository($this->entityNamespace)->findAll();
    }

    /**
     * @param $arrKeyValue
     * @return array
     */
    public function findAllBy($arrKeyValue)
    {
        return $this->em->getRepository($this->entityNamespace)->findBy($arrKeyValue);
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return new $this->entityNamespace();
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    public function onlySave($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
        $this->em->clear();
    }

    /**
     * @param $entity
     * @param $arrAttributes
     * @return mixed
     */
    public function update($entity, $arrAttributes)
    {
        $this->setAttributes($entity,$arrAttributes);
        $this->addRelatedEntity($entity,$arrAttributes);
        return $this->save($entity);
    }

    /**
     * @param $entity
     */
    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @param $arrValue
     * @return mixed
     */
    public function deleteAll($arrValue)
    {
        $entitiesId = implode(",",$arrValue);
        $q = $this->em->createQuery("delete {$this->entityNamespace} u where u.id IN ($entitiesId)");
        return $q->execute();
    }

    /**
     * @param $entityId
     * @return mixed
     */
    public function deleteById($entityId)
    {
        $q = $this->em->createQuery("delete {$this->entityNamespace} u where u.id = $entityId");
        return $q->execute();
    }

    /**
     * @param $entityId
     * @return mixed
     */
    public function deleteByFieldAndId($field,$entityId)
    {
        $q = $this->em->createQuery("delete {$this->entityNamespace} u where u.$field = $entityId");
        return $q->execute();
    }

    /**
     * @param $arrKeyValue
     * @return mixed
     */
    public function deleteByArrKeyValue($arrKeyValue)
    {
        $condition = '';
        foreach($arrKeyValue as $key => $value){
            if($condition){
                $condition .= ' AND ';
            }
            $condition .= 'u.'.$key.' = \''.$value.'\'';
        }

        $q = $this->em->createQuery("delete {$this->entityNamespace} u where {$condition}");
        return $q->execute();
    }

    /**
     * @param $companyId
     * @return mixed
     */
    public function count($companyId)
    {
        $qb = $this->em->createQueryBuilder();
        return $qb
            ->select('count(u.id)')
            ->from($this->entityNamespace , 'u')
            ->where("u.company = $companyId")
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true, 3600)
            ->getSingleScalarResult();
    }

    /**
     * @param $entityId
     * @return null|object
     */
    public function findExternal($entityNamespace,$entityId)
    {
        $entityLoaded = $this->em->find($entityNamespace, $entityId);
        return $entityLoaded;
    }

    /**
     * @param null $arrAttributes
     * @return mixed
     */
    public function loadNew($arrAttributes=null)
    {
        $entity =  new $this->entityNamespace();
        if($arrAttributes){
            $this->setAttributes($entity,$arrAttributes);
            $this->addRelatedEntity($entity,$arrAttributes);
        }

        if(method_exists($entity,'setCreatedAt')){
            $entity->setCreatedAt(new \DateTime('now'));
        }

        return $entity;
    }

    /**
     * @param $entity
     * @param null $arrAttributes
     * @return mixed
     */
    public function load($entity, $arrAttributes=null)
    {
        if($arrAttributes){
            $this->setAttributes($entity,$arrAttributes);
            $this->loadRelatedEntity($entity,$arrAttributes);
        }

        return $entity;
    }

    /**
     * @param $entity
     * @param $arrAttributes
     */
    public function setAttributes($entity,$arrAttributes)
    {
        foreach($arrAttributes as $attr => $val){

            if(method_exists($entity, 'set'.$attr)){

                $param = new \ReflectionParameter(array(get_class($entity), 'set'.$attr), 0);

                if(!is_null($param->getClass())){
                    $entityClass = $param->getClass()->name;
                    $value = $this->findExternal($entityClass,$val);
                    $entity->{'set'.$attr}($value);
                }
                else{
                    $entity->{'set'.$attr}($val);
                }
            }
        }
    }

    /**
     * @param $entity
     * @param $arrAttributes
     */
    public function addRelatedEntity($entity,$arrAttributes)
    {
        foreach($arrAttributes as $parentAttribute => $values){
            if(is_array($values)){
                foreach ($values as $val){

                    if(method_exists($entity, 'add'.$parentAttribute)){

                        $param = new \ReflectionParameter(array($this->entityNamespace, 'add'.$parentAttribute), 0);

                        if(!is_null($param->getClass())){

                            $entityClass = $param->getClass()->name;
                            $newRelatedEntity  = new $entityClass;

                            $this->setAttributes($newRelatedEntity,$val);

                            if(method_exists($newRelatedEntity,'setCreatedAt')){
                                $newRelatedEntity->setCreatedAt(new \DateTime('now'));
                            }

                            $parentClassId  = get_class($entity);
                            $parentClassId = substr($parentClassId, strrpos($parentClassId, '\\') + 1);

                            $newRelatedEntity->{'set'.$parentClassId}($entity);

                            $entity->{'add'.$parentAttribute}($newRelatedEntity);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $entity
     * @param $arrAttributes
     */
    public function loadRelatedEntity($entity,$arrAttributes)
    {
        foreach($arrAttributes as $attr => $val){
            if(is_array($val)){
                foreach ($val as $id){
                    if(method_exists($entity, 'add'.$attr)){

                        $param = new \ReflectionParameter(array($this->entityNamespace, 'add'.$attr), 0);

                        if(!is_null($param->getClass())){
                            $entityClass = $param->getClass()->name;

                            $value = $this->findExternal($entityClass,$id);
                            $entity->{'add'.$attr}($value);
                        }
                    }
                }
            }
        }
    }


    /**
     * @param $arrKeyValue
     * @return mixed|null|object
     */
    public function firstOrNew($arrKeyValue)
    {
        $entity = $this->findBy($arrKeyValue);
        if($entity){
            return $entity;
        }

        return $this->loadNew($arrKeyValue);
    }

    /**
     * @param $arrKeyValue
     * @return mixed|null|object
     */
    public function firstOrCreate($arrKeyValue)
    {
        $entity = $this->findBy($arrKeyValue);
        if($entity){
            return $entity;
        }

        $entity = $this->loadNew($arrKeyValue);
        $this->save($entity);
        return $entity;
    }

    /**
     * @param $searchTerm
     * @return string
     */
    public function normalizeSearchTerm($searchTerm)
    {
        $term = '%'.preg_replace('/\s+/', '%', $searchTerm).'%';
        return $term;
    }

}