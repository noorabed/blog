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
            Post
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">post</li>
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
                            <br>
                            <div>
                                <div class="form-group col-md-3">
                                    <input type="text" name="post_tittle" id="post_tittle" class="form-control" placeholder="Search for Title" />
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" name="created_at" id="created_at" class="form-control" placeholder="Search for Date" />
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" name="published_at" id="published_at" class="form-control" placeholder="Search for Post State"  />
                                </div>
                                <input type="hidden" id="search_function_fire" value="0">
                                <div class="form-group col-md-3">
                                <button  name="filter" id="filter" class="btn btn-success btn-sm">search</button>
                                </div>

                            </div>
                        </div>
                        <div align="right">
                            {{--<button type="button" name="create_post" id="create_post" class="btn btn-success btn-sm">Create Post</button>--}}
                            @can('blogs.create',Auth::user())
                                <a href="{{route('blogs.create')}}" class="btn btn-success btn-sm">Create Post</a>
                            @endcan
                        </div>
                        <br>
                        <br>

    <div class="table-responsive">
        <table class="table table-bordered" id="post_table">
            <thead>
            <tr>
                <th width="10%">Image</th>
                <th width="20%">PostTittle</th>
                <th width="35%">PostDescripition</th>
                <th width="20%">Date</th>
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
                "bFilter": false,
                ajax:{
                    url: "{{ route('blogs.index') }}",
                    "data": function ( d ) {
                        d.search_function_fire=$('#search_function_fire').val();
                        d.post_tittle=$('#post_tittle').val();
                        d.created_at=$('#created_at').val();
                        d.published_at = $('#published_at').val();
                    }
                },
                columns:[
                    {
                        data: 'post_photo',
                        name: 'post_photo',
                        render: function(data, type, full, meta){
                            return "<img src={{ URL::to('/') }}/image/" + data + " width='70' class='img-thumbnail' />";
                        },
                        orderable: false
                    },
                    {
                        data: 'post_tittle',
                        name: 'post_tittle'
                    },
                    {
                        data: 'post_descripition',
                        name: 'post_descripition'
                    },
                    {
                        data: 'published_at',
                        name: 'published_at',
                        render : function (data,full ) {
                           // return moment(data).format('DD-MMM-YYYY');
                            return getStatus(data);
                        },
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }

                ]
            });
            $('#filter').on('click', function(e) {
             $('#search_function_fire').val(1);
             $('#post_table').DataTable().ajax.reload();

            });

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"blogs/destroy/"+user_id,
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


            function getStatus(published_at){

                if(published_at){

                    return '<span  class="label label-Success "> published</span>';

                }
                else{
                    return '<span  class="label label-info">Draft</span>';


                }

            }




        });




    </script>

@stop
