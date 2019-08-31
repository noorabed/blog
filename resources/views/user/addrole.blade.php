@extends('dashboard_layouts/master')


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add NewRole
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Role</a></li>
            <li class="active">Add New Role</li>
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
            @endif
    </div>


    <div>
        <!-- Main content -->
        <section class="content">
            <form role="form"   id="role_form" method="post" action="{{ route('roles.store')}}" >
                @csrf
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group }}"  >
                                    <label for="title">Role</label>
                                    <input type="text" placeholder="Enter Title here" id="name" name="name" class="form-control">
                                    <span class="help-block"></span>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <tbody><tr>
                                        <th>Menu</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>Show</th>
                                        <th>All</th>
                                    </tr>
                                    <tr>
                                        <td>Posts</td>
                                        @foreach($permissions as $permission )
                                                @if($permission->for =='post')
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red" name="permission[]"  value="{{$permission->id}}">
                                                        {{$permission->name}}
                                                    </label>
                                                @endif
                                                </td>
                                        @endforeach
                                    </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="box-footer">
                                <a  href="{{ route('roles.index')}}" class="btn btn-default" type="submit">Cancel</a>
                                <button  class="btn btn-success pull-right" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- ./row -->
        </section>
    </div>
@endsection







