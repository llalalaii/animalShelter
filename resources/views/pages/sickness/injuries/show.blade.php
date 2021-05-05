@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Injuries'])
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            @include('partials.alerts')

            <div class="d-flex flex-row-reverse">

                <a href="{{route('injuries.index')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
            </div>
            
            <div class="card my-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{$sickness->name}}</h5>
                    <p class="card-text text-justify">{{$sickness->description}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection