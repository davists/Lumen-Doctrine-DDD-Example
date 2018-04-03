<?php
namespace Domain\Abstractions;

abstract class AbstractDomainService
{
    public $repository;

    public function __construct($repositoryContract)
    {
        $this->repository = $repositoryContract;
    }

    public function getProximaPericia($companyId)
    {
        return $this->repository->getProximaPericia($companyId);
    }

    public function batchCreate($arrayRecords)
    {
        foreach ($arrayRecords as $data){
            $entity = $this->loadNew($data);
            $this->repository->onlySave($entity);
        }

        return 'Records Sucessfully saved!';
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findAllFiltered($filter)
    {
        return $this->repository->findAllFiltered($filter);
    }

    public function find($entityId)
    {
        return $this->repository->find($entityId);
    }

    public function findBy($arrKeyValue)
    {
        return $this->repository->findBy($arrKeyValue);
    }

    public function findAllBy($arrKeyValue)
    {
        return $this->repository->findAllBy($arrKeyValue);
    }

    public function findAllByFilter($filter)
    {
        return $this->repository->findAll($filter);
    }

    public function loadNew($post)
    {
        return $this->repository->loadNew($post);
    }

    public function getEntity()
    {
        return $this->repository->getEntity();
    }

    public function create($post)
    {
        if(!is_object($post)){
            $post = $this->loadNew($post);
        }

        return $this->repository->save($post);
    }

    public function save($entity)
    {
        return $this->repository->save($entity);
    }

    public function update($entityId, $post)
    {
        $entity = $this->find($entityId);
        return $this->repository->update($entity, $post);
    }

    public function updateEntity($entity, $post)
    {
        return $this->repository->update($entity, $post);
    }

    public function delete($entityId)
    {
        return $this->repository->deleteById($entityId);
    }

    public function alreadyExists($parameter,$exceptionMessage)
    {
        $user = $this->repository->findBy($parameter);
        if(!is_null($user)){
            throw new \Exception($exceptionMessage,401);
        }
    }

    public function count($companyId)
    {
        return $this->repository->count($companyId);
    }
}