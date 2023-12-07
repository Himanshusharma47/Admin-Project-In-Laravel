<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Project</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
</head>

<body>
    <header class="col-md-12">
        <div class="container">
            <div class="col-md-3">
                <img src="{{ asset('assets/images/logo.png') }}" style="margin:15px 0px 5px 0px; float:left">
            </div>
            <div class="col-md-2 col-md-offset-6">

                <!-- Display logout btn if the current route is not the 'login' route -->
                @if (!request()->routeIs('login'))
                    <a class = "logoutbtn" href = "{{ url('logout') }}">
                        Logout
                    </a>
                @endif

            </div>
        </div>
    </header>
    <div class="col-md-12" style="background:#1C5978">
        <div class="container">
            <div class="col-md-3">
                <p
                    style="color:white; font-weight:bold; font-family:arial; font-size:12px; margin:7px 0px; float:left; letter-spacing:1; word-spacing:3">
                    {{\Carbon\Carbon::now()->format('l, jS F Y')}}</p>
            </div>
        </div>
    </div>
