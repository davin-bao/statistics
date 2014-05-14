@extends('admin_beauty.layouts.default')

@section('content_header')
{{{ $title }}}
<small>
  {{{ $title }}}
</small>
@stop
{{-- breadcrumb --}}
@section('breadcrumb')
<li><a href="#"><i class="fa fa-dashboard"></i> {{{ Lang::get('admin/menu.home') }}}</a></li>
<li class="active">{{{ Lang::get('statistics::statistics.statistics') }}}</li>
<li class="active">{{{ Lang::get('admin/general.edit') }}}</li>
@stop

{{-- Content --}}
@section('content')
<div class="box box-primary">

  {{-- Create Form --}}
  {{ Statistics::makeEditForm(isset($entry)?$entry:null) }}
</div>
@stop