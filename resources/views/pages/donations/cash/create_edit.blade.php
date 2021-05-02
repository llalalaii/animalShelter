@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Cash Donations'])
<div class="container">
    @include('partials.alerts')
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="text-end">
                <a href="{{route('cash.index')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
            </div>
            {{-- This form has a ternary operator to identify which route it goes to if the $cash have an to provide or not --}}
            <form
                action="{{Route::currentRouteName() == 'cash.store' ? route('cash.store') : route('cash.update',$cash->id ?? '')}}"
                method="POST" class="">
                {{-- This is important so that if there is no $cash value the request will not try to send a put request. --}}
                @if($cash ?? false)
                @method('PUT')
                @endif

                @csrf
                {{-- Since this page is used for both create and edit it is important that we check them in the value of each field. --}}
                <div class="mb-3">
                    <label for="name">Donator name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{$cash->name ?? ''}}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="value">Amount</label>
                    <input type="number" name="value" id="value" class="form-control" value="{{$cash->value ?? ''}}"
                        required>
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