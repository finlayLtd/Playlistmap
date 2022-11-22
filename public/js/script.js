$(document).ready(function () {

    $(window).scroll((event) => {
        var st = $(this).scrollTop();
        if (st > 400) {
            $('.homepage-form-search').addClass('in-header');
            $('nav.navbar').addClass('dark-scroll');
        } else {
            $('.homepage-form-search').removeClass('in-header');
            $('nav.navbar').removeClass('dark-scroll');
        }
    });


    $('input[name=cancelation_reason]').on('click', (e) => {
        if (e.target.value === "Other") {
            $('.cancelation-reason-other-wrapper').removeClass('invisible');

            let otherInput = $('#cancelation-reason-other-input');
            let otherReason = $(otherInput).val();
            if (otherReason !== "" && otherReason.length > 4) {
                $('button.confirmUnlock').attr('disabled', false);
            } else {
                $('button.confirmUnlock').attr('disabled', true);
            }
        } else {
            $('.cancelation-reason-other-wrapper').addClass('invisible');
            $('button.confirmUnlock').attr('disabled', false);
        }
    });

    $('#cancelation-reason-other-input').on('input', (e) => {
        if (e.target.value !== "" && e.target.value.length > 4) {
            $('button.confirmUnlock').attr('disabled', false);
        } else {
            $('button.confirmUnlock').attr('disabled', true);
        }
    });


    $('#stripe_form').on('submit', (e) => {
        $('#paymentModal').addClass('loading');
    });

    /*Search box homepage */
    $("#searchbox").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            if (e.target.value.length < 3) {
                e.preventDefault();
                $('main #homepagetoptext .search-message').addClass('show');
            } else {
                $('main #homepagetoptext .search-message').removeClass('show');
            }
        }
    });

    $('#searchbox').on('input', (e) => {
        console.log(e.target.value);
        if (e.target.value.length < 3) {
            $('#searchform .home-search').removeClass('valid');
        } else {
            $('#searchform .home-search').addClass('valid');
            $('main #homepagetoptext .search-message').removeClass('show');
        }
    });

    $('#searchform').on('submit', (e) => {
        if ($('#searchbox').val().length < 3) {
            e.preventDefault();
            $('main #homepagetoptext .search-message').addClass('show');
        } else {
            $('main #homepagetoptext .search-message').removeClass('show');
        }
    });

    $('#searchform button[type=submit]').on('mouseenter', (e) => {
        console.log('enter');
        if ($('#searchbox').val().length < 3) {
            $('main #homepagetoptext .search-message').addClass('show');
        } else {
            $('main #homepagetoptext .search-message').removeClass('show');
        }
    });

    $('#searchform button[type=submit]').on('mouseout', (e) => {
        $('main #homepagetoptext .search-message').removeClass('show');
    });

    /*Search box search-view */
    $("#search-box-input").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            if (e.target.value.length < 3) {
                e.preventDefault();
                $('main .search-view-form-message').addClass('show');
            } else {
                $('main .search-view-form-message').removeClass('show');
            }
        }
    });

    $('#search-box-input').on('input', (e) => {
        if (e.target.value.length < 3) {
            $('main form#search-view-form .search-input-wrapper').removeClass('valid');
        } else {
            $('main form#search-view-form .search-input-wrapper').addClass('valid');
            $('main  .search-view-form-message').removeClass('show');
        }
    });

    $('#search-view-form').on('submit', (e) => {
        if ($('#search-box-input').val().length < 3) {
            e.preventDefault();
            $('main .search-view-form-message').addClass('show');
        } else {
            $('main .search-view-form-message').removeClass('show');
        }
    });

    $('main form#search-view-form button[type=submit]').on('mouseenter', (e) => {
        console.log('enter');
        if ($('#search-box-input').val().length < 3) {
            $('main .search-view-form-message').addClass('show');
        } else {
            $('main .search-view-form-message').removeClass('show');
        }
    });

    $('main form#search-view-form button[type=submit]').on('mouseout', (e) => {
        $('main .search-view-form-message').removeClass('show');
    });

//    $('body').on('click', 'input[name="payment-radio"]', (e) => {
    $('body').on('click', '.payment-button-tab', (e) => {
        $('.tab-pane').hide();
        $($(e.target).data('target')).show();

        $('.payment-button-tab').removeClass('active');
        $(e.target).addClass('active');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#paymentModal").on('shown.bs.modal', function () {

        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'blue',
                layout: 'vertical',
                label: 'subscribe'
            },
            createSubscription: function (data, actions) {
                return actions.subscription.create({
                    "plan_id": $('#paypal-plan').val()
                });
            },
            onApprove: function (data, actions) {
                $('#paymentModal').addClass('loading');
                $.ajax({
                    type: "POST",
                    url: homeurl + "/subscribeToPaypal",
                    data: data,
                    success: function (data) {
//                        toastr.success('Plan changed successfully');
//                        window.location.reload();
//console.log('')
                        console.log(data);
                        if (data.status === "success" && "planID" in data) {
                            window.location.href = "/manage-plans?action=register-plan&ordercompleted=" + data.planID;
                        } else {
                            window.location.href = "/manage-plans?action=register-plan";
                        }

                        setTimeout(function () {
                            $('#paymentModal').removeClass('loading');
                        }, 5000);
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback 
//                        $('p').append('Error: ' + errorMessage);
                    },
                    complete: function (data) {
//                        $('#paymentModal').removeClass('loading');
                    }
                });
            }
        }).render('#paypal-button-container'); // Renders the PayPal button
    });

    $('#paypal-update-subscription').on('click', (e) => {
        e.preventDefault();
        let data = {
            planID: $('#paypal-plan').val()
        };
        $('#paymentModal').addClass('loading');
        $.ajax({
            type: "POST",
            url: homeurl + "/getPaypalNewPlanURL",
            data: data,
            success: function (data) {
                if (data.status === "success" && 'url' in data) {
                    window.location.href = data.url;
                }
                setTimeout(function () {
                    $('#paymentModal').removeClass('loading');
                }, 5000);
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback 
            },
            complete: function (data) {
//                $('#paymentModal').removeClass('loading');
            }
        });
    });


    checkActionURLParam();

    function checkActionURLParam() {
        const urlParams = new URLSearchParams(window.location.search);
        const action = urlParams.get('action');
        const orderCompleted = urlParams.get('ordercompletedp');
        if (action && action === "register-plan") {
            toastr.success('Plan changed successfully');
            var clean_uri = location.protocol + "//" + location.host + location.pathname;
            if (orderCompleted) {
                clean_uri += ("?ordercompletedp=" + orderCompleted);
            }
            window.history.replaceState({}, document.title, clean_uri); // remove the current query string
        }
    }

    if ($('#artist-id').length > 0) {
        addArtistAutoCompleteEvents();
    }


    $("#addArtistIDModal").on('shown.bs.modal', function (e) {
        console.log("I want this to appear after the modal has opened!");
    });





    $('body.home').on('click', '#update-artist-id', (e) => {
        e.preventDefault();
        console.log('click');
        let artistID = $('#addArtistIDModal input[name=spotify-artist-id]').val();
        if (!artistID || artistID === "") {
            $('#addArtistIDModal #artist-id').focus();
            return;
        }

        let artistImage = $('#addArtistIDModal input[name=spotify-artist-image]').val();

        $.ajax({
            type: "POST",
            url: homeurl + "/updateArtistID",
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            data: JSON.stringify({"artistID": artistID, "artistImage": artistImage}),
            success: function (data) {
                if (data.status === "success") {
                    window.location.reload();
                }
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback 
                window.location.reload();
            },
            complete: function (data) {
                window.location.reload();
            }
        });

    });


//    $('body').on('click', '#profile-update-artist-id', (e) => {
    $('#profile-update-artist-id').on('click', (e) => {
        e.preventDefault();
        console.log('profile-update-artist-id');
        let artistID = $('input[name=spotify-artist-id]').val();
        if (!artistID || artistID === "") {
            $('#addArtistIDModal #artist-id').focus();
            return;
        }

        let artistImage = $('input[name=spotify-artist-image]').val();
        if (!artistImage || artistImage === "") {
            $('#addArtistIDModal #artist-id').focus();
            return;
        }

        let artistName = $('#artist-id').val();
        if (!artistName || artistName === "") {
            $('#addArtistIDModal #artist-id').focus();
            return;
        }



        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to change the spotify artist?',
            text: 'Changing your Spotify artist will delete all your artist data and cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Change',
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: homeurl + "/updateArtistID",
                    contentType: "application/json; charset=utf-8",
                    dataType: 'json',
                    data: JSON.stringify({"artistID": artistID, "artistImage": artistImage, "artistName": artistName}),
                    success: function (data) {
                        if (data.status === "success") {
                            $('#profile-update-artist-id').addClass('d-none');
                            $('#artist-id').attr('disabled', true);

                            Swal.fire({
                                icon: 'success',
                                title: 'Artist updated successfully',
                                timer: 3000,
                                timerProgressBar: false,
                                showConfirmButton: false
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.reload();
                                }
                            });


                        }
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback 
                        window.location.reload();
                    }
                });
            }
        });








    });



    $('body.home').on('click', '#dont-show-artist-modal', (e) => {
        e.preventDefault();
        console.log('click1');

        setCookie('aID_popup', '1', 364);
        $('#addArtistIDModal').modal('hide');
    });



    $('#change-artist-id').on('click', (e) => {
        e.preventDefault();
        $(e.target).fadeOut(400, () => {
            $('#profile-update-artist-id').removeClass('d-none');
            $('#artist-id').attr('disabled', false).val("").focus();
        });

    });


    $('.mobile-nav-button').on('click', (e) => {
        console.log('click');
        $('header').addClass('mobile-menu');
    });

    $('.mobile-nav-button-close').on('click', (e) => {
        $('header').removeClass('mobile-menu');
    });

    $('button.clear-input').on('click', (e) => {
        e.preventDefault();
        $(e.target).css('display', 'none');
        $(e.target).siblings('input').val('').focus();
    });

    if ($('.testimonials-wrapper').length > 0) {
        $('.testimonials-wrapper').slick({
            infinite: false,
            slidesToShow: 1,
            variableWidth: true,
            prevArrow: $('.playlistmap-testimonials .testimonials-prev'),
            nextArrow: $('.playlistmap-testimonials .testimonials-next'),
        });
        $('.testimonials-wrapper').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            if (event.cancelable) {
                event.preventDefault();
             }
            console.log(currentSlide);
            let sliderCount = (slick.slideCount - 1);
            if (nextSlide === 0) { // slick on first element
                $('.testimonials-button.testimonials-prev').removeClass('active');
                $('.testimonials-button.testimonials-next').addClass('active');
            } else if (nextSlide + 1 === sliderCount) {// slick on last element
                $('.testimonials-button.testimonials-prev').addClass('active');
                $('.testimonials-button.testimonials-next').removeClass('active');
            } else {
                $('.testimonials-button.testimonials-prev').addClass('active');
                $('.testimonials-button.testimonials-next').addClass('active');
            }
        });
    }

    $('.single-faq').on('click', (e) => {
        e.preventDefault();
        $(e.target).toggleClass('open');
    });

    $('input[name=yearly-monthly-toggle]').on('change', (e) => {
        if ($(e.target).is(':checked')) {
            $('.monthly-yearly-wrapper').removeClass('month').addClass('year');
            $('.plans-wrapper').removeClass('month').addClass('year');
        } else {
            $('.monthly-yearly-wrapper').removeClass('year').addClass('month');
            $('.plans-wrapper').removeClass('year').addClass('month');
        }
    });

    $('body').on('click', '#apply-coupon', (e) => {
        e.preventDefault();
        console.log('apply-coupon');
        applyCoupon();
    });

    function applyCoupon() {
        let coupon = $('#coupon').val();
        if (!coupon || coupon === "") {
            $(coupon).addClass('is-invalid');
            return;
        }

        $('#apply-coupon').addClass('loading diabled');
        $.ajax({
            type: "get",
            url: homeurl + "/validateStripeCoupon/" + coupon,
            success: function (response) {
                if (response.status === "success") {
                    $('#coupon').removeClass('is-invalid').addClass('is-valid');
                    $('#coupon-code').val(response.promoCode);
                    $('#coupon-name').text("Coupon " + response.promoName + " Applied");
                    setPromoValues(response);

                    $('#paymentModal .modal-body').addClass('discount');
                } else {
                    $('#coupon').removeClass('is-valid').addClass('is-invalid').focus();
                    $('#coupon-code').val("");
                    $('#coupon-name').text("");

                    $('#paymentModal .modal-body').removeClass('discount');
                }
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback 
//                        $('p').append('Error: ' + errorMessage);
            },
            complete: function (data) {
//                        $('#paymentModal').removeClass('loading');
                $('#apply-coupon').removeClass('loading diabled');
            }
        });
    }


    applyCoupon();

    $('body').on('focusout', '#coupon', (e) => {
        $('#coupon').removeClass('is-invalid');
    });


    $('.buyNow').click(function () {
        let planId = $(this).data('plan-id');
        let paypalPlanID = $(this).data('pp-id');
        $('#plan_id').val(planId);
        $('#paypal-plan').val(paypalPlanID);

        console.log('Month plan');
        console.log(planId);
        console.log(paypalPlanID);

        let planDetails = $('#modal-plan-details');

        let planType = $(this).data('plan-type');
        let planName = $(this).data('plan-name');
        console.log(planType);
        console.log(planName);

        if (planType === "month") {
            $('#paymentModal .modal-body').removeClass('year').addClass('month');
            let yearPlan = $('button.buyNow[data-plan-type=year][data-plan-name=' + planName + ']');
            let yearPlanID = $(yearPlan).data('plan-id');
            let yearPlanPPID = $(yearPlan).data('pp-id');
            console.log('Year plan');
            console.log(yearPlanID);
            console.log(yearPlanPPID);

            $(planDetails).data('month-plan-id', planId);
            $(planDetails).data('month-plan-pp-id', paypalPlanID);
            $(planDetails).data('year-plan-id', yearPlanID);
            $(planDetails).data('year-plan-pp-id', yearPlanPPID);

            let monthlyPrice = parseInt($(this).data('price'));
            let monthlyPriceReduced = Math.floor(monthlyPrice * 0.8);
            let yearlyPrice = Math.floor(monthlyPrice * 12 * 0.8);
            let yearlyPriceSave = monthlyPrice * 0.2 * 12;

            $('#paymentModal #modal-plan-price-year').text(monthlyPriceReduced);
            $('#paymentModal #modal-plan-price-month').text(monthlyPrice);
            $('#paymentModal #modal-year-price').text(yearlyPrice);
            $('#paymentModal #modal-year-price').data('original-price', yearlyPrice);
            $('#paymentModal #modal-yearly-save').text(yearlyPriceSave.toFixed(2));
            $('#paymentModal #modal-yearly-save').data('original-price', yearlyPriceSave);

            $('#paymentModal #pay-button-amount-month').text(monthlyPrice);
            $('#paymentModal #pay-button-amount-year').text(yearlyPrice);
            $('input[name=yearly-monthly-toggle-modal]').prop('checked', false);

            console.log(monthlyPrice);
            console.log(yearlyPrice);
            console.log(yearlyPriceSave);

        } else {
            $('#paymentModal .modal-body').removeClass('month').addClass('year');
            let monthPlan = $('button.buyNow[data-plan-type=month][data-plan-name=' + planName + ']');
            let monthPlanID = $(monthPlan).data('plan-id');
            let monthPlanPPID = $(monthPlan).data('pp-id');
            console.log('Year plan');
            console.log(monthPlanID);
            console.log(monthPlanPPID);
            $(planDetails).data('year-plan-id', planId);
            $(planDetails).data('year-plan-pp-id', paypalPlanID);
            $(planDetails).data('month-plan-id', monthPlanID);
            $(planDetails).data('month-plan-pp-id', monthPlanPPID);
            $('input[name=yearly-monthly-toggle-modal]').prop('checked', true);

            let monthlyPriceReduced = parseFloat($(this).data('price'));
            let monthlyPrice = parseInt($('.plan-container.month.' + planName.toLowerCase() + ' .plan-price .price').text());
            let yearlyPrice = Math.floor(monthlyPrice * 12 * 0.8);

            let yearlyPriceSave = Math.floor(monthlyPrice * 0.2 * 12);
//             yearlyPriceSave = Math.round(yearlyPriceSave * 10) / 10;


            $('#paymentModal #modal-plan-price-year').text(monthlyPriceReduced);
            $('#paymentModal #modal-plan-price-month').text(monthlyPrice);
            $('#paymentModal #modal-year-price').text(yearlyPrice);
            $('#paymentModal #modal-yearly-save').text(yearlyPriceSave);

            $('#paymentModal #pay-button-amount-month').text(monthlyPrice);
            $('#paymentModal #pay-button-amount-year').text(yearlyPrice);



        }



        let choosenPlanName = $(this).siblings('h5').text();
        $('#paymentModal #modal-plan-details .plan-name').text(choosenPlanName);

        $('#paymentModal').modal('show');
    });

    $('input[name=yearly-monthly-toggle-modal]').on('click', (e) => {
        let isYearly = $(e.target).is(':checked');
        if (isYearly) {
            $('#paymentModal .modal-body').removeClass('month').addClass('year');
            $('#paymentModal .modal-body .monthly-yearly-wrapper').removeClass('month').addClass('year');
        } else {
            $('#paymentModal .modal-body').removeClass('year').addClass('month');
            $('#paymentModal .modal-body .monthly-yearly-wrapper').removeClass('year').addClass('month');
        }

        setModalPlan(isYearly);
    });

    $('#paymentModal .i-have-coupon').on('click', (e) => {
        e.preventDefault();
        $(e.target).hide();
        $('#paymentModal .coupon-wrapper').show();
    });

});

function setPromoValues(promoOBJ) {
    console.log(promoOBJ);
    if (promoOBJ['promoType'] === 'percent') {
        let percent = (promoOBJ['promoDiscount'] / 100);
        let currentPlanPriceMonth = parseInt($('#modal-plan-price-month').text());
        let reducedPriceMonth = currentPlanPriceMonth * percent;
        $('#modal-plan-price-month-coupon').text(reducedPriceMonth);
        let currentPlanPriceYear = parseInt($('#modal-plan-price-year').text());
        let reducedPriceYear = currentPlanPriceYear * percent;
        $('#modal-plan-price-year-coupon').text(reducedPriceYear);


        $('#paymentModal #pay-button-amount-month').text(reducedPriceMonth);
//        $('#paymentModal #pay-button-amount-year').text(yearlyPrice);

        currentYearPrice = parseInt($('#modal-year-price').data('original-price'));
        newYearPrice = currentYearPrice * percent;
        $('#modal-year-price').text(newYearPrice);

        currentSaveYearPrice = parseInt($('#modal-yearly-save').data('original-price'));
        newSaveYearPrice = currentSaveYearPrice + (currentYearPrice * percent);
        $('#modal-yearly-save').text(newSaveYearPrice);

        $('#paymentModal #pay-button-amount-year').text(newYearPrice);

    } else {
        let amount = promoOBJ['promoDiscount'];
        let currentPlanPriceMonth = parseInt($('#modal-plan-price-month').text());
        let reducedPriceMonth = currentPlanPriceMonth - amount;
        $('#modal-plan-price-month-coupon').text(reducedPriceMonth);
        let currentPlanPriceYear = parseInt($('#modal-plan-price-year').text());
        let reducedPriceYear = currentPlanPriceYear - amount;
        $('#modal-plan-price-year-coupon').text(reducedPriceYear);

        $('#paymentModal #pay-button-amount-month').text(reducedPriceMonth);

        currentYearPrice = parseInt($('#modal-year-price').data('original-price'));
        newYearPrice = currentYearPrice - (12 * amount);
        $('#modal-year-price').text(newYearPrice);

        currentSaveYearPrice = parseInt($('#modal-yearly-save').data('original-price'));
        newSaveYearPrice = currentSaveYearPrice + (12 * amount);
        $('#modal-yearly-save').text(newSaveYearPrice);

        $('#paymentModal #pay-button-amount-year').text(newYearPrice);
    }
}

function setModalPlan(yearly) {
    console.log(yearly);
    let planID, paypalPlanID = false
    if (yearly) {
        planID = $('#modal-plan-details').data('year-plan-id');
        paypalPlanID = $('#modal-plan-details').data('year-plan-pp-id');
    } else {
        planID = $('#modal-plan-details').data('month-plan-id');
        paypalPlanID = $('#modal-plan-details').data('month-plan-pp-id');
    }

    $('#plan_id').val(planID);
    $('#paypal-plan').val(paypalPlanID);
}


function addArtistAutoCompleteEvents() {

    if ($("[id='artist-id']").length === 0) {
        return;
    }
    $("[id='artist-id']").autocomplete({
        classes: {
            "ui-autocomplete": "artists-ui-list"
        },
        minLength: 3,
        maxShowItems: 3,
        select: function (event, ui) {
            event.preventDefault();
            $('#artist-id').val(ui.item.label);
            $('input[name=spotify-artist-id]').val(ui.item.value);
            $('#artist-id').removeClass('ui-autocomplete-loading');
            $('#name').val(ui.item.label);
            $('input[name=spotify-artist-image]').val(ui.item.image);

            $('#artist-wrapper').addClass('col-md-6 got-artist');

            $('form .artist-image-wrapper').show();

            $('#artist-image').attr('src', ui.item.image);

            if ($('#artist-id.profile-artist-id').length === 0) {
                $('#email').focus();
            }

        },
        source: function (request, response) {
            $.ajax({
                url: homeurl + "/getSpotifyArtistsByName/" + request.term,

                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    $(".spotify-list").empty();
                    response($.map(data, function (result) {
                        $("<li class='text-left m-2 text-truncate' onclick='selectArtist(`"+result.image+"`, `"+result.label+"`)'></li>")
                        .data("result.autocomplete", result)
                        .append("<img style='width:75px;height:75px;border-radius:100%;' src='" + result.image + "' /><span>" + result.label + "</span>")
                        .appendTo($(".spotify-list").css('display', 'block'));
                        return null;
                        // return {
                        //     label: result.label,
                        //     value: result.value,
                        //     image: result.image
                        // };
                    }));
                }
            });
        }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        console.log('itemsss');
        return $("<li class='text-left m-2' onclick='selectArtist(`"+item.image+"`, `"+item.label+"`)'></li>")
                .data("item.autocomplete", item)
                .append("<img style='width:75px;height:75px;border-radius:100%;' src='" + item.image + "' /><span>" + item.label + "</span>")
                .appendTo($(".spotify-list").css('display', 'block'));
    };

    $('[id="artist-id"]').on('focusout', (e) => {
        $("[id='artist-id']").removeClass('ui-autocomplete-loading');
    });

    $("[id='artist-id']").focus();

}



function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return c.substring(nameEQ.length, c.length);
    }
    return null;
}
