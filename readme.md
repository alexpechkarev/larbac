# LARBAC
Simple access control package for Laravel 5 based on the RBAC model.


## Requirements

- [Laravel 5] (http://laravel.com/)

## Installation
Install package issuing [Composer](https://getcomposer.org/) command in terminal:

```sh
$ composer require alexpechkarev/larbac:dev-master
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


## Config



## Usage
Out of box Laravel comes with model and controllers that handles user registration and authentication process. Here we will create roles and permissions that can be applied to those users.
First create roles and permissions:

```
    /**
    * Creating role
    */
    $role = Larbac\Models\Role::create(['name' => 'Admin']); // assuming role id will be 5
    
    // with optional role description 
    $role = Larbac\Models\Role::create(['name' => 'Admin', 'description' => 'App administrator']);

    /**
    * Creating permission
    */
    $permission = Larbac\Models\Permission::create(['name' => 'can_save']); // assuming permission id will be 12

    // with optional permission description
    $permission = Larbac\Models\Role::create(['name' => 'can_save', 'description' => 'Allow save changes']);

```

Next assign permission(s) to a Role:

```
    /*
    * Assigning permission(s) to a role
    * 'Admin' role id = 5
    * 'can_save' permission id = 12
    */
    $role = Larbac\Models\Role::find(5); // find Admin role by id - 5
    $role->permissions()->sync([12]); // Assign 'can_save',using permission id - 12
    
```    


Multiply permissions can also be assigned to a Role by supplying array of permission id's.
To keep in mind that `sync( [12,13,14] )` will remove any other permissions that have been granted before and not specified in the given array.

```

    /**
     * Assigning multiply permissions to a Role
     * 
     * 'Admin' role id = 5
     * 
     * 'can_save' id = 12
     * 'can_view' id = 13
     * 'can_edit' id = 14
     */
    $role = Larbac\Models\Role::find(1);
    $role->permissions()->sync([12,13,14]);


    ...

    /**
     * Will revoke 'can_view' id = 13 and only grant given permissions
     * 
     * 'Admin' role id = 5
     * 
     * 'can_save' id = 12
     * 'can_edit' id = 14
     */
    $role->permissions()->sync( [12,14] );

```


Next assign a Role to an User:
```

    /*
    * Assigning role to an user
    */
    $user = Larbac\Models\User::find(20); // assuming user id is 20
    $user->roles()->sync([5]); // Assigning user [id = 20] an Admin role [id = 5]

```

User access can be verified based on the role, permission or both. Package middleware method can be called from controller constructor or individual controller methods.
To verify user permissions in the controller use following:

```
    use Larbac\Larbac;
    use \Illuminate\Support\Facades\Request;
    
    ...

    public function __construct(){

        $permissions = ['role'=>['Admin'], 'permissions' => ['can_save']  ];
        Request::route()->setParameter('larbac', $permissions);
        $this->middleware('larbac');

    }
```



To assign access control to a route use following:

```
    Route::get('/post', 
    ['middleware' => 'larbac', 'larbac' => ['role'=>['Admin'], 'permissions' => ['can_save']  ],function(){
     
           return view('post_view');
           
    }]);
```

Support
-------

[Discovered an error or would like to suggest an improvement please do email me or open an issue on GitHub](https://github.com/alexpechkarev/larbac/issues)


License
-------

Larbac for Laravel 5 is released under the MIT License. See the bundled
[LICENSE](https://github.com/alexpechkarev/larbac/LICENSE)
file for details.