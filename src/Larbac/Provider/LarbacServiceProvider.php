<?php namespace Larbac\Provider;

use Illuminate\Support\ServiceProvider;


class LarbacServiceProvider extends ServiceProvider {
    
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;
        

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
            $this->publishes([
                 __DIR__.'/../Migration' => base_path('database/migrations/'),
             ]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
            $this->app->bind('Larbac\Contracts\LarbacInterface', 'Larbac\Larbac');
            
            $this->app->bindShared('Larbac', function($app)
            {
                    return new \Larbac\Larbac;
            });
                
            
            $this->app->alias('Larbac', 'Larbac\Larbac');
            
	}
        /***/
        
        
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('larbac');
	}
        /***/
        
        

}
