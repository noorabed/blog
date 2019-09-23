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
            Comment
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">comment</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">

                    </div>
                        <br />
                    <form method="post" id="comment_form">

                        <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button>
                    </form>
                        <br>
                        <table class="table table-bordered" id="comment_table">
                            <thead>
                            <tr>
                            <tr>
                                <th style="width: 10px"><input name="select_all" value="1" id="example-select-all"  class="selected" type="checkbox" /></th>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    <!-- /.box-body -->
                        <br />
                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
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
         var table=$('#comment_table').DataTable({
                processing: true,
                serverSide: true,

                ajax:{
                    url: "{{ route('comments.index') }}",
                },
                columns:[
                    {
                        'targets': 0,
                        'className': 'select-checkbox',
                        'searchable':false,
                        'orderable':false,
                        'render': function (data, type, full, meta) {
                            return '<input type="checkbox"  class="selected" name="id[]" value="'
                                + $('<div/>').text(data).html() + '">';
                        },

                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'user_email',
                        name: 'user_email'
                    },
                    {
                        data: 'comment',
                        name: 'comment'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }

                ],
             "createdRow": function(row, data, dataIndex){
                 $(row).attr("id", "tblRow_" + data[0]);
             }

            })

            var user_id;

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"comments/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#comment_table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });

            //select
        $('#example-select-all').on('click', function(){
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
                $('input[type="checkbox"]', rows).addClass('selected');
            });

            $('#comment_table').on('change', 'input[type="checkbox"]', function(){
                if(!this.checked){
                    var el = $('#example-select-all').get(0);
                    if(el && el.checked && ('indeterminate' in el)){
                        el.indeterminate = true;
                    }
                }
            });

            $(document).on('click', '#bulk_delete', function(){
                var id = [];
                if(confirm("Are you sure you want to Delete this data?"))
                {
                    $('.selected:checked').each(function(){
                        id.push($(this).val());
                    });
                    if(id.length > 0)
                    {
                        $.ajax({
                            url:"{{ url('/remove')}}",
                            method:"get",
                            data:{id:id},
                            success:function(data)
                            {
                                alert(data);
                                $('#comment_table').DataTable().ajax.reload();
                            }
                        });
                    }
                    else
                    {
                        alert("Please select atleast one checkbox");
                    }
                }
            });
        });


    </script>
@stop