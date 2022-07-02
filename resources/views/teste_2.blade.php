<!DOCTYPE html>

<html>

<head>

	<title>Laravel 5 - Stripe Payment Gateway Integration Example - ItSolutionStuff.com</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style type="text/css">

        .panel-title {

        display: inline;

        font-weight: bold;

        }

        .display-table {

            display: table;

        }

        .display-tr {

            display: table-row;

        }

        .display-td {

            display: table-cell;

            vertical-align: middle;

            width: 61%;

        }

    </style>

</head>

<body>

<div >

    <h1>Laravel 5 - Stripe Payment Gateway Integration Example <br/> ItSolutionStuff.com</h1>

    <div >

        <div >

            <div >

                <div  >

                    <div  >

                        <h3  >Payment Details</h3>

                        <div  >                            

                            <img  src="http://i76.imgup.net/accepted_c22e0.png">

                        </div>

                    </div>                    

                </div>

                <div >

                    @if (Session::has('success'))

                        <div >

                            <a href="#"  data-dismiss="alert" aria-label="close">×</a>

                            <p>{{ Session::get('success') }}</p>

                        </div>

                    @endif

                    <form role="form" action="{{ route('payement.create2') }}" method="post"  id="payment-form">
                        @csrf
                       <input type="text" id="card-holder-name">
                       <div id="card-element"></div>
                         <!-- ======================= plusieur payement  -->                         
                        <!-- <button id="card-button" data-secret="{{ $intent->client_secret }}">Payer</button> -->
                            <!-- ======================= single payement  -->
                            <button id="card-button">Payer</button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>        

        </div>

    </div>

</div>

</body>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
    //   const stripe = Stripe('stripe-public-key');
   
const stripe = Stripe("{{ config('services.stripe.public') }}");
const elements = stripe.elements();
const cardElement = elements.create('card');
cardElement.mount("#card-element");

const cardHolderName = document.getElementById('card-holder-name');
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', async (e) => {
   //=================== pour plusieur payement
   /* const {setupIntent, error} = await stripe.handleCardSetup(
        clientSecret, cardElement,{
            payement_method_data: {
                billing_details: { name: cardHolderName.value}
            }
        }
    );
     if(error){
        //error
        alert(JSON.stringify(error.message));
    } else {
     //   alert(JSON.stringify(setupIntent));
        // thr card has been verified successfully......
    }
     */
      //===================single payement
      const { paymentMethod, error } = await stripe.createPaymentMethod(
        'card', cardElement, {
            billing_details: { name: cardHolderName.value }
        }
    );
    if(error){
        //error
        alert(JSON.stringify(error.message));
    } else {
        alert(JSON.stringify(paymentMethod.id));
        // thr card has been verified successfully......
    }
    alert("paymentMethod: "+JSON.stringify(paymentMethod)+" id: "+paymentMethod.id);
       
 
});
</script>

</html>