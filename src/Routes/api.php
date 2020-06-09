<?php

use Illuminate\Support\Facades\Route;

Route::namespace ('Task\Tracker\Controllers')->as('tracker::')->middleware('api')->group(function () {
    // Routes defined here have the api middleware applied
    // like the api.php file in a laravel project
    // They also have an applied controller namespace and a route names.
    foreach (array('tasks' => 'TaskController', 'users' => 'UserController') as $path => $controller) {
        Route::match(array('get', 'post'), $path . '/search/{id?}', $controller . '@search');
        Route::resource($path, $controller)->except(array('create', 'edit'));
    }
});
