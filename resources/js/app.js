
// this code is to slowly fade out the alerts session gave after a post request or other instances in which session gives alert.
$('.session-alert').delay(3000).fadeOut('slow');

// this code is to submit a logout form since the design will be ruined if i added a form inside the dropdown menu
$('#logoutBtn').click(function(){
    $('#logoutForm').submit();
})

const animalWrapper = $('#adoptable-wrapper');

function renderAnimals(animals){
    animals.forEach(item => {
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
    });
}

function noAnimals(message){
    animalWrapper.before(`
        <div class="alert alert-danger text-center">
            ${message}
        </div>
    `);
}

function searchAdoptable(query){
    $.ajax({
        method: "GET",
        url: `/adoptable/${query}`,
        beforeSend: function(){
            animalWrapper.empty();
            $('.alert-danger').remove();
            $('#homeLoading').removeClass('d-none');
        },
        success: function(data){
            $('#homeLoading').addClass('d-none');
            if(!data.animals.length) noAnimals('No result.');
            renderAnimals(data.animals);
        },
    })
}

// I used debounce to send a request after 500ms of typing
var debounce;
$('#main-searchbar').on('input', function (e) {
    const query = e.target.value;

    clearTimeout(debounce);

    debounce = setTimeout(
        function () {
            searchAdoptable(query);
        },
    500);
});


