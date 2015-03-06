<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

    Route::resource('user'
                        ,'Larbac\Controllers\UserController'
                        ,[ 'only' => ['index', 'edit', 'update'] ]
                    );
    
    Route::resource('permission'
                        ,'Larbac\Controllers\PermissionController'
                        ,array('except' => array('show')));
    
    Route::resource('roles'
                         ,'Larbac\Controllers\RoleController'
                         ,[ 'except' => ['show'] ]
                    );  
