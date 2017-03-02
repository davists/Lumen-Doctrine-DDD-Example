<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 2/27/17
 * Time: 1:11 AM
 */
namespace Domain\Manager\Contracts;

use Domain\Manager\Entities\Manager;

/**
 * Interface RepositoryContract
 */
interface ManagerRepositoryContract{

    /**
     * @param Manager $manager
     * @return mixed
     */
    public function create(Manager $manager);

    /**
     * @param Manager $manager
     * @return mixed
     */
    public function update(Manager $manager, $data);

    /**
     * @param Manager $manager
     * @return mixed
     */
    public function delete(Manager $manager);

    /**
     * @param $data
     * @return mixed
     */
    public function load($data);

    /**
     * @return mixed
     */
    public function findById($id);

    /**
     * @return mixed
     */
    public function findByCriteria(array $criteria);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @return mixed
     */
    public function toArray(Manager $manager);


    /**
     * @param $email
     * @return mixed
     */
    public function findByEmail($email);


    /**
     * @param $dql
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function paginate($dql, $page=1, $limit=10);
}