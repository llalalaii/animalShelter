@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Employees'])
<div class="container">
    @include('partials.alerts')
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="text-end">
                <a href="{{route('employees.index')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
            </div>
            {{-- This form has a ternary operator to identify which route it goes to if the $employee have an to provide or not --}}
            <form
                action="{{Route::currentRouteName() == 'employees.store' ? route('employees.store') : route('employees.update',$employee->id ?? '')}}"
                method="POST" class="">
                {{-- This is important so that if there is no $employee value the request will not try to send a put request. --}}
                @if($employee ?? false)
                @method('PUT')
                @endif

                @csrf
                {{-- Since this page is used for both create and edit it is important that we check them in the value of each field. --}}
                <div class="mb-3">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control"
                        value="{{$employee->first_name ?? ''}}" required>
                </div>

                <div class="mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{$employee->last_name ?? ''}}" required>
                </div>

                <div class="mb-3">
                    <label for="position">Position</label>
                    <input type="text" name="position" id="position" class="form-control"
                        value="{{$employee->position ?? ''}}" required>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{$employee->email ?? ''}}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
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