<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Default Table Prefix
	|--------------------------------------------------------------------------
	|
	| Default database tables prefix
	|
	*/

	'tablePrefix' => 'tblss_',

	/*
	|--------------------------------------------------------------------------
	| Tables 
	|--------------------------------------------------------------------------
	|
        | Defaut database tables
	|
	*/

        'tables' => [
            'permissionTable'       => 'permissions',
            'roleTable'             => 'roles',
            'roleToUserTable'       => 'role_user',
            'permissionToRoleTable' => 'permission_role'
            
        ],

	/*
	|--------------------------------------------------------------------------
	| Error Messages
	|--------------------------------------------------------------------------
	|
        | Specify your own error messages here
        | 
        | See Larbac\Middleware\LarbacMiddleware.php to specify your own messages
	|
	*/

	'messages' => [
            'notAuthorized'       => 'Only authenticated users allowed',
            'invalidPermission'   => 'Invalid permissions',
        ],
    
    
    
	/*
	|--------------------------------------------------------------------------
	| Redirect Routes
	|--------------------------------------------------------------------------
	|
        | logIn -  used when user redirected from auth/login and have 
        |          no access permission for requested action, 
        |          $this->auth->logout() will be executed before redirect
        |
        | home - used in redirect loop when current and previous routes are equal
        | 
        | See Larbac\Middleware\LarbacMiddleware.php to specify your own redirect rules
	|
	*/

	'redirect' => [
            'logIn'       => 'auth/login',
            'home'        => '/',
        ],
    

	

];
