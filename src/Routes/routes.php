<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
| Package routes registered below, actual routes specified in config file.
|
*/

    Route::resource(config('larbac.routes.routeUser')
                        ,'Larbac\Controllers\UserController'
                        ,[ 'only' => ['index', 'edit', 'update'] ]
                    );
    
    Route::resource(config('larbac.routes.routePermission')
                        ,'Larbac\Controllers\PermissionController'
                        ,array('except' => array('show')));
    
    Route::resource(config('larbac.routes.routeRoles')
                         ,'Larbac\Controllers\RoleController'
                         ,[ 'except' => ['show'] ]
                    );  
