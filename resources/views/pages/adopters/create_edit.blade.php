@extends('layouts.master')

@section('contents')

@include('partials.page-title',['title'=>'Adopters'])
<div class="container">
    @include('partials.alerts')
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="text-end">
                <a href="{{route('adopters.index')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
            </div>

            {{-- This form has a ternary operator to identify which route it goes to if the $animals have an to provide or not --}}
            <form
                action="{{Route::currentRouteName() == 'adopters.store' ? route('adopters.store') : route('adopters.update',$adopter->id ?? '')}}"
                method="POST" class="">

                {{-- This is important so that if there is no $adopter value the request will not try to send a put request. --}}
                @if($adopter ?? false)
                @method('PUT')
                @endif

                @csrf
                {{-- Since this page is used for both create and edit it is important that we check them in the value of each field. --}}
                <div class="mb-3">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control"
                        value="{{$adopter->first_name ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{$adopter->last_name ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="6"
                        class="form-control">{{$adopter->description ?? ''}}</textarea>
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
