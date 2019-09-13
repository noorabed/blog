<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MyBlog | Add New Post</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('admin_layout/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin_layout/plugins/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin_layout/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('admin_layout/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_layout/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_layout/plugins/simple-mde/simplemde.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_layout/css/custom.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset('admin_layout/plugins/tag-editor/jquery.tag-editor.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @stack('style')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<body class="hold-transition skin-blue sidebar-mini">


{{-- Laravel Mix - JS File --}}
{{-- <script src="{{ mix('js/usermanagment.js') }}"></script> --}}
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="usermanagment" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>M</b>B</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>MY</b>BLOG</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a> -->

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('image/'.auth()->user()->user_photo)}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{auth()->user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{asset('image/'.auth()->user()->user_photo)}}" class="img-circle" alt="User Image">

                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>{{auth()->user()->name}}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="profile" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>"
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
@include('dashboard_layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    @yield('content')

    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.6
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{asset('admin_layout/js/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('admin_layout/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin_layout/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('admin_layout/plugins/simple-mde/simplemde.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin_layout/js/app.min.js')}}"></script>
<script src="{{asset('admin_layout/js/custom.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{asset('admin_layout/plugins/tag-editor/jquery.caret.min.js')}}"></script>
<script src="{{asset('admin_layout/plugins/tag-editor/jquery.tag-editor.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
    var options = {};
    {{--@if ($post->exists)--}}
    {{--options = {--}}
    {{--initialTags: {!! $post->tags_list !!}--}}
    {{--}--}}
    {{--@endif--}}
    $('input[name=post_tags]').tagEditor(options);
    $('ul.pagination').addClass('no-margin pagination-sm');
    $('#post_tittle').on('blur', function() {
        var theTitle = this.value.toLowerCase().trim(),
            slugInput = $('#slug'),
            theSlug = theTitle.replace(/&/g, '-and-')
                .replace(/[^a-z0-9-]+/g, '-')
                .replace(/\-\-+/g, '-')
                .replace(/^-+|-+$/g, '');
        slugInput.val(theSlug);
    });
    var simplemde1 = new SimpleMDE({ element: $("#excerpt")[0] });
    var simplemde2 = new SimpleMDE({ element: $("#body")[0] });
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        showClear: true
    });
    $('#draft-btn').click(function(e) {
        e.preventDefault();
        $('#published_at').val("");
        $('#post-form').submit();
    });
</script>
@stack('scripts')
</body>

</html>