@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@stop

@section('content')
    <h1>Edit User</h1>
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

            <form method="post" action="{{ route('users.update', $user->id) }} " enctype="multipart/form-data">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                        <label for="name">User Name :</label>
                        <input type="text" class="form-control" name="name" value="{{$user->name}}"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="text" class="form-control" name="email" value="{{$user->email}}"/>
                    </div>

                    <div class="form-group">
                        <label for="email">Password :</label>
                        <input type="password" class="form-control" name="password" value="{{$user->password}}"/>
                    </div>
                <div class="form-group">
                       <label for="Photo">User Photo :</label>
                       <input type="file" class="form-control" name="user_photo" value="{{$user->password}}"/>
                </div>
                <button type="submit" class="btn btn-warning">Update User</button>
            </form>

        </div>
    </div>
@endsection