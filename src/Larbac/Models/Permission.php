<?php namespace Larbac\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_permissions';

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
     * Roles
     *
     * @return object
     */
    public function roles()
    {
        return $this->belongsToMany("Larbac\Models\Role",'tbl_permission_role')->withTimestamps();
    }
    
}
