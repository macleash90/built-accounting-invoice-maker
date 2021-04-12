@extends('layouts.app')

@section("title")
{{config("app.name")}} | Create Invoice
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        {{ __('built.Create Invoice') }}
                    </div>
                    <div class="card-toolbar">
                    <a href="{{route('invoices.index')}}" class="btn btn-primary"> {{ __('built.All Invoices') }} </a>
                    </div>
                </div>

                <div class="card-body">
                    <invoice-create></invoice-create>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
