@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@stop

@section('content')
    <h1>Edit Category</h1>
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

            <form method="post" action="{{ route('categories.update', $category->id) }} ">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="name">Tittle :</label>
                    <input type="text" class="form-control" name="title" value="{{$category ->title}}"/>
                </div>

                <button type="submit" class="btn btn-warning">Update Category</button>
            </form>

        </div>
    </div>
@endsection