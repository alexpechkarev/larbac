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
        $this->tablePrefix = 'tbl_';
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
           Schema::create($tablePrefix.'permissions', function(Blueprint $table)
           {
               $table->engine = 'InnoDB';

               $table->increments('id');
               $table->string('name', 100)->index();
               $table->string('description', 255)->nullable();
               $table->timestamps();
           });

           // Creating roles table
           Schema::create($tablePrefix.'roles', function($table)
           {
               $table->engine = 'InnoDB';

               $table->increments('id');
               $table->string('name', 100)->index();
               $table->string('description', 255)->nullable();
               $table->timestamps();
           });


           // Creating  role to user relations table
           Schema::create($tablePrefix.'role_user', function($table) use ($tablePrefix)
           {
               $table->engine = 'InnoDB';

               $table->integer('user_id')->unsigned()->index();
               $table->integer('role_id')->unsigned()->index();
               $table->timestamps();

               $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
               $table->foreign('role_id')->references('id')->on($tablePrefix.'roles')->onDelete('cascade');
           });

           // Creating permissions to roles relations table
           Schema::create($tablePrefix.'permission_role', function($table) use ($tablePrefix)
           {
               $table->engine = 'InnoDB';

               $table->integer('permission_id')->unsigned()->index();
               $table->integer('role_id')->unsigned()->index();
               $table->timestamps();

               $table->foreign('permission_id')->references('id')->on($tablePrefix.'permissions')->onDelete('cascade');
               $table->foreign('role_id')->references('id')->on($tablePrefix.'roles')->onDelete('cascade');
           });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop($this->tablePrefix.'role_user');
            Schema::drop($this->pretablePrefixfix.'permission_role');
            Schema::drop($this->tablePrefix.'roles');
            Schema::drop($this->prtablePrefixefix.'permissions');
	}

}
