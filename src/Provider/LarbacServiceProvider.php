<?php namespace Larbac\Provider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


class LarbacServiceProvider extends ServiceProvider {
    
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
        

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
            $config = include_once __DIR__.'/../Config/larbac.php';
             
            
            // Using with frontend
            if( !empty($config['frontend']) ){
                
                $this->loadViewsFrom(__DIR__.'/../Assets/views/', 'larbac');                

                $this->publishes([
                     __DIR__.'/../Migration'        => base_path('database/migrations/'),
                     __DIR__.'/../Config'           => config_path('/'),
                    __DIR__.'/../Assets/js'         => public_path('vendor/larbac/js'),
                    __DIR__.'/../Assets/css'        => public_path('vendor/larbac/css')
                 ]);
            
                include __DIR__.'/../Routes/routes.php';  
                
            }else{
                // no frontend
                $this->publishes([
                 __DIR__.'/../Migration'        => base_path('database/migrations/'),
                 __DIR__.'/../Config'           => config_path('/')
             ], 'manual');                 
                
            }
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

            
	}
        /***/
        
        

        
        

}
