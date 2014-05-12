<?php namespace DavinBao\Statistics;

use Illuminate\Support\ServiceProvider;

class StatisticsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('davin-bao/statistics');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
    $this->registerStatistics();
    $this->registerCommands();
	}


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}


  /**
   * Register the application bindings.
   *
   * @return void
   */
  private function registerStatistics()
  {
    $this->app->bind('statistics', function($app)
    {
      return new Statistics($app);
    });
  }

  public function registerCommands()
  {

    $this->app['command.workflow.migration'] = $this->app->share(function($app)
    {
      return new MigrationCommand($app);
    });

//    $this->app['command.workflow.routes'] = $this->app->share(function($app)
//    {
//      return new RoutesCommand($app);
//    });
//
//    $this->app['command.workflow.models'] = $this->app->share(function($app)
//    {
//      return new ModelsCommand($app);
//    });
//
//    $this->app['command.workflow.controllers'] = $this->app->share(function($app)
//    {
//      return new ControllersCommand($app);
//    });

    $this->commands(
      'command.workflow.migration'
//      'command.workflow.routes',
//      'command.workflow.models',
//      'command.workflow.controllers'
    );
  }
}
