@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        {{ __('built.Create Customer') }}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('customers.index')}}" class="btn btn-primary"> {{ __('built.All Customers') }} </a>
                    </div>

                </div>

                <div class="card-body">
                    <customers-create></customers-create>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection