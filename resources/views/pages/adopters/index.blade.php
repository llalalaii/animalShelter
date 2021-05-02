@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Adopters'])
<div class="container">
    @include('partials.alerts')
    @auth
    <a role="button" href="{{route('adopters.create')}}" class="btn btn-outline-success pr-3 mb-3">
        <span class="mdi mdi-plus"> </span>
        New adopter
    </a>
    @endauth

    <table class="table table-hover table-striped table-responsive">
        <thead>
            <tr>
                <th>Code</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- I used forelse instead of foreach so that i can add an @empty block which is important when there is no data fetch inside the $adopters --}}
            @forelse ($adopters as $item)
            <tr>
                <td>{{$item->code}}</td>
                <td>{{$item->first_name}}</td>
                <td>{{$item->last_name}}</td>
                <td>{{$item->description_wrap}}</td>
                <td>
                    {{-- I added an auth block here so that unauthorized users will not be able to update and delete --}}
                    @auth
                    <form action="{{route('adopters.destroy',$item->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{route('adopters.show',$item->id)}}" class="btn btn-outline-info py-0">
                            <span class="mdi mdi-eye-outline"></span>
                        </a>
                        <a href="{{route('adopters.edit',$item->id)}}" class="btn btn-outline-primary py-0">
                            <span class="mdi mdi-pencil"></span>
                        </a>
                        <button class="btn btn-outline-danger py-0">
                            <span class="mdi mdi-delete"></span>
                        </button>
                    </form>
                    @else
                    <a href="{{route('adopters.show',$item->id)}}" class="btn btn-outline-info py-0">
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