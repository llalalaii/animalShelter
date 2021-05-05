@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Injuries'])
<div class="container">
    @include('partials.alerts')
    @if(Auth::user()->position == 'Veterinarian')
    <a role="button" href="{{route('injuries.create')}}" class="btn btn-outline-success pr-3 mb-3">
        <span class="mdi mdi-plus"> </span>
        New injury
    </a>
    @endif

    <table class="table table-hover table-striped table-responsive">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- I used forelse instead of foreach so that i can add an @empty block which is important when there is no data fetch inside the $injuries --}}
            @forelse ($injuries as $item)
            <tr>
                <td>{{$item->code}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->description_wrap}}</td>
                <td>
                    <a href="{{route('injuries.show',$item->id)}}" class="btn btn-outline-info py-0">
                        <span class="mdi mdi-eye-outline"></span>
                    </a>
                    @if(Auth::user()->position == 'Veterinarian')
                        <form action="{{route('injuries.destroy',$item->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('injuries.edit',$item->id)}}" class="btn btn-outline-primary py-0">
                                <span class="mdi mdi-pencil"></span>
                            </a>
                            <button class="btn btn-outline-danger py-0">
                                <span class="mdi mdi-delete"></span>
                            </button>
                        </form>
                    @endif
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
