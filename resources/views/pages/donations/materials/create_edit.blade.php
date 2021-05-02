@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Material Donations'])
<div class="container">
    @include('partials.alerts')
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="text-end">
                <a href="{{route('materials.index')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
            </div>
            {{-- This form has a ternary operator to identify which route it goes to if the $material have an to provide or not --}}
            <form
                action="{{Route::currentRouteName() == 'materials.store' ? route('materials.store') : route('materials.update',$material->id ?? '')}}"
                method="POST" class="">
                {{-- This is important so that if there is no $material value the request will not try to send a put request. --}}
                @if($material ?? false)
                @method('PUT')
                @endif

                @csrf
                {{-- Since this page is used for both create and edit it is important that we check them in the value of each field. --}}
                <div class="mb-3">
                    <label for="name">Material</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{$material->name ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="value">Amount</label>
                    <input type="number" name="value" id="value" class="form-control"
                        value="{{$material->value ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="unit">Unit</label>
                    <input type="text" name="unit" id="unit" class="form-control" value="{{$material->unit ?? ''}}">
                </div>

                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-outline-primary">
                        <span class="mdi mdi-save"></span>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
