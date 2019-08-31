@extends('dashboard_layouts/master')

@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">

                    <div class="box-body box-profile"  >
                        <img class="profile-user-img img-responsive img-circle" src="{{asset('image/'.auth()->user()->user_photo)}}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">

                        <li><a href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>

                        <div class="tab-pane" id="settings">
                            <form class="form-horizontal"enctype="multipart/form-data" action="{{ route('user.update', $user->id) }}"method="POST" >
                               @csrf

                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">UserName</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" disabled class="form-control"  placeholder="Email" value="{{$user->email}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"  placeholder="Enter your new password" name="password" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-2 control-label">Update your photo</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="user_photo" value="{{$user->user_photo}}"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Update your data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->




@stop