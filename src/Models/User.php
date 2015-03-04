<?php namespace Larbac\Models;


class User extends \App\User{
       
    

    /**
     * Roles
     *
     * @return object
     */
    public function roles()
    {
        $table = config('larbac.tablePrefix').config('larbac.tables.roleToUserTable');
        return $this->belongsToMany("Larbac\Models\Role",$table)->withTimestamps();
    }



    /**
     * Is given role assigned to a user
     *
     * @param  string or array
     * @return boolean
     */
    public function hasRole($checkRoles = 'none')
    {
       
        /**
         *  is array given? 
         *  cast variable to an array type
         */
        if( !is_array($checkRoles)){
            settype($checkRoles, "array");
        } 
  
        $relations = $this->queryRelation();
        
        $roles = $relations->roles()->first();
        
        // is role assigned to a user
        if(empty($roles)){
            
            return false;
        }
        
        /*
         *  get current user roles
         */
        $hasRole = $roles->lists('name');
        
        /*
         *  intersect available and verified user roles
         */
        $userRole = count( array_intersect( $hasRole, $checkRoles ) ) ;

        return !empty($userRole);
    }

    /**
     * Can User permorm a certain task(s)
     *
     * @param  string or array of verified permisions
     * @return boolean 
     * 
     * 
     * Test sql
     * 
     *   SELECT
     *
     *       FROM users u
     *       INNER JOIN tbl_role_user ru ON u.id = ru.user_id
     *       INNER JOIN tbl_roles r ON ru.role_id = r.id
     *       INNER JOIN tbl_permission_role pr ON r.id = pr.role_id
     *       INNER JOIN tbl_permissions p ON p.id = pr.permission_id
     *
     *       WHERE u.id = 1
     *       AND p.name IN ('process_order', 'view_order')
     *
     *      GROUP BY u.id
     *  
     */
    public function hasPermission($hasPermissions = 'none')
    {

        
        /**
         * is array given ?
         * set variable to an array type
         */
        if( !is_array( $hasPermissions ) ){
             settype($hasPermissions, "array");
        }

        /**
         *  get relations
         */
        $relations = $this->queryRelation();
        
        
        $roles = $relations->roles()->first();
        
        // is role assigned to a user
        if(empty($roles)){
            
            return false;
        }
        
        /**
         *  get array of user granted permissions
         */
        $userPermissions = $roles
                            ->permissions()
                            ->first()
                            ->lists('name');
        
        
        /**
         *  intersect available and verified user permissions
         */
        $userCan = count( array_intersect( $userPermissions, $hasPermissions ) ) ;
        
        
        return !empty($userCan);

    }
    /***/

    /**
     * Get get role permission relation for given user
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function queryRelation(){
        
        $primaryKey = $this->getKeyName();
        
        
        return $this->with(['roles', 'roles.permissions'])
                      ->where($primaryKey, '=', $this->attributes[$primaryKey])
                      ->first();        
    }
    /***/
    


       

}
