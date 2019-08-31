@extends('dashboard_layouts/master')

@section('title', 'AdminLTE')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Comments
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">role</li>
        </ol>
    </section>
    <br>
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
            <div class="alert alert-danger">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div><br />

    </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">

                        <br />
                        <table class="table table-bordered">

                            <tr>
                                <th style="width: 10px">ID</th>
                                <th >UserName</th>
                                <th>UserEmail</th>
                                <th>PostTitle</th>
                                <th>Comments</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <tbody>
                                @foreach($comments as $comment)
                                <td>{{$comment->id}}</td>
                                <td>{{$comment->user_name}}</td>
                                <td>{{$comment->user_email}}</td>
                                <td>{{@ $comment->blogs->post_tittle}}</td>
                                <td>
                                    <small>{{$string_limit= str_limit($comment->comment,50)}} </small>

                                </td>
                                <td>

                                    <form action="{{route('comments.dertroy',$comment->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i>  Delete</button>

                                    </form>
                                </td>
                            </tr>

                            @endforeach
                            </tbody></table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {!!$comments->links(); !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- ./row -->
    </section>
    <!-- /.content -->

@stop