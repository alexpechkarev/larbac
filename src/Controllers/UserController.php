<?php namespace Larbac\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Larbac\Models\Role;
use Larbac\Models\User;


/**
 * Description of UserController
 *
 * @author Alexander Pechkarev <alexpechkarev@gmail.com>
 */
class UserController extends Controller{
   


    
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
            $users = User::select('id', 'name')
                            ->with(array('roles'=>function($query){
                                    $query->select('name');
                                }))
                            ->get();
                    

            return view('larbac::users.view-user', compact("users"));
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
            
            $user = User::with('roles')->findOrFail($id);           
            $data = array(
                "id"            =>  $user->id,
                "name"          =>  $user->name,
                "availRoles"    =>  Role::select('id', 'name')->orderBy('name')->lists('name', 'id'),
                "assignedRoles" =>  (count($user->roles) > 0) ? $user->roles->lists('id') :0
            );
            return view('larbac::users.edit-user', $data);
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
            
            // find user
            $user = User::with('roles')->findOrFail($id);
            // get roles
            $roles = is_array(Request::get('roles')) ? Request::get('roles') : [];
            // asign roles
            $user->roles()->sync($roles);            
                
            return redirect(route('user.index'));                
                
	}
        /***/


    

}
