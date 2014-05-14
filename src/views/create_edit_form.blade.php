<form method="post" id="main-form" action="@if (isset($entry)){{ URL::to('admin/statistics/' . $entry->id . '/edit') }}@endif" autocomplete="off">
  <div class="box-body">
    <!-- Tabs -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab-general" data-toggle="tab">{{{ Lang::get('statistics::statistics.general') }}} </a></li>
    </ul>
    <!-- ./ tabs -->


    <!-- Tabs Content -->
    <div class="tab-content">
      <!-- General tab -->
      <div class="tab-pane active" id="tab-general">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <!-- ./ csrf token -->
        <br/>
        <!-- name -->
        <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
          <label class="span2 control-label" for="name">{{{ Lang::get('statistics::statistics.name') }}}</label>
          <div class="span6">
            <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($entry) ? $entry->name : null) }}}" />
            {{ $errors->first('name', '<label class="control-label" for="name"><i class="fa fa-times-circle-o"></i> :message</label>') }}
          </div>
        </div>
        <!-- ./ name -->
        <!-- column_names -->
        <div class="form-group {{{ $errors->has('column_names') ? 'has-error' : '' }}}">
          <label class="span2 control-label" for="column_names">{{{ Lang::get('statistics::statistics.column_names') }}}</label>
          <div class="span6">
            <input class="form-control" type="text" name="column_names" id="column_names" value="{{{ Input::old('column_names', isset($entry) ? $entry->column_names : null) }}}" />
            {{ $errors->first('column_names', '<label class="control-label" for="column_names"><i class="fa fa-times-circle-o"></i> :message</label>') }}
          </div>
        </div>
        <!-- ./ column_names -->
        <!-- category_id -->
        <div class="form-group {{{ $errors->has('category_id') ? 'has-error' : '' }}}">
          <label class="span2 control-label" for="category_id">{{{ Lang::get('statistics::statistics.category_id') }}}</label>
          <div class="span6">
            <input class="form-control" type="text" name="category_id" id="category_id" value="{{{ Input::old('category_id', isset($entry) ? $entry->category_id : null) }}}" />
            {{ $errors->first('category_id', '<label class="control-label" for="category_id"><i class="fa fa-times-circle-o"></i> :message</label>') }}
          </div>
        </div>
        <!-- ./ category_id -->

        <!-- sql -->
        <div class="form-group {{{ $errors->has('sql') ? 'has-error' : '' }}}">
          <label class="span2 control-label" for="sql">SQL</label>
          <div class="span6">
            <textarea class="form-control" cols="80" id="sql" name="sql" rows="10">
              {{{ Input::old('sql', isset($entry) ? $entry->sql : null) }}}
            </textarea>
            {{ $errors->first('sql', '<label class="control-label" for="sql"><i class="fa fa-times-circle-o"></i> :message</label>') }}
          </div>
        </div>
        <!-- ./ sql -->



      </div>
      <!-- ./ general tab -->

    </div>
    <!-- ./ tabs content -->

    <!-- Form Actions -->
    <div class="form-group">
      <div class="span6 offset2">
        <a type="reset" class="btn btn-default" href="{{{ URL::to('admin/statistics') }}}">{{{ Lang::get('statistics::button.return') }}}</a>
        <button type="submit" class="btn btn-success" style="margin-left: 20px">{{{ Lang::get('statistics::button.submit') }}}</button>
      </div>
    </div>
    <!-- ./ form actions -->
  </div>
</form>
