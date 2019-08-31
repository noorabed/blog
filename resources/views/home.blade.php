@extends('dashboard_layouts/master')

@section('content')
    <p>Welcome {{ Auth::user()->name }},you  are logged in!</p>

@stop