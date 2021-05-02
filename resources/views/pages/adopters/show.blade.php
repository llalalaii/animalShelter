@extends('layouts.master')

@section('contents')
@include('partials.page-title',['title'=>'Adopters'])
<div class="container">
    <div class="row">
        <div class="col-12">
            @include('partials.alerts')

            <div class="d-flex flex-row-reverse">

                <a href="{{route('adopters.index')}}" class="btn btn-outline-secondary">
                    <span class="mdi mdi-arrow-left"></span>
                    Back
                </a>
            </div>
        </div>
    </div>
    <div class="row my-3">
        {{-- this part shows the adopter full name and description --}}
        <div class="col-12 col-md-4">
            <div class="card w-100">
                <div class="card-body pa-3">
                    <h5 class="card-title fw-bold">{{$adopter->full_name}}</h5>
                    <p class="card-text text-justify">{{$adopter->description}}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            {{-- this block restricts unauthorized user from sending a post request --}}
            @auth
            <form action="{{route('adopters.attachDetach')}}" method="POST" class="mb-3">
                @csrf
                <input type="hidden" name="action" value="attach">
                <input type="hidden" name="id" value="{{$adopter->id}}">

                <div class="row">
                    <div class="col-3 col-lg-2">
                        <label for="exampleDataList" class="form-label">
                            <button role="button" class="btn btn-outline-success btn-small">
                                <span class="mdi mdi-plus"></span>
                                Add
                            </button>
                        </label>
                    </div>
                    <div class="col-9 col-lg-10">
                        <select class="form-select" aria-label="Default select example" name="item_id">
                            <option selected value="default">Open this select menu</option>
                            @forelse ($animals as $item)
                            <option value="{{$item->id}}">{{$item->code}}. {{$item->name}} ({{$item->type}})</option>
                            @empty
                            <option disabled>No data available.</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </form>
            @endauth

            <div class="card w-100">
                {{-- this block restricts unauthorized user from sending a post request --}}
                @auth
                <form action="{{route('adopters.attachDetach')}}" method="POST" id="deleteForm">
                    @csrf
                    <input type="hidden" name="action" value="detach">
                    <input type="hidden" name="id" value="{{$adopter->id}}">
                    <input type="hidden" name="item_id" id="item_id">
                </form>
                @endauth

                <div class="accordion" id="accordionExample">
                    {{-- this block loops all the animals which are associated with this adopter --}}
                    @forelse ($adopter->animals as $item)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{$item->id}}" aria-expanded="false"
                                aria-controls="collapse{{$item->id}}">
                                {{$item->code}}&nbsp;-&nbsp;<b>{{$item->name}}</b>&nbsp; ({{$item->type}}) &nbsp;

                                {{-- this block restricts unauthorized user from sending a post request --}}
                                @auth
                                <span class="mdi mdi-delete text-danger deleteBtn" data-item_id="{{$item->id}}"></span>
                                @endauth
                            </button>
                        </h2>
                        <div id="collapse{{$item->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {{$item->description_wrap}}
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- this block will show if there are no data fetch in the collection --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#NoDatacollapse" aria-expanded="false" aria-controls="NoDatacollapse">
                                This will soon be filled by animals you adopted.
                            </button>
                        </h2>
                        <div id="NoDatacollapse" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Thank you for your support.
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@section('js')
{{-- it is also nice to add this for the script just to make everything secure --}}
@auth
<script>
    $('.deleteBtn').click(function(){
        $('#item_id').val( $(this).attr('data-item_id'));
        $('#deleteForm').submit();
    });
</script>
@endauth
@endsection