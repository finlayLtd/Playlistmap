<html>
    <head>
        <meta name="google-signin-client_id" content="295843446731-njukp3lcer9r3ed2p5uepvm25iueom8e.apps.googleusercontent.com">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="my-signin2"></div>
        <script>
function onSuccess(googleUser) {
    var profile = googleUser.getBasicProfile();
    var id_token = googleUser.getAuthResponse().id_token;
    authenticateGoogleUser(id_token);
}
function onFailure(error) {
    console.log(error);
}
function renderButton() {
    gapi.signin2.render('my-signin2', {
        'scope': 'profile email https://mail.google.com/',
        'width': 240,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
    });
}



function authenticateGoogleUser(token) {
    console.log('Starting validate token');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "http://localhost:8000/" + "loginWithGoogle",
        data: {tokenID: token},
        success: function (data) {

        },
        error: function (jqXhr, textStatus, errorMessage) { // error callback 
            
        },
        complete: function (data) {

        }
    });


}




        </script>

        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    </body>
</html>
