@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <h1>Users Profile</h1>
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session('success') }}</li>
                    </ul>
                </div><br />
            @endif
                <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    <div class="form-group">
                        @csrf
                        <label for="name">User Name :</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="text" class="form-control" name="email"/>
                    </div>

                    <div class="form-group">
                        <label for="password">Password :</label>
                        <input type="password" class="form-control" name="password"/>
                    </div>
                    <div class="form-group">
                        <input checked="checked" name="state" type="checkbox"/>
                        <label for="checkbox">State:</label>
                    </div>
                        <div>
                    <label for="Photo">User Photo :</label>
                    <input type="file" class="form-control" name="user_photo"/>
                      </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Add User </button>
                    </div>
                </form>
        </div>
    </div>
@stop


