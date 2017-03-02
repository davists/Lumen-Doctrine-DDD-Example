<?php

require_once __DIR__.'/../../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    throw new \Exception($e->getMessage());
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->withFacades();

// $app->withEloquent();


/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Application\Core\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Application\Core\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

//called in controllers construct
// $app->middleware([
//    Application\Core\Http\Middleware\ExampleMiddleware::class
// ]);

//called for a group of controllers/routes
 $app->routeMiddleware([
     'jwt' => Application\Core\Http\Middleware\JWTMiddleware::class,
     'cors' => Application\Core\Http\Middleware\CORSMiddleware::class,
     'throttle' => GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware::class,
 ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

//Bind for interfaces and implementation
$app->register(\Application\Core\Providers\ManagerServiceProvider::class);

//Doctrine Service Provider And Facedes Register
$app->register(LaravelDoctrine\ORM\DoctrineServiceProvider::class);
class_alias('LaravelDoctrine\ORM\Facades\EntityManager', 'EntityManager');
class_alias('LaravelDoctrine\ORM\Facades\Registry', 'Registry');
class_alias('LaravelDoctrine\ORM\Facades\Doctrine', 'Doctrine');

//Throttle Api
$app->register(GrahamCampbell\Throttle\ThrottleServiceProvider::class);
class_alias('GrahamCampbell\Throttle\Facades\Throttle', 'Throttle');

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'Application\Core\Http\Controllers'], function ($app) {
    require __DIR__.'/../../routes/api.php';
});

return $app;
