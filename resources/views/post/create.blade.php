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
    <div class="card uper">
        <div class="card-header">
            Add Post
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
                <div class="form-group">
                <li>
                    <a class="nav-link" href="{{ route('category.create') }}">
                        Create Category
                    </a>
                </li>
                </div>
            <form method="post" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
                <div class="form-group">
                    @csrf
                    <label for="name">Post Title:</label>
                    <input type="text" class="form-control" name="post_tittle"/>
                </div>
                <div class="form-group">
                    <label for="Descripition">Post Descripition :</label>
                    <input type="text" class="form-control" name="post_descripition"/>
                </div>
                <div class="form-group">
                    <label for="Category">Category Classifications :</label>
                    <select name="category" id="">
                        @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="Photo">Post Photo :</label>
                    <input type="file" class="form-control" name="post_photo"/>
                </div>
                <button type="submit" class="btn btn-primary">Add post </button>
            </form>
        </div>
    </div>
@stop


