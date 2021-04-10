@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                <div class="card-title">
                {{ __('built.Edit Item') }}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('items.index')}}" class="btn btn-primary"> {{ __('built.All Items') }} </a>
                    </div>
                    </div>

                <div class="card-body">
                    <items-edit :id="'{{$id}}'"></items-edit>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
