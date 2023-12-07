@extends('layouts.main')

@section('index-page')

<div class="col-md-12" style="height:70%; min-height:200px">

    <!-- Display error message if available in the session -->
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Display success message if available in the session -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <form method="post" action="{{url('/login-data')}}">
            @csrf
            <table class="table" style="width:150px; margin:80px auto">
                <tr>
                    <td></td>
                    <td style="color:#1C5978; font-weight:bold; text-align:center">Login</td>
                </tr>
                <tr>
                    <td class="login-table-text">Username</td>
                    <td><input type="text" class="login-table-input" name="username" required></td>
                </tr>
                <tr style="border:none">
                    <td class="login-table-text">Password</td>
                    <td><input type="password" class="login-table-input" style="font-size:30px;height:25px" name="password" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="btn btn-sm btn-primary" type="submit" style="margin-left:60px; padding:2px 15px" name="login" value="Submit"/></td>
                </tr>
            </table>
        </form>
    </div>
</div>

@endsection
