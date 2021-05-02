@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Animals'])
<div class="container">
    @include('partials.alerts')
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="text-end">
                <a href="{{route('animals.index')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
            </div>
            {{-- This form has a ternary operator to identify which route it goes to if the $animal have an to provide or not --}}
            <form
                action="{{Route::currentRouteName() == 'animals.store' ? route('animals.store') : route('animals.update',$animal->id ?? '')}}"
                method="POST" class="">

                {{-- This is important so that if there is no $animal value the request will not try to send a put request. --}}
                @if($animal ?? false)
                @method('PUT')
                @endif

                @csrf
                {{-- Since this page is used for both create and edit it is important that we check them in the value of each field. --}}
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{$animal->name ?? ''}}"
                        >
                </div>

                <div class="mb-3">
                    <label for="breed">Breed</label>
                    <input type="text" name="breed" id="breed" class="form-control" value="{{$animal->breed ?? ''}}"
                        >
                </div>

                <div class="mb-3">
                    <label for="gender">Gender</label><br>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="gender" id="male_gender" value="Male"
                            autocomplete="off" {{ (($animal->gender??'')=="Male")? "checked" : "" }} >
                        <label class="btn btn-outline-success" for="male_gender">Male</label>
                        <input type="radio" class="btn-check" name="gender" id="female_gender" value="Female"
                            autocomplete="off" {{ (($animal->gender??'')=="Female")? "checked" : "" }} >
                        <label class="btn btn-outline-success" for="female_gender">Female</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-control" value="{{$animal->age ?? ''}}"
                        >
                </div>

                <div class="mb-3">
                    <label for="type">Type (e.g. Cat, Dog, etc.)</label>
                    <input type="text" name="type" id="type" class="form-control" value="{{$animal->type ?? ''}}"
                        >
                </div>

                <div class="mb-3">
                    <label for="description">Health Status</label>
                    <textarea name="description" id="description" rows="6"
                        class="form-control">{{$animal->description ?? ''}}</textarea>
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