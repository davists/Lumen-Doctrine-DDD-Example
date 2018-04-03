<?php

$app->group(['prefix' => 'categories','middleware' => ['jwt','throttle:30:5','cors']], function () use ($app) {
    $app->get('/', 'CategoryController@index');
    $app->get('/{categoryId}', 'CategoryController@show');
    $app->post('/', 'CategoryController@store');
    $app->put('/{categoryId}', 'CategoryController@update');
    $app->delete('/{categoryId}', 'CategoryController@destroy');
});
