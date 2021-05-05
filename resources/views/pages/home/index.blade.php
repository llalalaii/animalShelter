@extends('layouts.home')

@section('contents')

{{-- this part is to showcase pictures of cats and dogs to attract guests --}}
@include('pages.home.carousel')

<div class="mt-4" id="home-content">
    @include('partials.page-title',['title'=>'The Adoptables'])
    <div class="container">
        <div class="alert alert-info text-center d-none" id="homeLoading">
            Loading...
        </div>
        <div class="d-flex flex-wrap justify-content-around" id="adoptable-wrapper"></div>
    </div>
</div>

@endsection
@section('js')
<script>
    const animalWrapper = $('#adoptable-wrapper');
    const homeLoading = $('#homeLoading');

    function renderAnimals(animals){
        animals.forEach(item => {
            // es6 way
            animalWrapper.append(`
                <div class="card mx-1 my-1 home-card">
                    <div class="card-body">
                        <h5 class="card-title"><b>${item.name}</b></h5>
                        <h6 class="card-title fst-italic">${item.breed}</h6>
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

    function noAnimals(message){
        animalWrapper.before(`
            <div class="alert alert-danger text-center">
                ${message}
            </div>
        `);
    }

    function loadAdoptableAnimals(url, noAnimalsMessage, query = null){
        $.ajax({
            method: "GET",
            url: url,
            beforeSend: function(){
                if(query) {
                    animalWrapper.empty();
                    $('.alert-danger').remove();
                } 
                homeLoading.removeClass('d-none');
            },
            success: function(data){
                homeLoading.addClass('d-none');
                if(!data.animals.length) noAnimals(noAnimalsMessage);
                renderAnimals(data.animals);
            },
        })
    }

    $( document ).ready(function() {
        loadAdoptableAnimals('/adoptable', 'No adoptable animals.');
  
        // I used debounce to send a request after 500ms of typing
        var debounce;
        $('#main-searchbar').on('input', function (e) {
            const query = e.target.value;
            clearTimeout(debounce);

            debounce = setTimeout(
                function () {
                    loadAdoptableAnimals(`/adoptable/${query}`, 'No result.', query);
                },
            500);
        });
    });
</script>
@endsection
