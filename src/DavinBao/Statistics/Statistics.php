<?php
/**
 * Created by PhpStorm.
 * User: davin.bao
 * Date: 14-5-12
 * Time: 上午11:34
 */
 namespace DavinBao\Statistics;

use Illuminate\Support\Facades\Facade;

class Statistics
{
  /**
   * Laravel application
   *
   * @var Illuminate\Foundation\Application
   */
  public $_app;

  /**
   * Create a new confide instance.
   *
   * @param  Illuminate\Foundation\Application  $app
   * @return void
   */
  public function __construct($app)
  {
    $this->_app = $app;
  }
  /**
   * Check whether the controller's action exists.
   * Returns the url if it does. Otherwise false.
   * @param $controllerAction
   * @return string
   */
  public function checkAction( $action, $parameters = array(), $absolute = true )
  {
    try {
      $url = $this->_app['url']->action($action, $parameters, $absolute);
    } catch( InvalidArgumentException $e ) {
      return false;
    }

    return $url;
  }
  /**
   * Display the default create flow view
   *
   * @deprecated
   * @return Illuminate\View\View
   */
  public function makeResultTable($statistic = null)
  {
    return $this->_app['view']->make( 'statistics::result_table', compact( 'statistic') );
  }
  /**
   * Display the default create flow view
   *
   * @deprecated
   * @return Illuminate\View\View
   */
  public function makeEditForm($entry = null)
  {
    return $this->_app['view']->make( 'statistics::create_edit_form', compact( 'entry') );
  }

}
