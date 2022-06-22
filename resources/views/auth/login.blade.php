<!DOCTYPE html>
<html lang="en">

<head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js" integrity="sha512-ePSfiGQMIzYzXVQLqWoVC3yxVEHIM5Y3EGh9jPNxpf+hPuLtzPdxJX+lTC3ziPMlDgc5OsM4JThxGwN2DkWEeA==" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/demo/favicon.html">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Finance Login - {{config('app.name')}}</title>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600%7CRoboto:400" rel="stylesheet" type="text/css">
    <link href="/assets/vendors/material-icons/material-icons.css" rel="stylesheet" type="text/css">
    <link href="/assets/vendors/mono-social-icons/monosocialiconsfont.css" rel="stylesheet" type="text/css">
    <link href="/assets/vendors/feather-icons/feather.css" rel="stylesheet" type="text/css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.7.0/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- Head Libs -->
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/modernizr@3.11.3/lib/cli.min.js" integrity="sha384-wH60OyVNn7qkHQh33+U6qOLpwV8va1CVFU4UGk9ywNTU1RMqJdY3SFWy902usThx" crossorigin="anonymous"></script>
</head>

<body class="body-bg-full profile-page">
<div id="wrapper" class="wrapper">
    <div class="row container-min-full-height">
        <div class="col-lg-4 login-right d-lg-flex d-none pos-fixed pos-right text-inverse container-min-full-height" style="background-color: #a8005b;">
            <div style="background-image: url(assets/img/bg.png);top: 0px;position: absolute">
                <img src="assets/img/bg.png">
            </div>
            <div class="login-content px-3 w-75 text-center mt-5">
                <h2 style="font-size: 50px;" class=" mt-5py-4 text-center fw-300">{{ config('app.name') }}</h2>
            </div>
            <!-- /.login-content -->
        </div>
        <div class="col-lg-8 p-3 login-left">
            <div class="w-50">
                <h2 class="mb-4 text-center">Finance Login!</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Error!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="text-muted" for="example-email">Registered Email </label>
                        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-muted" for="example-password">Password</label>
                        <input id="password" autocomplete="off" type="password" placeholder="********" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                   
                    <div class="form-group mr-b-20">
                        <button type="submit" class="btn btn-block btn-rounded btn-md btn-primary text-uppercase fw-600 ripple" type="button">Sign In</button>
                    </div>
                </form>
                <!-- /form -->
            </div>
            <!-- /.w-75 -->
        </div>

        <!-- /.login-right -->
    </div>
    <!-- /.row -->
</div>
<!-- /.wrapper -->
<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="assets/js/material-design.js"></script>
</body>


</html>
