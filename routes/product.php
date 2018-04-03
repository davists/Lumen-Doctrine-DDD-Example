<?php

$app->group(['prefix' => 'products','middleware' => ['jwt','throttle:30:5','cors']], function () use ($app) {
    $app->get('/', 'ProductController@index');
    $app->get('/{productId}', 'ProductController@show');
    $app->post('/', 'ProductController@store');
    $app->put('/{productId}', 'ProductController@update');
    $app->delete('/{productId}', 'ProductController@destroy');
});
