# LARBAC
Simple access control package for Laravel 5 based on the Role Based Access Control model.


## Requirements

- [Laravel 5] (http://laravel.com/)

## Installation
Install package issuing [Composer](https://getcomposer.org/) command in terminal:

```sh
$ composer require alexpechkarev/larbac : dev-master
```

Update provider and aliases arrays in config/app.php with:

```
providers:
    ...
    'Larbac\Provider\LarbacServiceProvider',

```

Before executing migrations please review migration file located in Migration folder of this package.
Four tables will be created with prefix tbl_ [ tbl_permissions, tbl_roles, tbl_role_user, tbl_permission_role ]
Publish and run package migrations issue following commands:

```
    php artisan vendor:publish

    php artisan migrate

```

Package extends default Laravel Authentication Model by defining table relations and validation methods. 
Update config/auth.php

```
	#'model' => 'App\User',
        'model' => 'Larbac\Models\User',
```

Register package middleware with HTTP kernel route array

	protected $routeMiddleware = [
                 ...
                'larbac'  => 'Larbac\Middleware\LarbacMiddleware.php',
	];


## Usage

First create roles and permissions:

```
    /**
    * Creating role
    */
    $role = new \Larbac\Models\Role::create(['name' => 'Admin']); // assuming role id will be 5
    
    // with optional role description 
    $role = new \Larbac\Models\Role::create(['name' => 'Admin', 'description' => 'App administrator']);

    /**
    * Creating permission
    */
    $permission = new \Larbac\Models\Permission::create(['name' => 'can_save']); // assuming permission id will be 12

    // with optional permission description
    $permission = new \Larbac\Models\Role::create(['name' => 'can_save', 'description' => 'Allow save changes']);

```

Next assign permission(s) to role and than role(s) to user:

```
    /*
    * Assigning permission(s) to a role
    */
    $role = \Larbac\Models\Role::find(5); // find Admin role by id - 5
    $role->permissions()->sync([12]); // Assign 'can_save',using permission id - 12
    
    /*
    * Assigning role(s) to a user
    */
    $user = \Larbac\Models\User::find(20); // assuming user id is 20
    $user->roles()->sync([5]); // Assigning user [id = 20] an Admin role [id = 5]

```

User access can be verified based on the role, permission or both. Package middleware method can be called from controller constructor or individual controller methods.
To verify user permissions in the controller use following:

```
    use Larbac\Larbac;
    use \Illuminate\Support\Facades\Request;
    
    ...

    public function __construct(){

        Request::route()->setParameter('larbac', ['role'=>['Admin'], 'permissions' => ['can_save']  ]);
        $this->middleware('larbac');

    }
```



To assign access control to a route use following:

```
    Route::get('/post', ['middleware' => 'larbac', 'larbac' => ['role'=>['Admin'], 'permissions' => ['can_save']  ],function(){
     
           return view('post_view');
           
    ]}
```

