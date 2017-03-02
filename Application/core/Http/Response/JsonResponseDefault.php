<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 2/27/17
 * Time: 12:02 AM
 */

namespace Application\Core\Http\Response;

use Illuminate\Http\JsonResponse;

/**
 * Class JsonResponseDefault
 * @package Application\Core\Http\Response
 */
class JsonResponseDefault
{

    /**
     * @param $success
     * @param $data
     * @param $message
     * @param $code
     * @return mixed
     */
    public static function create($success, $data, $message, $code)
    {
        $response = [
            'success' => $success,
            'data'  => $data,
            'message' => $message,
            'code'    => $code
        ];

        $header = [$response['code'] => $response['message']];

        return JsonResponse::create($response,$response['code'],$header);
    }
}