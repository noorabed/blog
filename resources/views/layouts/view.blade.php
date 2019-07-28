@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
@stop

@section('content')

    <div align="right">
        <a href="{{ route('users.create') }}" class="btn btn-primary">ADD User</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="user_table">
            <thead>
            <tr>
                <th width="10%">ID</th>
                <th width="10%">User photo</th>
                <th width="25%">Name</th>
                <th width="25%">Email</th>
                <th width="25%">State</th>
                <th width="30%">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th>{{$user->id}}</th>
                    <th><img src="{{ URL::to('/') }}/image/{{$user->user_photo}}" class="img-thumbnail" width="75" /></th>
                    <th>{{$user->name}}</th>
                    <th>{{$user->email}}</th>
                    <th>{{$user->state}}</th>
                    <th> <a href="{{ route('users.changestate',$user->id)}}" class="btn btn-default">change state</a></th></th>
                    <th> <th><a href="{{ route('users.edit',$user->id)}}" class="btn btn-warning">Edit</a></th></th>
                    <th>
                        <form action="{{ route('users.destroy', $user->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-center">
            {!!$users->links(); !!}
        </div>
    </div>
    <br />
    <br />


                <script>
                    $(document).ready(function(){

                        $('#post_table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax:{
                                url: "{{ route('users.index') }}",
                            },
                            columns:[
                                {
                                    data: 'user_photo',
                                    name: 'user_photo',
                                    render: function(data, type, full, meta){
                                        return "<img src={{ URL::to('/') }}/image/" + data + " width='70' class='img-thumbnail' />";
                                    },
                                    orderable: false
                                },
                                {
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false
                                }
                            ]
                        })
                </script>
@stop