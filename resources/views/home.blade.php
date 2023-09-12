@extends('layouts.default')
@section('title')
Dashboard
@endsection('title')
@section('content')
@section('css')
<style type="text/css">
    .col-md-3>p {
    line-height: 0.8 !important;
    width: auto;
    margin: 9px 0 0 10px;
    }
    .col-md-3{
        display: inline-flex;
        padding-left: 38px !important;
    }
    .nav-user img {
        width: auto !important;
    }
    .gradient-blue {
    background-image: linear-gradient(15deg,rgb(24 85 148) 0,#31b1ce 100%);
    }
</style>
@endsection('css')
<div class="row">
    <div class="col-xl-3">
        <div class="card-box widget-chart-one gradient-blue bx-shadow-lg">
            <div class="float-left" dir="ltr">
                <div style="display:inline;width:80px;height:80px;">
                    <p class="text-white mb-0 mt-2">Total Students</p>
                </div>
            </div>
            <div class="widget-chart-one-content text-right">
                
                <h3 class="text-white">{{$students}}</h3>
            </div>
        </div> <!-- end card-box-->
    </div> <!-- end col -->

     <div class="col-xl-3">
        <div class="card-box widget-chart-one gradient-blue bx-shadow-lg">
            <div class="float-left" dir="ltr">
                <div style="display:inline;width:80px;height:80px;">
                    <p class="text-white mb-0 mt-2">Total Courses</p>
                </div>
            </div>
            <div class="widget-chart-one-content text-right">
                
                <h3 class="text-white">{{$courses}}</h3>
            </div>
        </div> <!-- end card-box-->
    </div> <!-- end col -->

    <div class="col-xl-3">
        <div class="card-box widget-chart-one gradient-blue bx-shadow-lg">
            <div class="float-left" dir="ltr">
                <div style="display:inline;width:80px;height:80px;">
                    <p class="text-white mb-0 mt-2">Admin</p>
                </div>
            </div>
            <div class="widget-chart-one-content text-right">
                
            <h3 class="text-white">{{$admin}}</h3>
            </div>
        </div> <!-- end card-box-->
    </div> <!-- end col -->
</div>

@endsection('content')