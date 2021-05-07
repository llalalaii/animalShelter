@extends('layouts.master')

@section('contents')
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
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
