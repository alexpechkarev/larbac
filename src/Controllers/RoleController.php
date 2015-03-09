<?php namespace Larbac\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Larbac\Models\Role;
use Larbac\Models\Permission;


/**
 * Description of RoleController
 *
 * @author Alexander Pechkarev <alexpechkarev@gmail.com>
 */
class RoleController extends Controller{
   


    /**
     * Class constructor
     */
    public function __construct() {
      
    }
    /***/


    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $roles = Role::all();       
            return view('larbac::roles.view-role', compact("roles"));
	}
        /***/

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{                          
            $availPermissions = Permission::select('id', 'name')->orderBy('name')->lists('name', 'id');
            
            return view('larbac::roles.create-role', compact('availPermissions'));
	}
        /***/

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            
            if(!Request::has('name')){
                return redirect()->back()->withInput();
            }
             
            $role = new Role;
            $role->name        = Request::get('name');
            $role->description = Request::get('description');
            $role->save();
            
            $perms = is_array(Request::get('permissions')) ? Request::get('permissions') : [];
            $role->permissions()->sync($perms);
           
            return redirect(route(config('larbac.routes.routeRoles').'.index'));

	}
        /***/



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            
            $role = Role::with(array('permissions'=>function($query){
                                                        $query->select('id');
                                                    }))->findOrFail($id);
            
            $data = array(
                "id"                    =>  $role->id,
                "name"                  =>  $role->name,
                "description"           =>  $role->description,
                "availPermissions"      =>  Permission::select('id', 'name')->orderBy('name')->lists('name', 'id'),
                "assignedPermissions"   =>  $role->permissions->lists('id')
            );
            
            return view('larbac::roles.edit-role', $data);
	}
        /***/

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{  
            
            $role = Role::findOrFail($id);
            
            if( $role->update(Request::all()) ):
                
                $permissions = is_array(Request::get('permissions')) ? Request::get('permissions') : [];
                $role->permissions()->sync($permissions);
                
                return redirect(route(config('larbac.routes.routeRoles').'.index'));                
                
                
            endif;
            
            return redirect()->back()->withInput();
	}
        /***/

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            
            $role = Role::findOrFail($id);
                        
            if($role->delete()):
                
                $perms = is_array(Request::get('permissions')) ? Request::get('permissions') :[];
                $role->permissions()->sync($perms);
                $role->users()->sync($perms);
                
            endif;
            
            return redirect(route(config('larbac.routes.routeRoles').'.index')); 
	}
        /***/

    

}
