{{ "\n\n" }}
Route::model('statistic', '\DavinBao\Statistics\StatisticsStatistic');
Route::pattern('statistic', '[0-9]+');
{{ "\n" }}
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

  # Statistics
  Route::get('statistics/{statistic}/edit', 'AdminStatisticsController@getEdit');
  Route::post('statistics/{statistic}/edit', 'AdminStatisticsController@postEdit');
  Route::delete('statistics/{statistic}/delete', 'AdminStatisticsController@postDelete');
  Route::get('statistics/{statistic}/result', 'AdminStatisticsController@getResult');
  Route::get('statistics/{statistic}/export', 'AdminStatisticsController@getExport');
  Route::controller('/statistics', 'AdminStatisticsController');

});
{{ "\n" }}