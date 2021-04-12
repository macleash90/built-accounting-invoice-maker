@extends('layouts.app')

@section("title")
{{config("app.name")}} | All Users
@stop

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
                        {{ __('built.All Users') }}
                    </div>
                    <div class="card-toolbar">
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="" for="status"><b>Status</b></label>
                            <select class="form-control" id="status" name="status">
                                <option></option>
                                <option value="1">Active</option>
                                <option value="2">InActive</option>
                            </select>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
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
@include('users.index.index_scripts')

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