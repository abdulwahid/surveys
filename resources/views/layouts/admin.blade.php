<html>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Surveys</title>

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{asset('assets/js/html5shiv.js')}}"></script>
    <script src="{{asset('assets/js/respond.min.js')}}"></script>
    <![endif]-->

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.ui.touch-punch.min.js')}}"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/js/admin.js')}}"></script>

</head>

<body>

<div id="wrapper">

    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('admin-surveys-taken') }}">Surveys Admin Panel</a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="{{ route('admin-logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{ route('admin-surveys-taken') }}"><i class="fa fa-list-ul"></i> Surveys Taken</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-survey-types-list') }}"><i class="fa fa-list-ul"></i> Survey Types</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-surveys-list') }}"><i class="fa fa-list-ul"></i> Surveys</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-coupons-list') }}"><i class="fa fa-list-ul"></i> Coupons</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-categories-list') }}"><i class="fa fa-list-ul"></i> Categories</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-companies-list') }}"><i class="fa fa-list-ul"></i> Companies</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-departments-list') }}"><i class="fa fa-list-ul"></i> Departments</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-roles-list') }}"><i class="fa fa-list-ul"></i> Roles</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-traits-list') }}"><i class="fa fa-list-ul"></i> Traits</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-questions-list') }}"><i class="fa fa-list-ul"></i> Question</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        @if (session('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul>
                    {{ session('message') }}
                </ul>
            </div>
        @endif
        @yield('content')
    </div>
    {{ csrf_field() }}
</div>

</body>
</html>