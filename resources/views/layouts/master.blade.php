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

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets/css/jquery-ui.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{asset('assets/js/html5shiv.js')}}"></script>
    <script src="{{asset('assets/js/respond.min.js')}}"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>

    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{asset('assets/js/custom.js')}}"></script>


</head>

<body>
<div class="container">
    @yield('content')
</div>
</body>
</html>