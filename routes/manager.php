<?php


$app->post('managers/create', [
    'uses' => 'ManagerController@create',
]);

$app->get('managers/getByPage/{page}/{limit}', [
    'uses' => 'ManagerController@getByPage',
]);

$app->post('managers/filter/', [
    'uses' => 'ManagerController@getByFilter',
]);
