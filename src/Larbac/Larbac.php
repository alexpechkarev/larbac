<?php namespace Larbac;

use Larbac\Contracts\LarbacInterface;

/**
 * Description of Larbac
 *
 * @author Alexander Pechkarev <alexpechkarev@gmail.com>
 */
class Larbac implements LarbacInterface{
    
    /**
     * Permissions array
     *
     * @var permissions
     */    
    protected $permission;
    
    
    
    /**
     * Initialize permission(s) 
     * @param type $permission - default []
     */
    public function __construct() {
        
        #$this->permission = $permission;
    }
    /***/
    
    /**
     * Get permission(s) array
     * @return array
     */
    public function getPermission() {
        
        return $this->permission;
    }
    /***/
    
    
    /**
     * Set permission(s) array
     */
    public function setPermission($permissions) {
        $this->permission = $permissions;
    }
    /***/    
}
