@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        {{ __('built.View Item') }}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('items.index')}}" class="btn btn-primary"> {{ __('built.All Items') }} </a>
                    </div>
                </div>

                <div class="card-body">
                    <items-view :id="'{{$id}}'"></items-view>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
