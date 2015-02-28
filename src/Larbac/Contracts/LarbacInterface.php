<?php namespace Larbac\Contracts;


/**
 *
 * @author Alexander Pechkarev <alexpechkarev@gmail.com>
 */
interface LarbacInterface {
    
    public function getPermission();
    public function setPermission($permissions);
}
