@extends('layouts.app')

@section("title")
{{config("app.name")}} | All Invoices
@stop

@section('styles')

<link href="{{ asset('assets/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/datatables/buttons/css/buttons.dataTables.min.css') }}" rel="stylesheet">
<link href="/assets/select2/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        {{ __('built.All Invoices') }}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('invoices.create')}}" class="btn btn-success"> {{ __('built.Create Invoice') }} </a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="" for="customers"><b>Customer</b></label>
                            <select multiple class="form-control" id="customers" name="customers">
                                <option value=""></option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3 d-flex flex-column">
                            <label class="" for="start_date"><b>From:</b></label>
                            <input class="form-control" type="date" id="start_date" name="start_date" />
                        </div>

                        <div class="form-group col-md-3 d-flex flex-column">
                            <label class="" for="end_date"><b>To:</b></label>
                            <input class="form-control" type="date" id="end_date" name="end_date" />
                        </div>

                        <div class="form-group col-md-2">
                            <button type="submit" id="submitFilters" class="btn btn-primary ">Search</button>
                        </div>
                    </div>

                    <!--begin: Datatable-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-checkable" id="built_table" style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Total Amount(GHS)</th>
                                    <th>Invoice Date</th>
                                    <th>Customer</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end: Datatable-->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')

<!--begin::Page Scripts(used by this page)-->
@include('invoices.index.index_scripts')

<!--begin::Datatables scripts-->
<script src="/assets/datatables/datatables.min.js"></script>
<script src="/assets/datatables/buttons/js/pdfmake.min.js"></script>
<script src="/assets/datatables/buttons/js/vfs_fonts.js"></script>
<script src="/assets/datatables/buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/datatables/buttons/js/buttons.print.min.js"></script>
<script src="/assets/datatables/buttons/js/buttons.html5.min.js"></script>
<!--end::Datatables scripts-->

<!-- begin:select2 scripts -->

<!-- end:select2 scripts -->
<script src="/assets/select2/js/select2.min.js"></script>
<!--end::Page Scripts-->

@endsection