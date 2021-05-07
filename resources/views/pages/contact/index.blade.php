@extends('layouts.master')

@section('contents')
<<<<<<< HEAD
@include('partials.page-title',['title'=>'Contact us'])
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            @include('partials.alerts')
            <form action="{{ route('contact.form.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" value="">
                </div>
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="">
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="">
                </div>

                <div class="mb-3">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" rows="6" class="form-control"></textarea>
                </div>

                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-outline-success">
                        <span class="mdi mdi-send"></span>
                        Submit
=======
@include('partials.page-title',['title'=>'Contact Us'])
<div class="container">
    @include('partials.alerts')
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
          
            {{-- This form has a ternary operator to identify which route it goes to if the $rescuer have an to provide or not --}}
            <form>
                {{-- This is important so that if there is no $rescuer value the request will not try to send a put request. --}}
                @if($rescuer ?? false)
                @method('PUT')
                @endif

                @csrf
                {{-- Since this page is used for both create and edit it is important that we check them in the value of each field. --}}
                <div class="mb-3">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control"
                        value="{{$rescuer->first_name ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{$rescuer->last_name ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="last_name">Email</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{$rescuer->last_name ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="last_name">Subject</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{$rescuer->last_name ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="last_name">Email</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{$rescuer->last_name ?? ''}}">
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="6"
                        class="form-control">{{$rescuer->description ?? ''}}</textarea>
                </div>
                <div class="d-grid gap-2 col-3 mx-auto">
                    <button class="btn btn-outline-primary">
                        <span class="mdi mdi-save"></span>
                        Send
>>>>>>> f7613ed5e7e2bed8402b2064deb23b7bc2e4f7a1
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
