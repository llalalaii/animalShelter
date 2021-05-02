@extends('layouts.home')

@section('contents')

{{-- this part is to showcase pictures of cats and dogs to attract guests --}}
@include('pages.home.carousel')

<div class="mt-4" id="home-content">
    @include('partials.page-title',['title'=>'The Adoptables'])
    <div class="container">
        <div class="d-flex flex-wrap justify-content-around" id="adoptable-wrapper"></div>
    </div>
</div>

@endsection
@section('js')
<script>
    const animalWrapper = $('#adoptable-wrapper');

    function renderAnimals(animals){
        animals.forEach(item => {
            // es6 way
            animalWrapper.append(`
                <div class="card mx-1 my-1 home-card">
                            <div class="card-body">
                                <h5 class="card-title">${item.name}</h5>
                        <p class="card-text">${item.description}</p>
                        <p class="fst-italic">${item.code}</p>
                        <a href="/animals/${item.id}" class="btn btn-outline-primary">Animal Details . . .</a>
                    </div>
                </div>
            `);

            // old way of appending
            // var html = '<div class="card mx-1 my-1 home-card">';
            // html += '<div class="card-body">';
            // html += '<h5 class="card-title">'+item.name+'</h5>';
            // html += '<p class="card-text">'+item.description+'</p>';
            // html += '<p class="fst-italic">'+item.code+'</p>'
            // html += '<a href="/animals/'+item.id+'" class="btn btn-outline-primary">Animal Details . . .</a>'
            // html += '</div></div>';
            // $('#adoptable-wrapper').append(html);
        });
    }

    function noAnimals(){
    animalWrapper.prepend(`
            <div class="alert alert-danger">
                No adoptable animals.
            </div>
        `);
    }
    $( document ).ready(function() {
        $.ajax({
            method: "GET",
            url: "/adoptable",
        })
        .done(function(data) {
            if(data.animals.length <= 0) {
                noAnimals();
            }

            renderAnimals(data.animals);
        });
    });
</script>
@endsection
