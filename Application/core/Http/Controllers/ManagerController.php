<?php

namespace Application\Core\Http\Controllers;

use Application\Core\Services\Manager\ManagerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class ManagerController
 * @package Application\Core\Http\Controllers
 */
class ManagerController extends Controller
{
    /**
     * @var ManagerService
     */
    public $managerAppService;

    /**
     * ManagerController constructor.
     * @param ManagerService $managerService
     */
    public function __construct(ManagerService $managerService)
    {
        $this->managerAppService = $managerService;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $data = $request->only(['email','password']);
        $email = $data['email'];
        $password = $data['password'];

        return $this->managerAppService->login($email,$password);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $post = $request->all();
        return $this->managerAppService->createManager($post);
    }


    /**
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getByPage($page, $limit)
    {
        return $this->managerAppService->getByPage($page,$limit);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function getByFilter(Request $request)
    {
        $criteria = $request->only(['filter']);
        return $this->managerAppService->getByFilter($criteria['filter']);
    }

}
