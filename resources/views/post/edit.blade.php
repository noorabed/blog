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
            <h1>Edit Post</h1>
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

                <form method="post" action="{{ route('blogs.update', $blog->id) }} " enctype="multipart/form-data">
                    <div class="form-group">
                        @csrf
                        @method('PATCH')
                        <label for="name"> Post Title:</label>
                        <input type="text" class="form-control" name="post_tittle" value="{{$blog->post_tittle}}"/>
                    </div>
                    <div class="form-group">
                        <label for="price">Post Descripition :</label>
                        <input type="text" class="form-control" name="post_descripition" value="{{$blog->post_descripition}}"/>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Post Photo :</label>
                        <input type="file" class="form-control" name="post_photo" value="{{$blog->post_photo}}"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>

        </div>
    </div>
@endsection