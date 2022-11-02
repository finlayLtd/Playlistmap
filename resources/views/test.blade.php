<div id="paypal-button-container"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AQIy8l97Aeq4JovE89lJXVBeaDP72wJqujTnYxo_k0Y7xpuvk1ayoQkTkjbdHOCa4fhuvL1gLC7q37DJ&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script> 


<script>
    paypal.Buttons({
        style: {
            shape: 'rect',
            color: 'gold',
            layout: 'vertical',
            label: 'subscribe'
        },
        createSubscription: function (data, actions) {
            return actions.subscription.create({
                "plan_id": 'P-3PR43976P2353894LMCC36RA', // basic
//                "plan_id": 'P-2P6843712N5519605MCC37SQ', // pro
                "subscriber": {
                    "name": {
                        "given_name": "Arel",
                        "surname": "Gindos"
                    }
                }
            });
        },
        onApprove: function (data, actions) {
            $.ajax({
                type: "POST",
                url: "http://localhost:8000/api/v1/subscriptions/subscribeToPaypal",
                data: data,
//                dataType: dataType,
                success: function (data) {
                    toastr.success('Text Copied!')
                    console.log(data);
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback 
                    $('p').append('Error: ' + errorMessage);
                }
            });

        }
    }).render('#paypal-button-container'); // Renders the PayPal button
</script>