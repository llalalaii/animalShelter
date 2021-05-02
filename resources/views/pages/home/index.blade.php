@extends('layouts.home')

@section('contents')

{{-- this part is to showcase pictures of cats and dogs to attract guests --}}
@include('pages.home.carousel')

<div class="mt-4" id="home-content">
    @include('partials.page-title',['title'=>'The Adoptables'])
    <div class="container">
        @if($animals->count() == 0)
        <div class="alert alert-danger">
            Wala pang available. Either may sakit pa or naadopt na.
        </div>
        @endif

        {{-- we show all animals that are rehabilitated (with no sickness) --}}
        <div class="d-flex flex-wrap justify-content-around">
            @foreach ($animals as $item)
            <div class="card mx-1 my-1 home-card">
                <div class="card-body">
                    <h5 class="card-title">{{$item->name}}</h5>
                    <p class="card-text">{{$item->description_wrap}}</p>
                    <p class="fst-italic">{{$item->code}}</p>
                    <a href="{{route('animals.show',$item->id)}}" class="btn btn-outline-primary">Animal Details . . .</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    var myCarousel = document.querySelector('#carouselExampleIndicators')
    var carousel = new bootstrap.Carousel(myCarousel, {
    interval: 2500,
    });
</script>
@endsection