@extends('admin_beauty.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop
@section('content_header')
{{{ Lang::get('admin/menu.roles') }}}
<small>
  {{{ Lang::get('admin/roles/title.management') }}}
</small>
@stop
{{-- breadcrumb --}}
@section('breadcrumb')
<li><a href="#"><i class="fa fa-dashboard"></i> {{{ Lang::get('admin/menu.home') }}}</a></li>
<li class="active">{{{ Lang::get('admin/menu.roles') }}}</li>
@stop
{{-- Content --}}
@section('content')
{{ Statistics::makeResultTable($statistic) }}
@stop
