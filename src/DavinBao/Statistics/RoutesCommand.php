<?php
/**
 * Created by PhpStorm.
 * User: davin.bao
 * Date: 14-5-5
 * Time: 下午6:08
 */

namespace DavinBao\Statistics;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RoutesCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'statistics:routes';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Append the default Statistics controller routes to the routes.php';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
    $app = app();
    $app['view']->addNamespace('statistics',substr(__DIR__,0,-8).'views');
  }


  /**
   * Execute the console command.
   *
   * @return void
   */
  public function fire()
  {
    $this->line('');
    $this->info( "Routes file: app/routes.php" );

    $message = "A single route to handle every action in a RESTful controller".
        " will be appended to your routes.php file. This may be used with a statistics".
        " controller generated using [-r|--restful] option.";


    $this->comment( $message );
    $this->line('');

    if ( $this->confirm("Proceed with the append? [Yes|no]") )
    {
      $this->line('');

      $this->info( "Appending routes..." );
      if( $this->appendRoutes() )
      {
        $this->info( "app/routes.php Patched successfully!" );
      }
      else{
        $this->error(
          "Coudn't append content to app/routes.php\nCheck the".
          " write permissions within the file."
        );
      }

      $this->line('');

    }
  }

  /**
   * Create the controller
   *
   * @param  string $name
   * @return bool
   */
  protected function appendRoutes()
  {
    $app = app();
    $routes_file = $this->laravel->path.'/routes.php';
    $routes = $app['view']->make('statistics::generators.routes')->render();

    if( file_exists( $routes_file ) )
    {
      $fs = fopen($routes_file, 'a');
      if ( $fs )
      {
        fwrite($fs, $routes);
        $this->line($routes);
        fclose($fs);
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }


}