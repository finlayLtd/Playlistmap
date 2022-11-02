$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.move-user-to-whitelist').on('click', (e) => {
        e.preventDefault();

        let spotifyUserID = $(e.target).data('id');
        let spotifyUserName = $(e.target).data('label');

        Swal.fire({
            title: 'Are you sure you want to move ' + spotifyUserName + ' to whitelist?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: homeurl + "/backend/spotifyUsers/moveToWhitelist",
                    contentType: "application/json; charset=utf-8",
                    dataType: 'json',
                    data: JSON.stringify({spotifyUserID: spotifyUserID}),
                    success: function (data) {
                        if (data.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'User moved to whitelist successfully!',
                                timer: 3000,
                                timerProgressBar: false,
                                showConfirmButton: false
                            }).then((result) => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: data.message,
                                timerProgressBar: false,
                            });
                        }
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback 
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            timerProgressBar: false
                        });
                    }
                });
            }
        });
    });


    $('.move-user-to-blacklist').on('click', (e) => {
        e.preventDefault();

        let spotifyUserID = $(e.target).data('id');
        let spotifyUserName = $(e.target).data('label');

        Swal.fire({
            title: 'Are you sure you want to move ' + spotifyUserName + ' to blacklist?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: homeurl + "/backend/spotifyUsers/moveToBlacklist",
                    contentType: "application/json; charset=utf-8",
                    dataType: 'json',
                    data: JSON.stringify({spotifyUserID: spotifyUserID}),
                    success: function (data) {
                        if (data.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'User moved to blacklist successfully!',
                                timer: 3000,
                                timerProgressBar: false,
                                showConfirmButton: false
                            }).then((result) => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: data.message,
                                timerProgressBar: false,
                            });
                        }
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback 
                        Swal.fire({
                            icon: 'error',
                            title: data.message,
                            timerProgressBar: false
                        });
                    }
                });
            }
        });
    });
});