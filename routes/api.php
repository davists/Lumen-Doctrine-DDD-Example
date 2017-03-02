<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 2/19/17
 * Time: 9:55 AM
 */


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

$app->get('/', ['as' => 'profile', function () {
    echo "Hello World!";
}]);

$app->group(
    ['prefix'=>'api/v1'],
    function ($app) {

        //auth
        $app->post('auth/login', [
            'middleware' => ['throttle:30:5','cors'],
            'uses' => 'ManagerController@login',
        ]);

        //protected routes
        $app->group(['middleware' => ['jwt','throttle:30:5','cors']],function ($app){

          //manager
          require_once 'manager.php';

        });

    });
