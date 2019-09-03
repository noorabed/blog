@extends('dashboard_layouts/master')
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

@section('content')
   {{-- <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div align="right">
        <a href="{{ route('category.create') }}" class="btn btn-warning">Add Category</a>
    </div>
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
            <table class="table table-striped">
                <thead>
                <tr>
                    <td width="10%">ID</td>
                    <td width="45%">categorie Title</td>
                    <td width="30%">Action</td>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $categorie)
                    <tr>
                        <td>{{$categorie->id}}</td>
                        <td>{{$categorie->title}}</td>
                        <td><a href="{{ route('categories.edit',$categorie->id)}}" class="btn btn-primary">Edit</a></td>
                    <td>
                    <form action="{{ route('categories.destroy', $categorie->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                    </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                <div class="text-center">
                    {!!$categories->links(); !!}
                </div>
                <div>--}}


   <br>
   <div align="right">
       @can('blogs.category',Auth::user())
       <button type="button" name="create_category" id="create_category" class="btn btn-success btn-sm">Create Category</button>
       @endcan
   </div>
   <br />
   <div class="table-responsive">
       <table class="table table-bordered table-striped" id="category_table">
           <thead>
           <tr>
               <td width="10%">ID</td>
               <td width="30%">Tittle</td>
               <td width="30%">Slug</td>
               <td width="30%">Action</td>
           </tr>
           </thead>
       </table>
   </div>
   <br />
   <br />
   </div>

   <div id="formModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Add Title</h4>
               </div>
               <div class="modal-body">
                   <span id="form_result"></span>
                   <form method="post" id="sample_form" class="form-horizontal" >
                       @csrf
                       <div class="form-group">
                           <label class="control-label col-md-4">Tittle : </label>
                           <div class="col-md-8">
                               <input type="text" name="title" id="title" class="form-control" />
                           </div>
                       </div>
                       <div class="form-group">
                           <label class="control-label col-md-4">Slug : </label>
                           <div class="col-md-8">
                               <input type="text" name="slug" id="slug" class="form-control" />
                           </div>
                       </div>

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
   <script>

       $(document).ready(function(){

           $('#category_table').DataTable({
               processing: true,
               serverSide: true,
               ajax:{
                   url: "{{ route('categories.index') }}",
               },
               columns:[
                   {
                       data: 'id',
                       name: 'id'
                   },

                   {
                       data: 'title',
                       name: 'title'
                   },
                   {
                       data: 'slug',
                       name: 'slug'
                   },
                   {
                       data: 'action',
                       name: 'action',
                       orderable: false
                   }
               ]
           });

           $('#create_category').click(function(){
               $('.modal-title').text("Add Tittle");
               $('#action_button').val("Add");
               $('#action').val("Add");
               $('#formModal').modal('show');
               $('#hidden_id').val(html.data.id);
           });

           $('#sample_form').on('submit', function(event){
               event.preventDefault();

               if($('#action').val() == 'Add')
               {
                   $.ajax({
                       url:"{{ route('categories.store') }}",
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
                               $('#category_table').DataTable().ajax.reload();
                               $('#formModal').modal('hide');
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
                       url:"{{ route('categories.update') }}",
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
                               $('#category_table').DataTable().ajax.reload();
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
                   url:"categories/"+id+"/edit",
                   dataType:"json",
                   success:function(html){
                       $('#title').val(html.data.title);
                       $('.modal-title').text("Edit Tittle");
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
                   url:"categories/destroy/"+user_id,
                   beforeSend:function(){
                       $('#ok_button').text('Deleting...');
                   },
                   success:function(data)
                   {
                       setTimeout(function(){
                           $('#confirmModal').modal('hide');
                           $('#category_table').DataTable().ajax.reload();
                       }, 2000);
                   }
               })
           });

       });
   </script>

@endsection
