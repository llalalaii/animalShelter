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
                        <a data-id="{{$item->id}}" class="btn btn-outline-info py-0 showAdopterButton">
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
                    <a data-id="{{$item->id}}" class="btn btn-outline-info py-0 showAdopterButton">
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


    <div class="modal fade" id="adopterModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="card-description" class="fst-italic"></p>
                    <ul id="animalList" class="list-group"></ul>
                    <a role="button" class="btn btn-outline-success adoptButton mt-4">
                        <span class="mdi mdi-plus"></span>
                        Adopt
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $('.showAdopterButton').click(function(){
            $.ajax({
                method: "GET",
                url: `/adopters/${$(this).data('id')}`,
                success: function(data){
                    $('#modalTitle').text(`${data.adopter.first_name } ${data.adopter.last_name}`);
                    $('#card-description').text(data.adopter.description);
                    $('#animalList').empty();
                    data.adopter.animals.forEach(function (animal){
                        $('#animalList').append(`
                            <li class="list-group-item d-flex justify-content-between">
                                <p class="mb-0">${animal.name} (${animal.breed})</p>
                                <a href="/animals/${animal.id}" target="_blank">View</a>
                            </li>
                        `);
                    });
                    $('.adoptButton').attr('href', '/adopters/'+data.adopter.id);
                    $('#adopterModal').modal('show');
                }
            });
        })

        $('.showAdopterPets').click(function(){
            $.ajax({
                method: "GET",
                url: `/adopters/${$(this).data('id')}`,
                success: function(data){
                    $('#modalTitle').text(`${data.adopter.first_name } ${data.adopter.last_name}`);
                    $('#card-description').text(data.adopter.description);
                    $('#adopterModal').modal('show');
                }
            });
        });
    });
</script>
@endsection