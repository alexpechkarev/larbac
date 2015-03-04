<?php namespace Larbac\Models;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table ;

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
            
            $this->table = config('larbac.tablePrefix').config('larbac.tables.permissionTable');
            parent::__construct();            
        }
        /***/
        
        /**
         * Roles
         *
         * @return object
         */
        public function roles()
        {
            $table = config('larbac.tablePrefix').config('larbac.tables.roleTable');
            return $this->belongsToMany("Larbac\Models\Role",$table)->withTimestamps();
        }
    
}
