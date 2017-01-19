<?php namespace Arh\AuthToken;

use Illuminate\Support\ServiceProvider;

class AuthTokenServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this->package('arh/laravel-auth-token');
		$this->app['router']->filter('auth.token', 'arh.auth.token.filter');
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$app->bindShared('arh.auth.token', function ($app) {
			return new AuthTokenManager($app);
		});

		$app->bindShared('arh.auth.token.filter', function ($app) {
			$driver = $app['arh.auth.token']->driver();
      $events = $app['events'];

      return new AuthTokenFilter($driver, $events);
		});

		$app->bind('Arh\AuthToken\AuthTokenController', function ($app) {
			$driver = $app['arh.auth.token']->driver();
			$credsFormatter = $app['config']->get('laravel-auth-token::format_credentials', null);
			$events = $app['events'];

      return new AuthTokenController($driver, $credsFormatter, $events);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('arh.auth.token', 'arh.auth.token.filter');
	}

}
