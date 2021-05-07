@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Contact us List'])
<div class="container">
    @include('partials.alerts')

    <table class="table table-hover table-striped table-responsive">
        <thead>
            <tr>
                <th>Code</th>
                <th>Subject</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contacts as $item)
            <tr>
                <td>{{$item->code}}</td>
                <td>{{$item->subject_wrap}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->message_wrap}}</td>
                <td>
                    <form action="{{route('contact.destroy',$item->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{route('contact.show',$item->id)}}" class="btn btn-outline-info py-0">
                            <span class="mdi mdi-eye-outline"></span>
                        </a>
                        <button class="btn btn-outline-danger py-0">
                            <span class="mdi mdi-delete"></span>
                        </button>
                    </form>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="100%" class="text-center">
                    No data available.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
