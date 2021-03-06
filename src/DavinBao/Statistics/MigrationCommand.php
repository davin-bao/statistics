<?php namespace DavinBao\Statistics;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrationCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'statistics:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Statistics especifications.';

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
        $this->info( "Tables: statistics" );
        $message = "An migration that creates 'statistics'".
            " tables will be created in app/database/migrations directory ";

        $this->comment( $message );
        $this->line('');

        if ( $this->confirm("Proceed with the migration creation? [Yes|no]") )
        {
            $this->line('');

            $this->info( "Creating migration..." );
            if( $this->createMigration() )
            {
                $this->info( "Migration successfully created!" );
            }
            else{
                $this->error(
                    "Coudn't create migration.\n Check the write permissions".
                    " within the app/database/migrations directory."
                );
            }

            $this->line('');

        }
    }
    /**
     * Create the migration
     *
     * @param  string $name
     * @return bool
     */
    protected function createMigration()
    {
      $migration_file = $this->laravel->path."/database/migrations/".date('Y_m_d_His')."_statistics_setup_tables.php";
      $app = app();
      $statistics_type = '';
      if(is_array($app['config']->get('statistics_type'))){
        $statistics_type = implode(",", app()['config']->get('statistics::statistics_type'));
      }

      $output = $app['view']->make('statistics::generators.migration')->with('statistics_type',$statistics_type)->render();

      if( ! file_exists( $migration_file ) )
      {
        $fs = fopen($migration_file, 'x');
        if ( $fs )
        {
          fwrite($fs, $output);
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