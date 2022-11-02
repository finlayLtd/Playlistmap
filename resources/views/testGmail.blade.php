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
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
//    console.log('Image URL: ' + profile.getImageUrl());
//    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.




//                console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    var id_token = googleUser.getAuthResponse().id_token;
    authenticateGoogleUser(id_token);
    console.log(id_token);
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
//    let token = "eyJhbGciOiJSUzI1NiIsImtpZCI6ImQwMWMxYWJlMjQ5MjY5ZjcyZWY3Y2EyNjEzYTg2YzlmMDVlNTk1NjciLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXpwIjoiMjk1ODQzNDQ2NzMxLW5qdWtwM2xjZXI5cjNlZDJwNXVlcHZtMjVpdWVvbThlLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiYXVkIjoiMjk1ODQzNDQ2NzMxLW5qdWtwM2xjZXI5cjNlZDJwNXVlcHZtMjVpdWVvbThlLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTA1MjMwMjc5MDg4MDg2NzAwMDU4IiwiZW1haWwiOiJhcmVsZ2luZG9zdGVzdEBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiYXRfaGFzaCI6InFYd0ttTHZYVmk0Y0RYTTBKaExfWEEiLCJuYW1lIjoiQXJlbCBHaW5kb3MiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL2EvQUFUWEFKei1VOWhDVjdIa3dvaXpaTjJHWEo4VXhJZWhSUzhVR1BlcHhDQmM9czk2LWMiLCJnaXZlbl9uYW1lIjoiQXJlbCIsImZhbWlseV9uYW1lIjoiR2luZG9zIiwibG9jYWxlIjoiZW4iLCJpYXQiOjE2NDE0ODQ0OTQsImV4cCI6MTY0MTQ4ODA5NCwianRpIjoiOTI2NWEzYjkyMTkzYzI1ODFmZTUyZWFiODhkNzMyNmNiZjZmYWZiMSJ9.IlEA8AlMsodt4iHCo1_km7jU8S-5fQ8s0nF1Yyf3VL5lQ3xyL1IKTUec3K-GyT906DEteVuaTXsuC3pEQ-zSdPKaBGzu-mN30FG4p9zyHUUVAlGJ32u-3fzl27RUaejmxXLjqxUAdrBhVUWtLKc3jEnHsvn0SHf1Atp0wnQ4xUKxNop43aWUxye2Bmps9-r1PIYt6h5Q-q6pJywjNJWp1SwZ8VwhQ4UyHLxtvqz4zAAQJNBWmSY5NvcDKdS7_0frWvLuyz8cu-0E30JwnZg3tK9-5vAcrwnSeHBKDHaJZTpXE9Qf9kCs7tAg9aoDA3_BZlIAzyth-r6wYzxhuSNOwg";
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
            console.log(data);
//                        if (data.status === "success" && 'url' in data) {
//                            window.location.href = data.url;
//                        }
//                        setTimeout(function () {
//                            $('#paymentModal').removeClass('loading');
//                        }, 5000);
        },
        error: function (jqXhr, textStatus, errorMessage) { // error callback 
        },
        complete: function (data) {
//                $('#paymentModal').removeClass('loading');
        }
    });


}




        </script>

        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    </body>
</html>
