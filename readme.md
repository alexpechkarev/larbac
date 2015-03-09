# LARBAC

Role based access control package for Laravel 5.

Intentions of this package is to apply RBAC abstraction level to promote secure user administration.
Access decisions are based on the roles and permissions individual users have as part of organization. The basic concept is that users obtain permissions by being member of role, where permissions are assigned to roles and roles assigned to users. User-role and permission-role have many-to-many relation, allowing single role have many users and single user have many roles, same applies to permissions. 

This package includes frontend interface that allows: 

 - create, edit and delete permissions
 - create, edit and delete roles
 - assign permissions to roles
 - assign roles to users

By default frontend option is set to `true`, if you wish to create roles and assign permissions in your own way simply turn this option off in configuration file of this package.


## Requirements

- [Laravel 5] (http://laravel.com/)
- [illuminate/html] (https://github.com/illuminate/html)

## Front-end dependency

- [jQuery](http://jquery.com/) 
- [Bootstrap](http://getbootstrap.com/) 
- [Dual listbox](http://www.virtuosoft.eu/code/bootstrap-duallistbox)

## Installation
Install package issuing [Composer](https://getcomposer.org/) command in terminal:

```sh
$ composer require alexpechkarev/larbac:dev-master
```

Update provider and aliases arrays in config/app.php with:

```
providers:
    ...
    'Illuminate\Html\HtmlServiceProvider',
    'Larbac\Provider\LarbacServiceProvider',


```

Before executing migrations please review migration file located in Migration folder of this package.
Four tables will be created with prefix tbl_ `[ tbl_permissions, tbl_roles, tbl_role_user, tbl_permission_role ]`
Publish package assets:

```
    php artisan vendor:publish

```

Package extends default Laravel Authentication Model by defining table relations and validation methods. 
Update config/auth.php

```
    #'model' => 'App\User',
    'model'  => 'Larbac\Models\User',
```

Register package middleware with HTTP kernel route array

	protected $routeMiddleware = [
                 ...
                'larbac'  => 'Larbac\Middleware\LarbacMiddleware.php',
	];


## Config

After publishing package assets configuration file will be located in 

```
    config/larbac.php

```

## Create database tables

Reviewing database table names in config file and change any if necessary, than run the migration: 

```
    php artisan migrate

```

By default frontend interface set to `true`. These are default URL's:

```
    |   User interface can be accessed via          - http://yourdomain.net/user
    |   Permission interface can be accessed via    - http://yourdomain.net/permission
    |   Roles interface can be accessed via         - http://yourdomain.net/role

```

Routes defined in config file and can be modified at any time.
 
```
	'routes' => [
            
            'routeUser'       => 'user', 
            'routePermission' => 'permission', 
            'routeRoles'      => 'role' 
        ],

```


### Frontend interface

To inject `javascript` dependency resources into interface templates make sure that default layout template `resources/views/app.blade.php` or your own template have following section: `@section('footer-js') ... @show`.


```
        @section('footer-js')
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
        @show  

```




## Use

After creating your permissions / roles, establishing relations between them and assigning roles to user, access restrictions can be specified within your controller:

```
	public function __construct()
	{
                // Setting role based access
                $permissions = ['role'=>['Admin']  ];
                

                if( is_object(Request::route()) ) {
                    
                    Request::route()->setParameter('larbac', $permissions);
                    $this->middleware('larbac');  
                }
	}

```

Varies restriction rules can be set by specifying array of roles, array of permissions or both.

Validating more than one role: 
 - user must be assigned to one of the given roles

```
    $permissions = ['role'=>['Admin', 'Staff']  ];
    ....

```

Validating more than one role along with permission:
- user must be assigned to one of the given roles
- at least one role must have given permission

```
    $permissions = ['role'=>['Admin', 'Staff'], 'permissions' => ['view']  ];
    ....

```

Validating more than one role along with permission:
- user must be assigned to one of the given roles
- at least one role must have given permissions

```
    $permissions = ['role'=>['Admin', 'Staff'], 'permissions' => ['view', 'edit']  ];
    ....

```

Permission based validation only:
- user must have given permission

```
    $permissions = ['permissions' => ['edit']  ];
    ....

```

Assigning access control in routes files:

```
    Route::get('/post', 
                        [
                            'middleware' => 'larbac', 
                            'larbac' => [
                                            'role'=>['Admin'], 
                                            'permissions' => ['can_save']  
                                        ],
        function(){
     
           return view('welcome');
           
    }]);

```

## Frontend screen shots

### Permissions

Create new permission: /permission/create

![Screenshot](src/img/permission_create.png?raw=true "Create new permission: http://mydomain.net/permission/create")

View permissions: /permission

![Screenshot](src/img/permission_view.png?raw=true "View roles: http://mydomain.net/permission")


Edit permission: /permission/1/edit/

![Screenshot](src/img/permission_edit.png?raw=true "Edit permission: http://mydomain.net/permission/1/edit")


Delet permission: 

![Screenshot](src/img/permission_delete.png?raw=true "Delete permission")


### Roles

Create new role and assign permission: /role/create

![Screenshot](src/img/role_create.png?raw=true "Create new role: http://mydomain.net/role/create")

View roles: /role

![Screenshot](src/img/role_view.png?raw=true "View roles: http://mydomain.net/role")


Edit role: /role/1/edit/

![Screenshot](src/img/role_edit.png?raw=true "Edit role: http://mydomain.net/role/1/edit")



### Users

View users: /user

![Screenshot](src/img/user_view.png?raw=true "View users: http://mydomain.net/user")


Assign role to user: /user/1/edit/

![Screenshot](src/img/user_assign.png?raw=true "Assign role to user: http://mydomain.net/user/1/edit")


## Using without frontend

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



##Support

Discovered an error or would like to suggest an improvement ? Please do email me or open an [issue on GitHub](https://github.com/alexpechkarev/larbac/issues)


##License

Larbac for Laravel 5 is released under the MIT License. See the bundled
[LICENSE](https://github.com/alexpechkarev/larbac/blob/master/LICENSE)
file for details.