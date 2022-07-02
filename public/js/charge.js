Stripe.setPublishableKey('pk_test_51LFkkOAdvPjI3wT4cjmDFQ6htHeLcJkbenp1awgMd7VZ88v3rsYDFqjBq1paKQN0YyQ8P5B7p8q20EH0JCYlkqxQ002oOiICOT');

var $form = $('#payment-form');

$form.submit(function (event) {
    $('#checkout-error').addClass('hidden');
    $form.find('button').prop('disabled', true);
    Stripe.card.createToken({
        number: $('#card-number').val(),
        cvc: $('#card-cvc').val(),
        exp_month: $('#card-expiry-month').val(),
        exp_year: $('#card-expiry-year').val(),
        name: $('#card-name').val()
    }, stripeResponseHandler);
    return false;
});

function stripeResponseHandler(status, response) {
    if(response.error) {
        $('#checkout-error').removeClass('hidden');
        $('#checkout-error').text(response.error.message);
        $form.find('button').prop('disabled', false);
    } else {
        var token = response.id;
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        $form.get(0).submit();
    }
}

