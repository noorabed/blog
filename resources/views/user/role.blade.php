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
            Role
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">role</li>
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
                            <a   href="{{route('roles.create')}}"name="add_role" id="add_role"  class="btn btn-success btn-sm">Add Role</a>
                        </div>
                        <br />
                        <table class="table table-bordered" id="role_table">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                        </table>
                      {{--  <table class="table table-bordered" id="role_table">
                            <tbody><tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    <small>Users have this role: </small>
                                    <span class="badge bg-red"> {{$role->count()}}</span>
                                </td>
                                <td>

                                    <a    href="{{route('editrole')}}"  class="btn btn-default">
                                      <i class="fa fa-edit"></i> Edit
                                    </a>

                                    <button type="button" name="delete" id="'.$role->id.'" class="delete btn btn-danger btn-sm">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </button>

                                </td>
                            </tr>
                                @endforeach


                            </tbody></table>--}}



                    <!-- /.box-body -->


                                        <br />
                                        <div class="form-group" align="center">
                                            <input type="hidden" name="action" id="action" />
                                            <input type="hidden" name="hidden_id" id="hidden_id" />
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

            $('#role_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('roles.index') }}",
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
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }

                ]
            })

            var user_id;

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"roles/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#role_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });

        });

</script>
@stop