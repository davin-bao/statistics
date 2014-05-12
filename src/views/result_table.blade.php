
{{-- Scripts --}}
@section('styles')
.chart-column {
  float: left;
  width: 16.666666666666664%;
}
#chart {
  float: left;
  margin-bottom: 50px;
}
.chart-bar {
  margin-left: -100px;
}
@stop


<div class="box box-primary">
  <div class="box-header" style="cursor: move;">
    <i class="ion ion-clipboard"></i>

    <h3 class="box-title">{{ $statistic->name }}</h3>

    <div class="box-tools pull-right">
      {{ $statistic->links(); }}
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <select class="form-control chart-column">
      @foreach($statistic->getChartColumn() as $key=>$isShowChart)
      @if($isShowChart)
      <option value="{{ $key }}">
        {{{ $statistic->getColumnNameArray()[$key] }}}
      </option>
      @endif
      @endforeach
    </select>
    <canvas id="chart" width="640"></canvas>
    <div class="col-xs-2 chart-bar">
      <a class="btn btn-circle btn-success"><i class="ion ion-arrow-graph-up-right"></i></a>
      <a class="btn btn-circle btn-warning"><i class="ion ion-stats-bars"></i></a>
    </div>

    <ul class="todo-list ui-sortable">
      <table class="table table-hover">
        <tbody><tr>
          @foreach($statistic->getColumnNameArray() as $colName)
          <th class="col-md-2">{{{ $colName }}}</th>
          @endforeach
        </tr>
        @foreach ($statistic->getResultPaginate() as $result)
        <tr>
          @foreach($result as $res)
          <th class="col-md-2">{{ $res }}</th>
          @endforeach
        </tr>
        @endforeach
        </tbody>
      </table>
    </ul>
  </div>
  <!-- /.box-body -->
  <div class="box-footer clearfix border">
    <a href="{{ URL::to('admin/statistics/' . $statistic->id . '/export?type=excel') }}" class="btn btn-default pull-right" style="margin-left: 10px;"><i class="fa fa-table"></i> {{{ Lang::get('statistics::button.export_excel') }}}</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{ URL::to('admin/statistics/' . $statistic->id . '/export?type=csv') }}" class="btn btn-default pull-right"><i class="ion ion-social-vimeo-outline"></i> {{{ Lang::get('statistics::button.export_csv') }}}</a>
  </div>
</div>

{{-- Scripts --}}
@section('scripts')
<script src="{{asset('packages/davin-bao/statistics/assets/js/Chart.js') }}" type="text/javascript"></script>

<script type="text/javascript">
  //Get context with jQuery - using jQuery's .get() method.
  var ctx = $("#chart").get(0).getContext("2d");
  //This will get the first returned node in the jQuery collection.
  var myNewChart = new Chart(ctx);
  var chartType = 'Line';
  var labels = {{ json_encode($statistic->getColumnData(0)) }};

  var arrChartData = [];
  @foreach($statistic->getChartColumn() as $key=>$isShowChart)
  arrChartData[{{ $key }}] = {{ json_encode($statistic->getColumnData($key)) }};
  @endforeach

  var chartData = {{ json_encode($statistic->getColumnData(1)) }};

  new Chart(ctx).Line(getData());

  $('i.ion-arrow-graph-up-right').parent().click(function(){
    var chartType = 'Line';
    new Chart(ctx).Line(getData());
  });

  $('i.ion-stats-bars').parent().click(function(){
    var chartType = 'Bar';
    new Chart(ctx).Bar(getData());
  });

  $('select.chart-column').change(function(){
    chartData = arrChartData[parseInt($(this).val())];
    switch(chartType){
      case 'Line':
        new Chart(ctx).Line(getData());
        break;
      default:
        new Chart(ctx).Bar(getData());
        break;
    }
  });


  function getData(){
    return {
      labels : labels,
      datasets : [
        {
          fillColor : "rgba(220,220,220,0.5)",
          strokeColor : "rgba(220,220,220,1)",
          pointColor : "rgba(220,220,220,1)",
          pointStrokeColor : "#fff",
          data : chartData
        }]
    };
  };

</script>
@stop