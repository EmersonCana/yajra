@extends('layouts.app')

@section('content')
    <div class="sidebar" data-color="orange">
        @include('includes.sidebar')
    </div>
    <div class="main-panel" id="main-panel">
        @include('includes.main-navbar')
        <div class="panel-header panel-header-sm">
            
        </div>
        <div class="content">
            @include('includes.contents.payroll')
        </div>
    </div>
@endsection
