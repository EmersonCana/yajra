<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yajra</title>
    <link rel="stylesheet" type="text/css" href="{{asset('asset/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/style.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 welcome mt-0 text-center">
                <a href="#" class="p-0 mt-0"><img src="{{asset('asset/images/logo.png')}}" height="200px" width="auto"></a>
            </div>  
        </div>
        <div class="row">
            <div class="col-12 p-0 m-0">
                @include('includes.navbar')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-sm-12">
            
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card shadow">
                    <div class="card-header text-light bg-dark">
                        Login your Yajra Account
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="email" name="email" maxlength="30" placeholder="Username" class="form-control">
                        <br>
                        <input type="password" name="password" maxlength="50" placeholder="Password" class="form-control">
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('register')}}" class="btn btn-success">Register</a>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('asset/js/jquery.js')}}"></script>
    <script src="{{asset('asset/bootstrap/js/bootstrap.js')}}"></script>
</body>
</html>