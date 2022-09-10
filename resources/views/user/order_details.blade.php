@extends('layouts.inner')

@section('navigation')
@if( \Auth::user()->root == 1)
@include('inner.root_nav', ['active' => [0,0,'active', 0,0,0,0,0,0]])
@else
@include('inner.nav', ['active' => ['active', 0,0,0,0,0,0]])
@endif
@endsection


@section('content')

<style>
    .tab-pane {
        padding: 20px;
    }
</style>

@if( \Auth::user()->admin == 1 )
@include('user.order.admin_details')
@endif






@if( \Auth::user()->root == 1 )
@include('user.order.root_details')
@endif

@endsection