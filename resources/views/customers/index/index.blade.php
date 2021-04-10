@extends('layouts.app')

@section('styles')

<link href="{{ asset('assets/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/datatables/buttons/css/buttons.dataTables.min.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        {{ __('built.All Customers') }}
                    </div>
                    <div class="card-toolbar">
                    <a href="{{route('customers.create')}}" class="btn btn-success"> {{ __('built.Add Customer') }} </a>
                    </div>
                </div>

                <div class="card-body">

                    <!--begin: Datatable-->
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-checkable" id="built_table" style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Created At</th>
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
@include('customers.index.index_scripts')

<!--begin::Datatables scripts-->
<script src="/assets/datatables/datatables.min.js"></script>
<script src="/assets/datatables/buttons/js/pdfmake.min.js"></script>
<script src="/assets/datatables/buttons/js/vfs_fonts.js"></script>
<script src="/assets/datatables/buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/datatables/buttons/js/buttons.print.min.js"></script>
<script src="/assets/datatables/buttons/js/buttons.html5.min.js"></script>
<!--end::Datatables scripts-->

<!--end::Page Scripts-->

@endsection