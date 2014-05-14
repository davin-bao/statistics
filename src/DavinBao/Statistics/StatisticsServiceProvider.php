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

    $this->app['command.statistics.migration'] = $this->app->share(function($app)
    {
      return new MigrationCommand($app);
    });

    $this->app['command.statistics.routes'] = $this->app->share(function($app)
    {
      return new RoutesCommand($app);
    });

    $this->app['command.statistics.views'] = $this->app->share(function($app)
    {
      return new ViewsCommand($app);
    });

    $this->commands(
      'command.statistics.migration',
      'command.statistics.views',
      'command.statistics.routes'
    );
  }
}
