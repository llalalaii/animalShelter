@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Animals'])
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            @include('partials.alerts')

            {{-- this block is for adding photo/s of certain animal and is wrap with @auth so that only authorized users can send the request --}}
            @auth
            <div class="">
                <div class="d-flex justify-content-between">

                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                        data-bs-target="#addPhotos">
                        <span class="mdi mdi-image"></span>
                        Add Photos
                    </button>

                    <a href="{{route('animals.index')}}" class="btn btn-outline-secondary">
                        <span class="mdi mdi-arrow-left"></span>
                        Back
                    </a>

                    <div class="modal fade" id="addPhotos" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="addPhotosLabel" aria-hidden="true">
                        <form enctype="multipart/form-data" method="post" action="{{route('animals.upload')}}">
                            @csrf
                            <input type="text" name="id" hidden value="{{$animal->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addPhotosLabel">
                                            <span class="mdi mdi-image"></span>
                                            Add Photos
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input required type="file" class="form-control" name="images[]"
                                            placeholder="animal photos" multiple>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-outline-primary">Save</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            @endauth

            @guest
            <div class="text-end">
                <a href="{{route('animals.index')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
            </div>
            @endguest

            <div class="card my-3 w-100">

                {{-- if theres photo/s associated with the animal, a carousel will show  --}}
                @if ($animal->photos()->count())
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($animal->photos as $key => $value)
                        <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                            <img src="{{url('storage/images/'.$value->image)}}" class="d-block w-100">
                            @auth
                            <div class="carousel-caption d-none d-md-block">
                                <form action="{{route('animals.remove',$value->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-outline-danger">
                                        <span class="mdi mdi-trash"></span>
                                        Remove
                                    </button>
                                </form>
                            </div>
                            @endauth
                        </div>
                        @endforeach
                    </div>

                    {{-- this hides the carousel indicator if there is only one photo --}}
                    @if ($animal->photos()->count() > 1)
                    <ol class="carousel-indicators">
                        @foreach($animal->photos as $key => $value)
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$key}}"
                            class="{{$key == 0 ? 'active' : ''}}"></li>
                        @endforeach
                    </ol>

                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                    @endif
                </div>
                @endif

                {{-- this part shows all the details of certain animal --}}
                <div class="card-body">
                    <h5 class="card-title"><b>{{$animal->name}}</b> ({{$animal->type}})</h5>
                    <p class="card-text text-justify">{{$animal->description}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        Breed: {{$animal->breed}}
                    </li>
                    <li class="list-group-item">
                        Gender: {{$animal->gender}}
                    </li>
                    <li class="list-group-item">
                        Age: {{$animal->age}}
                    </li>
                </ul>
            </div>

            <h3 class="text-center mb-1">Sickness</h3>
            <hr class="mt-0">

            {{-- this part is only for authorized users where they added a disease or injury to an animal if necessary --}}
            @auth
            <form action="{{route('animals.attachDetachSickness')}}" method="POST" class="mb-3">
                @csrf
                <input type="hidden" name="action" value="attach">
                <input type="hidden" name="id" value="{{$animal->id}}">

                <div class="row">
                    <div class="col-5 col-lg-3">
                        <label for="exampleDataList" class="form-label">
                            <button role="button" class="btn btn-outline-success btn-small">
                                <span class="mdi mdi-plus"></span>
                                Add sickness
                            </button>
                        </label>
                    </div>
                    <div class="col-7 col-lg-9">
                        <select class="form-select" aria-label="Default select example" name="item_id">
                            <option selected value="default">Open this select menu</option>
                            @forelse ($sicknesses as $item)
                            <option value="{{$item->id}}">{{$item->code}}. {{$item->name}}
                            </option>
                            @empty
                            <option disabled>No data available.</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </form>
            @endauth

            {{-- this part list the sickness of an animal and also has a button to remove them once the animal is rehabilitated. --}}
            @auth
            <form action="{{route('animals.attachDetachSickness')}}" method="POST" id="deleteForm">
                @csrf
                <input type="hidden" name="id" value="{{$animal->id}}">
                <input type="hidden" name="item_id" id="item_id">
            </form>
            @endauth
            <ul class="list-group">
                @forelse ($animal->sickness as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <p class="mb-0">{{$item->name}}</p>
                        
                        <a @if ($item->is_injury) href="{{route('injuries.show',$item->id)}}" @else href="{{route('diseases.show',$item->id)}}" @endif>View</a>
                    </li>
                @empty
                <div class="alert alert-success text-center">
                    Healthy!
                </div>
                @endforelse
            </ul>
        </div>
    </div>
</div>

@endsection
@section('js')
@auth
<script>
    $('.deleteBtn').click(function(){
        $('#item_id').val( $(this).attr('data-item_id'));
        $('#deleteForm').submit();
    });
</script>
@endauth
@endsection

