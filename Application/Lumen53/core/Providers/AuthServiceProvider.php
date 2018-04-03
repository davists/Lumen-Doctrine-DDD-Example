<?php

namespace Application\Lumen53\Providers;

use Illuminate\Support\ServiceProvider;
use Firebase\JWT\JWT;
use \Application\Lumen53\Exceptions\ApplicationException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if(!$request->hasHeader('Authorization')){
                throw new ApplicationException('Token not found in request',400);
            }

            $authHeader = $request->header('Authorization');

            try{
                list($jwt) = (sscanf($authHeader,'Bearer %s'));
                $decryptedToken = JWT::decode($jwt,  getenv('JWT_KEY'), [getenv('JWT_ENCRYPT_ALGORITHM')]);
                $decryptedToken->jwt = $jwt;
                //success on decode the token
                return $decryptedToken;

            }catch (\Exception $e){
                throw new ApplicationException('Unauthorized',401);
            }
        });
    }
}