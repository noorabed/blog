@extends('dashboard_layouts/master')


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Edit Post
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Post</a></li>
            <li class="active"> Edit Post</li>
        </ol>
    </section>

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
            </div>
        @endif


            <!-- Main content -->
            <section class="content">
                <form role="form"  method="post"   id="post_form" action="{{ route('blogs.update', $data->id)}}"  enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xs-9">
                            <div class="box">
                                <!-- form start -->
                                <div class="box-body">
                                    <div class="form-group" >
                                        <label for="title">Title</label>
                                        <input type="text" placeholder="Enter Title here" id="post_tittle" name="post_tittle" class="form-control" value="{{$data->post_tittle}}">
                                        <span class="help-block"></span>

                                    </div>
                                    <div class="form-group"  >
                                        <label for="slug">Slug</label>
                                        <input type="text" id="slug"  name="slug"class="form-control" value="{{$data->slug}}">
                                        <p class="help-block">Example block-level help text here.</p>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="body">Excerpt</label>
                                        <textarea name="excerpt" id="excerpt" rows="5" class="form-control">{{$data->excerpt}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="body">Body</label>
                                        <textarea name="post_descripition" id="body"   rows="10" class="form-control">{{$data->post_descripition}}</textarea>
                                        <span class="help-block"></span>
                                    </div>


                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Publish</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="published_at">Publish date</label>
                                        <input type="text"  name="published_at" id='datetimepicker1' class="form-control" value="{{$data->published_at}}" >
                                    </div>
                                </div>
                                <div class="box-footer clearfix">
                                    <div class="pull-left">
                                        <a  id="draft-btn" class="btn btn-default">Save Draft</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-primary">Publish</a>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Category</h3>
                                </div>
                                <div class="box-body">
                                    <div class="radio">
                                        <label>
                                            @foreach($categories as $category)
                                                <input type="radio" name="category" id="category-1" value="option1">

                                                <option value="{{$category->id}}">{{$category->title}}</option>

                                            @endforeach
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Tags</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        {!! Form::text('post_tags', null, ['class' => 'form-control']) !!}

                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Feature Image</h3>
                                </div>
                                <div class="box-body text-center">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="http://placehold.it/200x200" width="100%" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                            <input type="file" name="post_photo" >
                            </span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- ./row -->
            </section>

@endsection
@push('scripts')

    <script type="text/javascript">

        $( document ).ready(function() {
            $(' #post_tittle').on('blur',function () {
                var theTitle =this.value.toLowerCase().trim();
                //console.log('ssssss');
                slugInput =$('#slug');

                slugInput.val( theTitle );
            });

            $('#draft-btn').click(function (e) {
                e.preventDefault();
                $('#published_at').val("");
                $('#post_form').submit();
            });
        });


    </script>
    @endpush


