@extends('dashboard_layouts/master')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    var analytics =<?php echo $title;?>

    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(drawChart);

    function drawChart()
    {
        var data = google.visualization.arrayToDataTable(analytics);
        var options = {
            title : 'Percentage of Blog Category'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    var tag =<?php echo $name;?>

    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(drawChart);

    function drawChart()
    {
        var data = google.visualization.arrayToDataTable(tag);
        var options = {
            title : 'Percentage of Blog Tag'
        };
        var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
        chart.draw(data, options);
    }
</script>
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-8">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$blogs->count()}}</h3>

                        <p>Total Post</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="{{route('blogs.index')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-xs-8">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$user->count()}}</h3>

                        <p> Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('view')}}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-8">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$all_view}}</h3>

                        <p>Total views</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>


        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-8">

                <!-- /.box -->
                <div class="row">

                    <!-- /.col -->

                    <div class="col-md-12">
                        <!-- USERS LIST -->
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Latest Members</h3>

                                <div class="box-tools pull-right">
                                    <span class="label label-danger">{{$user->count()}} Members</span>
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding" >
                                <ul class="users-list clearfix">
                                  @foreach($active_user as $user)
                                    <li>
                                        <form  method="post" enctype="multipart/form-data">
                                        <img src="{{ URL::to('/') }}/image/{{$user->user_photo}}"  width="80px" alt="User Image">
                                        <a class="users-list-name" href="#">{{$user->name}}</a>
                                        <span class="users-list-date">{{$user->created_at->diffForHumans()}}</span>
                                        </form>
                                    </li>
                                    @endforeach

                                </ul>
                                <!-- /.users-list -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <a href="{{route('view')}}" class="uppercase">View All Users</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!--/.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Most Popular Post</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th> Post ID</th>
                                    <th>Post Tittle</th>
                                    <th>Post Descripition</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($popular_post as $post)
                                <tr>
                                    <td>{{$post->id}}</td>
                                    <td>{{str_limit($post->post_tittle,'20')}}</td>
                                    <td>{{str_limit($post->post_descripition,'20')}}</td>
                                    <td>{{$post->created_at->diffForHumans()}} </td>
                                </tr>
                                 @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="{{route('blogs.create')}}" class="btn btn-sm btn-info btn-flat pull-left">Place New Post</a>
                        <a href="{{route('blogs.index')}}" class="btn btn-sm btn-default btn-flat pull-right">View All Post</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->

            <div class="col-md-4">

                <!-- /.info-box -->

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Browser Usage</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="150"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="fa fa-circle-o text-red"></i> {{$vistor->browser}}</li>

                                </ul>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">
                        <ul class="nav nav-pills nav-stacked">

                            <li><a href="#">{{$vistor->country}}
                                    <span class="pull-right text-red"><i class="fa fa-angle-down"></i> {{$vistor->count()}}</span></a></li>

                        </ul>
                    </div>
                    <!-- /.footer -->
                </div>
                <!-- /.box -->

                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Category Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                        <div  class="box-body"id="piechart" style="width: 350px;  height: 280px;"></div>

                    <!-- /.box-body -->
                </div>


                <!-- /.box -->
                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tag Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div  class="box-body"id="pie_chart" style="width: 350px;  height: 280px;"></div>

                    <!-- /.box-body -->
                </div>

            </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@push('scripts')
    <!-- ChartJS -->

    @endpush

@stop