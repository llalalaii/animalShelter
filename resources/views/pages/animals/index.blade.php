@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Animals'])
<div class="container">
    @include('partials.alerts')
    @auth
    <a role="button" href="{{route('animals.create')}}" class="btn btn-outline-success pr-3 mb-3">
        <span class="mdi mdi-plus"> </span>
        New animal
    </a>
    @endauth

    <table class="table table-hover table-striped table-responsive">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Breed</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Type</th>
                <th>Health Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- I used forelse instead of foreach so that i can add an @empty block which is important when there is no data fetch inside the $animals --}}
            @forelse ($animals as $item)
            <tr>
                <td>{{$item->code}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->breed}}</td>
                <td>{{$item->age}}</td>
                <td>{{$item->gender}}</td>
                <td>{{$item->type}}</td>
                <td>{{$item->description_wrap}}</td>
                <td>
                    {{-- I added an auth block here so that unauthorized users will not be able to update and delete --}}
                    @auth
                    <form action="{{route('animals.destroy',$item->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{route('animals.show',$item->id)}}" class="btn btn-outline-info py-0">
                            <span class="mdi mdi-eye-outline"></span>
                        </a>

                        <a href="{{route('animals.edit',$item->id)}}" class="btn btn-outline-primary py-0">
                            <span class="mdi mdi-pencil"></span>
                        </a>
                        <button class="btn btn-outline-danger py-0">
                            <span class="mdi mdi-delete"></span>
                        </button>
                    </form>
                    @else
                    <a href="{{route('animals.show',$item->id)}}" class="btn btn-outline-info py-0">
                        <span class="mdi mdi-eye-outline"></span>
                    </a>
                    @endauth
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