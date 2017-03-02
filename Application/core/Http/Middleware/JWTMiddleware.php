<?php

namespace Application\Core\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Application\Core\Exceptions\JWTException;
use \Exception;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->hasHeader('Authorization')){
            throw new JWTException('Token not found in request',400);
        }

        $authHeader = $request->header('Authorization');

        try{
            list($jwt) = (sscanf($authHeader,'Bearer %s'));
            $token = JWT::decode($jwt,  getenv('APP_KEY'), [getenv('APP_ENCRYPT_ALGORITHM')]);

            //success on decode the token
            return $next($request);

        }catch (Exception $e){
            throw new JWTException('Unauthorized',401);
        }
    }
}
