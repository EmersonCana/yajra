@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4 offset-lg-4 col-sm-12">
            <div class="card bg-dark text-light">
                <div class="card-body mt-0 text-center">
                    <img src="{{asset('asset/images/logo.png')}}" height="200px" width="auto">
                    <br>
                    <label for="employee_id">Employee ID:</label>
                    <input type="number" class="form-control" name="employee_id">
                    <button type="submit" class="btn btn-lg btn-primary">Time In</button><br>
                    IP Address:<br>{{Request::ip()}}<br>
                    Browser:<br>{{$_SERVER['HTTP_USER_AGENT']}}
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
