
// this code is to slowly fade out the alerts session gave after a post request or other instances in which session gives alert.
$('.session-alert').delay(3000).fadeOut('slow');

// this code is to submit a logout form since the design will be ruined if i added a form inside the dropdown menu
$('#logoutBtn').click(function(){
    $('#logoutForm').submit();
})

$('#main-searchbar').keyup(function(e){
    console.log(e)
    // $.ajax({
    //     method: "GET",
    //     url: "/adoptable/search",
    //     data: {
    //         // name:
    //     }
    // })
    // .done(function(data) {
    // });
});

