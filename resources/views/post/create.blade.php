@extends('dashboard_layouts/master')


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add New Post
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Post</a></li>
            <li class="active">Add New Post</li>
        </ol>
    </section>
    <div class="box-body">
        @if (session()->has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div><br />
        @endif
    </div>


<div>
    <!-- Main content -->
    <section class="content">
        <form role="form"   id="post_form" method="post" action="{{ route('blogs.store')}}"  enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-9">
                    <div class="box">
                        <!-- form start -->
                            <div class="box-body">
                                <div class="form-group {{$errors->has('post_tittle')? 'has-error':''}}"  >
                                    <label for="title">Title</label>
                                    <input type="text" placeholder="Enter Title here" id="post_tittle" name="post_tittle" class="form-control">
                                    @if($errors->has('post_tittle'))
                                    <span class="help-block">{{$errors->first('post_tittle')}}</span>
                                          @endif
                                </div>
                                <div class="form-group {{$errors->has('slug')? 'has-error':''}}"  >
                                    <label for="slug">Slug</label>
                                    <input type="text" id="slug"  name="slug"class="form-control">
                                    @if($errors->has('slug'))
                                        <span class="help-block">{{$errors->first('slug')}}</span>
                                    @endif
                                </div>
                                <div class="form-group ">
                                    <label for="body">Excerpt</label>
                                    <textarea name="excerpt" id="excerpt" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group {{$errors->has('slug')? 'has-error':''}}">
                                    <label for="body">Body</label>
                                    <textarea name="post_descripition" id="body"   rows="10" class="form-control"></textarea>
                                    @if($errors->has('post_descripition'))
                                        <span class="help-block">{{$errors->first('post_descripition')}}</span>
                                    @endif
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
                            <div class="form-group ">
                                <label for="published_at">Publish date</label>
                                <input type="text"  name="published_at" id='datetimepicker1' class="form-control" placeholder="Y-m-d  H:i:s">
                                    <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a id="draft-btn" class="btn btn-default" type="submit" >Save Draft</a>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Category </h3>
                        </div>
                        {{-- <div class="box-body">
                             <div>
                             <label for="">Categories</label>
                             <select class="form-control" name="category" id="category">
                                 <option value="">Select Category </option>
                                 @foreach($categories as $category)
                                 <option value="{{$category->id}}">{{$category->title}} </option>
                                 @endforeach
                             </select>

                             </div>

                       <div class="box-header with-border">
                             <h3 class="box-title">Category And Sub Category</h3>
                         </div>--}}
                         <div class="box-body">
                             <div class="radio {{$errors->has('category_id')? 'has-error':''}}">
                                 <label>
                                     @foreach($categories as $category)
                                         @if($category->categoryChildren->count() > 0)
                                             <li class="dropdown">
                                         <input type="radio" name="category_id" id="category-1"  value="{{$category->id}}"> {{$category->title}}
                                         <br />
                                                 <ul>
                                                     @foreach($category->categoryChildren as $subcategory)
                                                         <li><input type="radio" name="category_id" id="category-1" value="{{$subcategory->id}}">{{ $subcategory->title }}</li>
                                                     @endforeach
                                                 </ul>
                                             </li>
                                         @else
                                             <li class="dropdown">
                                             <input type="radio" name="category_id" id="category-1"  value="{{$category->id}}"> {{$category->title}}
                                                 <br />
                                             </li>
                                         @endif
                                     @endforeach
                                 </label>
                                 @if($errors->has('category_id'))
                                     <span class="help-block">{{$errors->first('category_id')}}</span>
                                 @endif

                             </div>

                         </div>
                    </div>
                        <br>
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
                            <input type="file" name="post_photo">
                            </span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>

        <!-- ./row -->
    </section>
</div>
    @endsection
@push('scripts')

        <script type="text/javascript">


            $( document ).ready(function() {
                $(' #post_tittle').on('blur',function () {
                    var theTitle =this.value.toLowerCase().trim();
                    //console.log('ssssss');
                    slugInput =$('#slug');

                    theSlug = theTitle.replace(/&/g, '-and-')
                        .replace(/[^a-z0-9-]+/g, '-')
                        .replace(/\-\-+/g, '-')
                        .replace(/^-+|-+$/g, '');
                          slugInput.val(theSlug);

                });

                $('#draft-btn').click(function (e) {
                    e.preventDefault();
                    $('#published_at').val("");
                    $('#post_form').submit();
                });

            });





        </script>
@endpush






