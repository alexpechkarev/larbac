<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreatePermissionTables extends Migration {
    
    /**
     * Table prefix
     * 
     * @todo pull content from config
     */
    protected $tablePrefix;
    
    /**
     * 
     */
    public function __construct()
    {
        $this->tablePrefix = config('larbac.tablePrefix');
    }
    /***/
    

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            
            // Table prefix
            $tablePrefix = $this->tablePrefix;
        
            // Creating permissions table
           Schema::create($tablePrefix.config('larbac.tables.permissionTable'), function(Blueprint $table)
           {
               $table->engine = 'InnoDB';

               $table->increments('id');
               $table->string('name', 100)->index();
               $table->string('description', 255)->nullable();
               $table->timestamps();
           });

           // Creating roles table
           Schema::create($tablePrefix.config('larbac.tables.roleTable'), function($table)
           {
               $table->engine = 'InnoDB';

               $table->increments('id');
               $table->string('name', 100)->index();
               $table->string('description', 255)->nullable();
               $table->timestamps();
           });


           // Creating  role to user relations table
           Schema::create($tablePrefix.config('larbac.tables.roleToUserTable'), function($table) use ($tablePrefix)
           {
               $table->engine = 'InnoDB';

               $table->integer('user_id')->unsigned()->index();
               $table->integer('role_id')->unsigned()->index();
               $table->timestamps();

               $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
               $table->foreign('role_id')->references('id')->on($tablePrefix.'roles')->onDelete('cascade');
           });

           // Creating permissions to roles relations table
           Schema::create($tablePrefix.config('larbac.tables.permissionToRoleTable'), function($table) use ($tablePrefix)
           {
               $table->engine = 'InnoDB';

               $table->integer('permission_id')->unsigned()->index();
               $table->integer('role_id')->unsigned()->index();
               $table->timestamps();

               $table->foreign('permission_id')->references('id')->on($tablePrefix.'permissions')->onDelete('cascade');
               $table->foreign('role_id')->references('id')->on($tablePrefix.'roles')->onDelete('cascade');
           });
           
           /**
            * Create Admin role
            */
            $roleId = DB::table($tablePrefix.config('larbac.tables.roleTable'))->insertGetId(
                            ['name' => 'Admin', 'description' => 'Default administrator role']
                            ); 
            
            $user = User::find(config('larbac.user'));
            
            if( !empty($user)){
                
                /**
                 * Assign Admin role to a user
                 */
                DB::table($tablePrefix.config('larbac.tables.roleToUserTable'))->insert(
                        [
                            ['user_id' => $user->id, 'role_id' => $roleId]
                        ]
                        );                  
                
            }
            
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop($this->tablePrefix.config('larbac.tables.roleToUserTable'));
            Schema::drop($this->tablePrefix.config('larbac.tables.permissionToRoleTable'));
            Schema::drop($this->tablePrefix.config('larbac.tables.roleTable'));
            Schema::drop($this->tablePrefix.config('larbac.tables.permissionTable'));
	}

}
