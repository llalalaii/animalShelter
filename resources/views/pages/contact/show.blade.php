@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Contact us List'])
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            @include('partials.alerts')

            <div class="d-flex flex-row-reverse justify-content-between">
                <a href="{{route('contact.list')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
                <form action="{{route('contact.destroy',$contact->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-outline-danger">
                        <span class="mdi mdi-delete"></span>
                        Delete
                    </button>
                </form>
            </div>

            <div class="card my-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{$contact->subject}}</h5>
                    <h6 class="card-title fst-italic">{{$contact->name}}</h6>
                    <p class="card-title">{{$contact->email}}</p>
                    <p class="card-text text-justify">{{$contact->message}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
