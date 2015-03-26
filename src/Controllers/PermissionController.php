<?php namespace Larbac\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Larbac\Models\Permission;


/**
 * Description of UserController
 *
 * @author Alexander Pechkarev <alexpechkarev@gmail.com>
 */

class PermissionController extends Controller {


    /**
     * Class constructor
     */
    public function __construct() {        
        
      // Setting role based access
      $permissions = ['role'=>[config('larbac.role')]  ];


      if( is_object(Request::route()) ) {

          Request::route()->setParameter('larbac', $permissions);
          $this->middleware('larbac');  
      }         
    }
    /***/


    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $perms = Permission::all();

            return view('larbac::permissions.view-permission', compact("perms"));
	}
        /***/

	/**
	 * Show the form for creating a new permission.
	 *
	 * @return Response
	 */
	public function create()
	{                
            
           
            return view('larbac::permissions.create-permission');
	}
        /***/

	/**
	 * Store a newly created resource in storage.
         * Validation error are in start/global.php
	 *
	 * @return Response
	 */
	public function store()
	{
            
            $permission                 = new Permission;
            $permission->name           = Request::get('name');
            $permission->description    = Request::get('description');
            $permission->save(); 

            return redirect(route(config('larbac.routes.routePermission').'.index'));

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
            
            $perm = Permission::findOrFail($id);
            $data = array(
                "id"            =>  $perm->id,
                "name"          =>  $perm->name,
                "description"   =>  $perm->description
            );
            return view('larbac::permissions.edit-permission', $data);
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
            
            $p = Permission::findOrFail($id);
            
            if( $p->update(Request::all()) ):
                
                return redirect(route(config('larbac.routes.routePermission').'.index'));                
                    
            endif;
            
            return Redirect::back()->withInput();
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
            
            $p = Permission::findOrFail($id);   
            $p->delete();
            return redirect(route(config('larbac.routes.routePermission').'.index')); 
	}
        /***/


        
        
}
