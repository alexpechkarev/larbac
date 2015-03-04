<?php namespace Larbac\Models;

use Illuminate\Database\Eloquent\Model;


class Role extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

        
        /**
         * Initialize table name
         */
        public function __construct() {
            
            $this->table = config('larbac.tablePrefix').config('larbac.tables.roleTable');
            parent::__construct();
        }
        /***/        


        /**
         * Relation to User model
         *
         * @return object
         */
        public function users()
        {
            $table = config('larbac.tablePrefix').config('larbac.tables.roleToUserTable');
            return $this->belongsToMany("Larbac\Models\User",$table)->withTimestamps();
        }

        /**
         * Relation to Permission model
         *
         * @return object
         */
        public function permissions()
        {
            $table = config('larbac.tablePrefix').config('larbac.tables.permissionToRoleTable');
            return $this->belongsToMany("Larbac\Models\Permission",$table)->withTimestamps();
        }


}
