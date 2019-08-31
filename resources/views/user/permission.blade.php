@extends('dashboard_layouts/master')
@section('content')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
           Permission
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">permission</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div align="right">
                            <a  name="add_permission" id="add_permission"  class="btn btn-success btn-sm">Add Permission</a>
                        </div>
                        <br />
                        <table class="table table-bordered" id="permission_table">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th> Permission Name</th>
                                <th>Permission For</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                        </table>



                    <!-- /.box-body -->


                        <div id="formModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add New Role</h4>
                                    </div>
                                    <div class="modal-body">
                                        <span id="form_result"></span>
                                        <form method="post" id="sample_form" class="form-horizontal" >
                                            @csrf
                                            <div class="form-group">
                                                <label class="control-label col-md-4" >Add Permissions : </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="name" id="name" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">For Permissions: </label>
                                                <div class="col-md-8">
                                                    <select name="for" id="for" class="form-control" >
                                                        <option selected disabled> Selecte Permission for</option>
                                                        <option value="post">post</option>
                                                        <option value="user">user</option>
                                                        <option value="category">category</option>
                                                        <option value="tag">tag</option>
                                                        <option value="setting">setting</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <br />
                                            <div class="form-group" align="center">
                                                <input type="hidden" name="action" id="action" />
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                                <input type="submit" name="action_button" id="action_button" class="btn btn-info" value="Add" />
                                            </div>
                                        </form>
                                    </div>
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
        <!-- ./row -->
    </section>
    <!-- /.content -->
    @push('scripts')
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @endpush
    <script>
        $(document).ready(function(){

            $('#permission_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('permissions.index') }}",
                },
                columns:[

                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'for',
                        name: 'for'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }

                ]
            })
            $('#add_permission').click(function(){
                $('.modal-title').text("Add New Permission");
                $('#action_button').val("Add");
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                if($('#action').val() == 'Add')
                {
                    $.ajax({
                        url:"{{ route('permissions.store') }}",
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
                                $('#formModal').modal('hide');
                                $('#permission_table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html);
                        }
                    })
                }
                if($('#action').val() == "Edit")
                {

                    //hidden_id
                    //

                    $.ajax({
                        url:"{{ route('permissions.update') }}",
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
                                $('#permission_table').DataTable().ajax.reload();
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
                    url:"permissions/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#name').val(html.data.name);
                        $('#for').val(html.data.for);
                        $('.modal-title').text("Edit Permissions Tittle");
                        $('#action_button').val("Edit");
                        $('#action').val("Edit");
                        $('#formModal').modal('show');
                        $('#hidden_id').val(id);

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
                    url:"permissions/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#permission_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });

        });

    </script>
@stop