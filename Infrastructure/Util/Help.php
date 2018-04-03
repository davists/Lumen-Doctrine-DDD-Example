<?php
namespace Infrastructure\Util;

use Infrastructure\Util\ArrayHelper;
use Infrastructure\Util\JsonHelper;
use Infrastructure\Util\HttpRequestHelper;
use Infrastructure\Util\DateHelper;
use Infrastructure\Util\JMSHelper;

class Help
{
    public $array;
    public $json;
    public $http;
    public $date;
    public $accents;
    
    public function __construct()
    {
        $this->array = new ArrayHelper();
        $this->json =  new JsonHelper();
        $this->http =  new HttpRequestHelper();
        $this->date =  new DateHelper();
        $this->accents =  new AccentsHelper();
        $this->jms = new JMSHelper();
    }
}