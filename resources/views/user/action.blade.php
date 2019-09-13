@extends('dashboard_layouts/master')
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

@section('content')
    <section class="content-header">
        <h1>
            Action
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">action</li>
        </ol>
    </section>
    <br>
    <br />
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="post_table">
                            <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">UserID</th>
                                <th width="20%">Browser</th>
                                <th width="20%">Methods</th>
                                <th width="20%">Login</th>
                                <th width="20%">Action</th>


                            </tr>
                            </thead>
                        </table>
                    </div>
                    <br />
                    <br />
                </div>
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
    </section>
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/ckeditor/ckeditor.js"></script>
    <script>
        $(document).ready(function(){

            $('#post_table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('logs.index') }}",
                },
                columns:[
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'browser',
                        name: 'browser'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'login',
                        name: 'login'
                    },

                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false
                    }

                ]
            });

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function(){
                $.ajax({
                    url:"logs/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },

                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#post_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });


        });




    </script>

@stop
