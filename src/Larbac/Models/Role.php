<?php namespace Larbac\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_roles';

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
     * Relation to User model
     *
     * @return object
     */
    public function users()
    {
        return $this->belongsToMany("Larbac\Models\User",'tbl_role_user')->withTimestamps();
    }

    /**
     * Relation to Permission model
     *
     * @return object
     */
    public function permissions()
    {
        return $this->belongsToMany("Larbac\Models\Permission",'tbl_permission_role')->withTimestamps();
    }


}
