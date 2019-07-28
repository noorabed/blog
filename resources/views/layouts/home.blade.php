@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>You are logged in!</p>
    <div align="right">
        <a href="{{ route('blogs.create') }}" class="btn btn-warning">Create Post</a>
    </div>
@stop