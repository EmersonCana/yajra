@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4 offset-lg-4 col-sm-12">
            <div class="card bg-dark text-light">
                <div class="card-body mt-0 text-center">
                    <img src="{{asset('asset/images/logo.png')}}" height="200px" width="auto">
                    <br>
                    @if (\Session::has('success'))
                        <div class="alert alert-success" id="success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="alert alert-danger" id="error">
                            <ul>
                                <li>{!! \Session::get('error') !!}</li>
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{route('timeInOut')}}">
                    @csrf
                    <input type="hidden" name="mac" value="{{$macaddress}}">
                    <input type="hidden" name="ip" value="{{Request::ip()}}">
                    <input type="hidden" name="agent" value="{{$_SERVER['HTTP_USER_AGENT']}}">
                    <label for="employee_id">ID Number:</label>
                    <input type="text" class="form-control" name="employee_id">
                    <div class="row">
                        <div class="col-6">
                            <label for="long">Longitude:</label>
                            <input type="number" class="form-control" name="long">
                        </div>
                        <div class="col-6">
                            <label for="long">Latitude:</label>
                            <input type="number" class="form-control" name="lat">
                        </div>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-lg btn-primary">Time In</button><br>
                    </form>
                    <table class="table bg-white">
                        <tr>
                            <td>Mac Address:</td>
                            <td>{{$macaddress}}</td>
                        </tr>
                        <tr>
                            <td>IP Address:</td>
                            <td>{{Request::ip()}}</td>
                        </tr>
                        <tr>
                            <td>Browser:</td>
                            <td>{{$_SERVER['HTTP_USER_AGENT']}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
