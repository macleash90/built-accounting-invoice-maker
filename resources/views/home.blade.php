@extends('layouts.app')

@section("title")
{{config("app.name")}} | Home
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">

        <div class="col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$total_invoices ?? 0}}</h3>

                    <p>Total Invoices:</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{route('invoices.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$total_users->total_users ?? 0}}</h3>

                    <p>Total Users :</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('users.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
            </div>

        </div>

        <div class="col-md-3">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$total_users->active_users ?? 0}}</h3>

                    <p>Active Users:</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('users.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>


        <div class="col-md-3">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$total_users->disabled_users ?? 0}}</h3>

                    <p>Disabled Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
</div>
@endsection