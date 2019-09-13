
@extends('dashboard_layouts/master')
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

@push('style')
    <style>

    </style>
@endpush
@section('content')
    <section class="content-header">
        <h1>
            User
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">user</li>
        </ol>
    </section>
    <br>

    <br />
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div align="right">

                        {{--  <a href="{{ route('users.create') }}" class="btn btn-primary">ADD User</a>--}}
                        @can('users.create',Auth::user())
                        <button type="button" name="add_user" id="add_user" class="btn btn-success btn-sm">Add User</button>
                        @endcan
                    </div>
                    <br />
        <table class="table table-bordered" id="user_table">
            <thead>
            <tr>
                <th width="10%">User photo</th>
                <th width="20%">Name</th>
                <th width="20%">Email</th>
                <th width="10%">State</th>
                <th width="10%">User Role</th>
                <th width="30%">Action</th>
            </tr>
            </thead>
        </table>
    {{--  <tbody>
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
    </tbody>--}}
    <br />
    <br />
    </div>

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New User</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-4" >User Name : </label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Email : </label>
                            <div class="col-md-8">
                                <input type="text" name="email" id="email" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Password : </label>
                            <div class="col-md-8">
                                <input type="password" name="password" id="password"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">State : </label>
                            <div class="col-md-8">
                                <input checked="checked" name="state" type="checkbox" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Role :</label>
                            <div class="col-md-8">
                            <select  class="form-control" name="role_id" id="role_id">
                               @foreach($roles as $role)
                                <option  name="role" value="{{$role->id}}"> {{$role->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Select User Image : </label>
                            <div class="col-md-8">
                                <input type="file" name="user_photo" id="user_photo" />
                                <span id="store_image"></span>
                            </div>
                        </div>
                        <br />
                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Confirmation</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
            </div>
        </div>

    </div>
    @push('scripts')
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @endpush
    <script>
        $(document).ready(function(){

            $('#user_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('view') }}",
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
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'state',
                        name: 'state'
                    },
                    {
                        data: 'role_id',
                        name: 'role_id',
                        render : function (data,full ) {

                            return getRoles(data)
                        },
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ]

            });
            $('#add_user').click(function(){
                $('.modal-title').text("Add New User");
                $('#action_button').val("Add");
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                if($('#action').val() == 'Add')
                {
                    $.ajax({
                        url:"{{ route('users.store') }}",
                        method:"POST",
                        data: new FormData(this),
                        contentType: false,
                        cache:false,
                        processData: false,
                        dataType:"json",
                        success:function(data)
                        {
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">';
                                for(var count = 0; count < data.errors.length; count++)
                                {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if(data.success)
                            {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('#user_table').DataTable().ajax.reload();
                                $('#formModal').modal('hide');
                            }
                            $('#form_result').html(html);
                        }
                    })
                }

                if($('#action').val() == "Edit")
                {
                    $.ajax({
                        url:"{{ route('users.update') }}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType:"json",
                        success:function(data)
                        {
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">';
                                for(var count = 0; count < data.errors.length; count++)
                                {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if(data.success)
                            {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('#store_image').html('');
                                $('#user_table').DataTable().ajax.reload();
                                $('#formModal').modal('hide');
                            }
                            $('#form_result').html(html);
                        }
                    });
                }
            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                //console.log(id);
                $('#form_result').html('');
                $.ajax({
                    url:"users/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#name').val(html.data.name);
                        $('#email').val(html.data.email);
                        $('#role_id').val(html.data.role_id);
                        $('#store_image').html("<img src={{ URL::to('/') }}/image/" + html.data.user_photo + " width='70' class='img-thumbnail' />");
                        $('#store_image').append("<input type='hidden' name='hidden_image' value='"+html.data.user_photo+"' />");
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Edit New Post");
                        $('#action_button').val("Edit");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                    }
                })
            });
            var user_id;

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"users/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#user_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });
            function getRoles(role_id ){
                if(role_id == 1){

                    return '<span  class="label label-danger "> Admin</span>';

                }

                else if(role_id == 2){

                    return '<span  class="label label-warning "> Author</span>';

                }
              else if (role_id ==3){
                    return '<span  class="label label-info"> Editor</span>';
                }

            else{
                    return '<span  class="label label-success"> Writer</span>';

                }
            }

        });

        function static(e) {
            id = $(e).data('id');
            var action = 'changestate';
            $('#message').html('');
            swal({
                title: "Are you sure?",
                text: "Once Changed, you will be able to change it by repeat checked the button!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url:"changestate/"+id,
                            method:'GET',
                            success:function(data)
                            {
                                swal("Poof! Your State has been changed!", {
                                    icon: "success",
                                });
                                setTimeout(function(){
                                    $('#user_table').DataTable().ajax.reload();
                                });
                            }
                        });

                    } else {
                        swal("No any Change with your State!");
                    }
                });
            // if(confirm("Are you Sure you want to change state of this User?"))
            // {
            //     $.ajax({
            //         url:"changestate/"+id,
            //         method:'GET',
            //         //data:{id:id, state:state},
            //         success:function(data)
            //         {
            //             console.log(data.success)
            //             setTimeout(function(){
            //                 $('#user_table').DataTable().ajax.reload();
            //                 $('#message').html(data);
            //             });
            //         }
            //     });
            // }
           // console.log('hello !');
        }
    </script>
@stop