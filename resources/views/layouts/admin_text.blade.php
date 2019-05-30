<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blood Academy</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/sb-admin.css') }}" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="{{ asset('assets/css/plugins/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/jquery-countryselector.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/jquery-te-1.4.0.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countryselector.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-te-1.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js?ver=1.0.0') }}"></script>
    @yield('head')
</head>
<body>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('admin.home') }}">Blood Academy</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->username}} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <!-- <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                    </li> -->
                    <!-- <li class="divider"></li> -->
                    <li>
                        <a href="{{ url('logout') }}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>

            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="active">
                    <a href="{{ route('admin.home') }}"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('admin.members', ['type' => 'all']) }}">Members List</a>
                </li>
                <li>
                    <a href="{{ route('admin.add-test') }}">Add Test</a>
                </li>
                <li>
                    <a href="{{ route('admin.pages') }}">Pages</a>
                </li>
                <li>
                    <a href="{{ route('admin.info') }}">Add Information</a>
                </li>
                <li>
                    <a href="{{ route('admin.pay-history') }}">Payment History</a>
                </li>
                <li>
                    <a href="{{ route('admin.figurehub') }}">Figures Hub</a>
                </li>
                <li>
                    <a href="{{ route('admin.slidehub') }}">Slides Hub</a>
                </li>
                <li>
                    <a href="{{ route('admin.managecases') }}">Manage Cases</a>
                </li>
                <li>
                    <a href="{{ route('admin.managesampletype') }}">Manage Sample Types</a>
                </li>
                <li>
                    <a href="{{ route('admin.guidelines') }}">Guidelines summaries</a>
                </li>
                <li>
                    <a href="{{ route('admin.dbfix') }}">DB fixes</a>
                </li>
                <li>
                    <a href="{{ route('admin.view-comments') }}">View comments</a>
                </li>
                <li>
                    <a href="{{ route('admin.manageslides') }}">Manage Slides</a>
                </li>
                <li>
                    <a href="{{ route('admin.icase') }}">Interactive Cases</a>
                </li>
                <li>
                    <a href="{{ route('admin.blog') }}">Bolgs</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dashboard <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Bootstrap Core JavaScript -->


</body>
</html>
