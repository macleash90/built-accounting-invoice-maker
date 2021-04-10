@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="card-title">
                        {{ __('built.Create Item') }}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('items.index')}}" class="btn btn-primary"> {{ __('built.All Items') }} </a>
                    </div>
                </div>

                <div class="card-body">
                    <items-create></items-create>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection