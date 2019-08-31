@extends('dashboard_layouts/master')

@section('content')
    <p>You are logged in!</p>
    <div align="right">
        <a href="{{ route('blogs.create') }}" class="btn btn-warning">Create Post</a>
    </div>
@stop