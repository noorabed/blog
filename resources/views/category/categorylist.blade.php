@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div align="right">
        <a href="{{ route('category.create') }}" class="btn btn-warning">Add Category</a>
    </div>
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
            <table class="table table-striped">
                <thead>
                <tr>
                    <td width="10%">ID</td>
                    <td width="45%">categorie Title</td>
                    <td width="30%">Action</td>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $categorie)
                    <tr>
                        <td>{{$categorie->id}}</td>
                        <td>{{$categorie->title}}</td>
                        <td><a href="{{ route('categories.edit',$categorie->id)}}" class="btn btn-primary">Edit</a></td>
                    <td>
                    <form action="{{ route('categories.destroy', $categorie->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                    </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                <div class="text-center">
                    {!!$categories->links(); !!}
                </div>
                <div>
@endsection
