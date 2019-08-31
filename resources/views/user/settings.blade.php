@extends('dashboard_layouts.master')
@section('content')
    <section class="content-header">
        <h1>
            Setting
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">setting</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-9">
                <div class="box box-primary">
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Website Name</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Facebook Link</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Facebook Link">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Youtube Link</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Youtube">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Twitter Link</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Twitter">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Address</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mobile</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Mobile">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Stop Register
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Stop Comments
                                </label>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Website Logo</h3>
                    </div>
                    <div class="box-body text-center">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://placehold.it/200x200" width="100%" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
                            <input type="file" name="...">
                            </span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop