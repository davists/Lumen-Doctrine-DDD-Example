<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 3/1/17
 * Time: 10:56 PM
 */
namespace Domain\Manager\Contracts;

interface ManagerLoginServiceContract{

    public function execute($email,$password);

}