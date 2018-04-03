<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$app->get('/', function () {
    return 'Shop Manager Service.';
});

$app->group(['prefix'=>'api/v1', 'middleware' => ['throttle:3000:5','cors']], function () use ($app) {

    require_once (__DIR__ .'/product.php');
    require_once (__DIR__ .'/category.php');

    $app->post('/file/upload', 'FileUploadController@upload');
});

