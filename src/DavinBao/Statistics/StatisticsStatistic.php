<?php
/**
 * Created by PhpStorm.
 * User: davin.bao
 * Date: 14-5-12
 * Time: 上午11:36
 */

namespace DavinBao\Statistics;

use LaravelBook\Ardent\Ardent;
use Config;

class StatisticsStatistic extends Ardent
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'statistics';

  /**
   * Laravel application
   *
   * @var Illuminate\Foundation\Application
   */
  public static $app;

  /**
   * Ardent validation rules
   *
   * @var array
   */
  public static $rules = array(
    'name' => 'required|between:1,20',
    'sql' => 'required'
  );
  /**
   * Creates a new instance of the model
   */
  public function __construct(array $attributes = array())
  {
    parent::__construct($attributes);

    if ( ! static::$app )
      static::$app = app();
  }

  public function getResult(){
    $sql = $this->sql;
    return DB::select($sql);
  }

}