let stripe = Stripe(stripe_key);
let elements = stripe.elements();

let $card_errors = $('.card-errors');
let $form = $('#stripe_form');
let $submit_btn = $('#pay_now');

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
let style = {
    base: {
        color: "#32325D",
        fontWeight: 500,
        fontFamily: "Inter UI, Open Sans, Segoe UI, sans-serif",
        fontSize: "16px",
        fontSmoothing: "antialiased",
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    },
};

// Create an instance of the card Element.
let card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    if (event.error) {
        $card_errors.text(event.error.message);
    } else {
        $card_errors.text('');
    }
});

// Handle form submission.
$submit_btn.click(function (e) {
    e.preventDefault();
    stripe.createToken(card).then(function(result) {
        if (result.error) {
            $card_errors.text(result.error.message);
        } else {
            stripeTokenHandler(result.token);
        }
    });
});

function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    let stripe_token = $("<input type='hidden' name='stripe_token' />");
    let card = $("<input type='hidden' name='card' />");
    stripe_token.val(token.id);
    card.val(token.card);
    $form.append(stripe_token);
    $form.append(card);

    // Submit the form
    $form.submit();
}
