<?php


require_once __DIR__.'/../../../vendor/autoload.php';

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

$app->configure('filesystems');



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
    Application\Lumen53\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Application\Lumen53\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Filesystem\Factory::class,
    function ($app) {
        return new Illuminate\Filesystem\FilesystemManager($app);
    }
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
$app->middleware([
    Application\Lumen53\Http\Middleware\CORSMiddleware::class,
]);

//called for a group of controllers/routes
$app->routeMiddleware([
    'jwt' => Application\Lumen53\Http\Middleware\JWTMiddleware::class,
    'cors' => Application\Lumen53\Http\Middleware\CORSMiddleware::class,
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

// $app->register(App\Providers\EventServiceProvider::class);
// $app->register(App\Providers\AppServiceProvider::class);
$app->register(\Application\Lumen53\Providers\AuthServiceProvider::class);
$app->register(\Application\Lumen53\Providers\CatchAllOptionsRequestsProvider::class);

$app->register(\Application\Lumen53\Providers\ProductServiceProvider::class);
$app->register(\Application\Lumen53\Providers\CategoryServiceProvider::class);
$app->register(\Application\Lumen53\Providers\ProductCategoryServiceProvider::class);

//Bind for interfaces and implementation
// $app->register(\Application\Lumen53\Providers\ManagerServiceProvider::class);

//Doctrine Service Provider And Facedes Register
$app->register(LaravelDoctrine\ORM\DoctrineServiceProvider::class);

$app->register(LaravelDoctrine\Migrations\MigrationsServiceProvider::class);

//Throttle Api
$app->register(GrahamCampbell\Throttle\ThrottleServiceProvider::class);

//excel
$app->register(Maatwebsite\Excel\ExcelServiceProvider::class);
class_alias('Maatwebsite\Excel\Facades\Excel', 'Excel');

//filesystem useful to S3
$app->singleton('filesystem', function ($app) {
    return $app->loadComponent('filesystems', 'Illuminate\Filesystem\FilesystemServiceProvider', 'filesystem');
});

class_alias('Illuminate\Support\Facades\Storage', 'Storage');

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

$app->group(['namespace' => 'Application\Lumen53\Http\Controllers'], function ($app) {
    require __DIR__.'/../../../routes/routes.php';
});

return $app;
