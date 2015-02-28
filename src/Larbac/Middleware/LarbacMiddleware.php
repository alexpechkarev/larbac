<?php namespace Larbac\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
#use Larbac\Facade\LarbacFacade as Larbac;
use Illuminate\Support\Facades\URL;

class LarbacMiddleaware {

    	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;
        
        
        /**
         * Valid state
         * 
         * @var boolean 
         */
        protected $valid = false;
        

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
                
	}
        /***/
        
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
            
            /**
             * Get array of permissions to verify
             * Permission::getPermission()  -retrive array of permissions set in controller
             * $this->getVerify($request) - retrive array of permissions set in routes.php
             */
            $verify = is_array( $request->route()->parameters('larbac') ) 
                                ? $request->route()->parameters('larbac') 
                                : $this->getVerify($request);
            
            
            /**
             *  is user is authenticated
             */
            $this->valid = $this->auth->check();
            
            /**
             * User not authenticated 
             */
            if( empty($this->valid) ){
                
                return redirect()->to('auth/login')
                                 ->withErrors( ['message' => 'Only authenticated users allowed']);
            }
            
            
            /**
             * Is user has a role
             */
            if( isset( $verify['role'])){
                
                 $this->valid = $this->auth->user()->hasRole( $verify['role'] );

                 if(empty( $this->valid ) ){
                    return $this->getRidirect();
                 }
            }            
            
            /**
             *  can user perform following tasks
             */
            if( isset( $verify['permissions'])){      
                
                 $this->valid = $this->auth->user()->hasPermission( $verify['permissions'] );

                 if(empty( $this->valid ) ){
                    return $this->getRidirect();
                 }
            }
            
            
            
            
		return $next($request);
	}
        /***/
        
        /**
         * Riderect user if not valid
         */
        private function getRidirect(){
            
                
            /* 
             * Important
             * If user has been redirected from auth/login and have no access permission for requested action
             * user will be redirected back to auth/login, this will cause redirect loop
             * 
             *  Solution is to logout user
             * 
             */              
                                     
                if( ends_with( URL::previous(), 'auth/logout') ) {
                    
                    $this->auth->logout();
                    return redirect()->to('auth/login')->withErrors( ['message' => 'Invalid permissions']);
                }
                
                return redirect()->back()->withErrors( ['message' => 'Invalid permissions']);
                
                /***/
          
        }
        /***/
        
        /**
         * Get permissions array from Route parameters
         * 
         * Thanks to Elliot!
         * http://blog.elliothesp.co.uk/coding/passing-parameters-middleware-laravel-5/
         * 
         * @param type $request
         * @return type
         */
        private function getVerify($request){
            
            $actions = $request->route()->getAction();
 
            return $actions['verify'];
        }
        /***/

}
