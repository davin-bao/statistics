{{ '<?php' }}

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class StatisticsSetupTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the flows table
        Schema::create('statistics', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('column_names');
            $table->integer('category_id')->unsigned();
            $table->text('sql');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('statistics');
    }

}
