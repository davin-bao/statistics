<?php
/**
 * Created by PhpStorm.
 * User: davin.bao
 * Date: 14-5-12
 * Time: PM 5:27
 */

namespace DavinBao\Statistics;


trait HasStatisticsController
{
  public function getResult($statistic){
    $title = $statistic->name;
    return \View::make(\Config::get('app.admin_template').'/statistics/result', compact('title','statistic'));
  }
  public function getExport($statistic){
    $title = $statistic->name;
    $type = \Input::get('type');
    $arrColumnName = $statistic->getColumnNameArray();
    $table = $statistic->getResult();
    switch($type){
      case 'csv':
        $output='';

        $output .=  implode(",",$arrColumnName)."\r\n";

        foreach ($table as $row) {
          $output .=  implode(",",$row)."\r\n";
        }
        $headers = array(
          'Content-Type' => 'text/csv',
          'Content-Disposition' => 'attachment; filename="'.$statistic->name.'_'.date('Y_m_d_His').'.csv"',
        );

        return \Response::make(rtrim($output, "\r\n"), 200, $headers);
      case 'excel':

        $output = '<table><thead><tr>';
        foreach($arrColumnName as $columnName){
          $output = $output.'<th>'.$columnName.'</th>';
        }
        $output = $output.'</tr></thead><tbody>';

        foreach($table as $result){
          $output = $output.'<tr>';
          foreach($result as $res){
            $output = $output.'<td>'.$res.'</td>';
          }
          $output = $output.'</tr>';
        }
        $output = $output.'<tfoot><tr><td colspan="'.count($arrColumnName).'">'.$statistic->name.'</td></tr></tfoot></table>';

        $headers = array(
          'Pragma' => 'public',
          'Expires' => 'public',
          'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
          'Cache-Control' => 'private',
          'Content-Type' => 'application/vnd.ms-excel',
          'Content-Disposition' => 'attachment; filename='.$statistic->name.'_'.date('Y_m_d_His').'.xls',
          'Content-Transfer-Encoding' => ' binary'
        );
        return \Response::make($output, 200, $headers);
    }

    return \View::make(\Config::get('app.admin_template').'/statistics/result', compact('title','statistic'));
  }
}