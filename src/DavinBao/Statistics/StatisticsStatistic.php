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

  protected $results = array();

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

  public function getColumnNameArray(){
    return explode('|', $this->column_names);
  }

  public function getResult(){
    if(count($this->results)>0) return $this->results;
    $sql = $this->sql;
    $this->results = $this->convertArray(\DB::select($sql));
    return $this->results;
  }
  public function getResultPaginate(){
    if(count($this->results)<= 0){
      $this->getResult();
    }
    $currentPage = \Paginator::getCurrentPage();
    return array_slice($this->results, ($currentPage-1) * static::$app['config']->get('statistics::paginate_num'), static::$app['config']->get('statistics::paginate_num'));
  }
  public function links(){
    if(count($this->results)<= 0){
      $this->getResult();
    }
    return \Paginator::make($this->results, count($this->results), static::$app['config']->get('statistics::paginate_num'))->links();
  }


  public function convertArray($results){
    $res = array();
    foreach($results as $result){
      array_push($res, get_object_vars($result));
    }
    return $res;
  }

  public function getChartColumn(){
    $arrChratCol = array();
    $results = $this->getResult();
    if(is_array($results) && count($results)>0){
      $result = $results[0];
    }
    if(is_array($result)){
      $i =0;
      foreach($result as $res){
        if(is_double($res) || is_float($res) || is_int($res)) {
          $arrChratCol[$i] = true;
        }else{
          $arrChratCol[$i] = false;
        }
        $i++;
      }
    }
    $arrChratCol[0] = false;
    return $arrChratCol;
  }

  public function getColumnData($colIndex = 0){
    $arrCol = array();
    $results = $this->getResult();
    foreach ($results as $result) {
      if(is_array($result) && count($result)>$colIndex){
        $i =0;
        foreach($result as $res) {
          if($i == $colIndex) {
            array_push($arrCol, $res);
          }
          $i++;
        }
      }
    }
    return $arrCol;
  }

}