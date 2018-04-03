<?php
namespace Infrastructure\Util;
use GuzzleHttp\Client;

class HttpRequestHelper
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    
    public function requestAuth(Array $aArr=[])
    {
        $aOpt = [];
        if(count($aArr['aPost']) > 0){
            $aOpt['form_params'] = $aArr['aPost'];
        }
        
        if(array_key_exists('jwt', $aArr)){
            $aOpt['headers'] = ['Authorization'=>('Bearer '. $aArr['jwt'])];
        }
        
        $hBuffer = $this->client->request($aArr['type'], $aArr['url_route'], $aOpt)->getBody()->getContents();
        
        return json_decode($hBuffer, true);
    }
}
