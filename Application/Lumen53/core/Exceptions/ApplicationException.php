<?php

/**
 * Created by PhpStorm.
 * User: davi
 * Date: 4/10/17
 * Time: 1:53 PM
 */
namespace Application\Lumen53\Exceptions;

class ApplicationException extends \Exception
{
    public function getStatusCode()
    {
        return $this->getCode();
    }
}
