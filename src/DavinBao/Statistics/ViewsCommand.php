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

class ViewsCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'statistics:views';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Append the default Statistics controller and views';

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
    $this->info( "Views file: admin/statistics/create_edit.blade.php,admin/statistics/index.blade.php,admin/statistics/result.blade.php, Controller file: admin/controller/AdminStatisticsController.php" );

    $message = "A single views, This a base be used with a statistics.";


    $this->comment( $message );
    $this->line('');

    $soure_file = __DIR__."/../../views/generators/create_edit.blade.php";
    if(file_exists( $soure_file )) $this->line("true");

    if ( $this->confirm("Proceed with the append? [Yes|no]") )
    {
      $this->line('');

      $this->info( "Appending views..." );

      $views = array(
        'create_edit','index','result'
      );
      $result = true;
      foreach($views as $view){
        $result = $result && $this->appendView($view);
      }
      if( $result )
      {
        $this->info( "create_edit,index,result Patched successfully!" );

        $this->line('');
        $this->info( "Appending controller..." );
        $result = $this->appendController();

        if( $result ){
          $this->info( "AdminStatisticsController Patched successfully!" );
        }
      }

      if(!$result){
        $this->error(
          "Coudn't append content, \nCheck the".
          " write permissions within the file."
        );
      }

      $this->line('');

    }
  }


  /**
   * Create the views
   *
   * @param  string $name
   * @return bool
   */
  protected function appendView( $name = '' )
  {
    $app = app();
    $data_dir = $this->laravel->path.'/views/admin/statistics';
    $datas_file = $this->laravel->path."/views/admin/statistics/$name.blade.php";
    $soure_file = __DIR__."/../../views/generators/create_edit.blade.php";

    $this->info( $datas_file );

    if (!file_exists($data_dir)) {
      mkdir($data_dir, 0777, true);
    }

    if( file_exists( $soure_file ) && !file_exists( $datas_file ) )
    {
      try{
        copy($soure_file, $datas_file);
        return true;
      }catch(\Exception $e) {
        return false;
      }
    }
    else
    {
      return false;
    }
  }
  /**
   * Create the controller
   *
   * @param  string $name
   * @return bool
   */
  protected function appendController()
  {
    $app = app();
    $data_dir = $this->laravel->path.'/controllers/admin';
    $datas_file = $this->laravel->path."/controllers/admin/AdminStatisticsController.php";
    $this->info( $datas_file );
    $statistics_datas = $app['view']->make('statistics::generators.AdminStatisticsController')->render();

    if (!file_exists($data_dir)) {
      mkdir($data_dir, 0777, true);
    }

    if( !file_exists( $datas_file ) )
    {
      $fs = fopen($datas_file, 'x');
      if ( $fs )
      {
        fwrite($fs, $statistics_datas);
        $this->line($statistics_datas);
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