<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 2/26/17
 * Time: 1:19 AM
 */

namespace Application\Core\Services\Manager;

use Domain\Manager\Contracts\ManagerRepositoryContract;
use Domain\Manager\Services\ManagerLoginService;
use Application\Core\Http\Response\JsonResponseDefault;

/**
 * Class ManagerService
 * @package Application\Core\Services\Manager
 */
class ManagerService
{
    /**
     * @var ManagerRepositoryContract
     */
    private $repository;

    /**
     * ManagerService constructor.
     * @param ManagerRepositoryContract $repository
     */
    public function __construct(ManagerRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function login($email, $password)
    {
        $managerLogin = new ManagerLoginService($this->repository);
        $response = $managerLogin->execute($email,$password);

        return JsonResponseDefault::create(true,$response,'successfully logged in',200);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createManager($data)
    {
        $manager = $this->repository->load($data);
        $this->repository->create($manager);

        return JsonResponseDefault::create(true,'manager saved successfully','manager saved successfully',200);
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getByPage($page,$limit)
    {
        $sql = "SELECT u FROM Domain\Manager\Entities\Manager u ";
        $pagination = $this->repository->paginate($sql,$page,$limit);

        return JsonResponseDefault::create(true,$pagination,'managers retrieved successfully',200);
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getByFilter($criteria)
    {
        $filter = $this->repository->findByCriteria($criteria);

        return JsonResponseDefault::create(true,$filter,'managers retrieved successfully',200);
    }

}