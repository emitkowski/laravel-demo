<!DOCTYPE html>
<html>

<head>
    <title>404 error | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/404.css')}}" rel="stylesheet">

</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
            <div class="text-center">
                <div>
                    <div class="error_img">
                        <img src="{{asset('img/404.gif')}}" alt="404 error image">
                    </div>
                    <hr class="seperator">
                    <a href="{{url('/')}}" class="btn btn-primary link-home">Go Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>

