@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }} ok
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> -->

<style>
.demo_product button{

    background-color:gray;
    color:white;
}
</style>
<div class=" bg-white mb-5">

    <div class="container my-5 mx-4" style=" max-height: auto; ">
            <div class="row px-5 py-5 flex items-stretch">

                <div class="col-md-5">


                    <div class="demo_product card shadow-md p-3 mb-5 bg-body rounded row" style="width: auto;">
                        <img src="{{ asset('images/logo_laravel.png')}}" class="card-img-top" height="300px" width="auto" alt="...">
                        <div class="card-body">
                            <h1 class="text-gray-900 font-bold text-2xl">Produit demo</h1>
                            <p class="mt-2 text-gray-600 text-sm">Product description demo</p>
                            <h5 class="text-gray-900 font-bold text-xl" > <span id="solde_product_init">12.5</span> €</h5>
                            <div>
                            <button type="button" value="1" id="decrementQte" class="btn btn-dark px-3 py-1 bg-gray w-36 text-white text-md font-bold uppercase rounded focus:ring focus:ring-gray-300 focus:outline-none active:bg-gray-900 ">
                                -
                            </button>
                            <button type="button" value="1"  id="ajoutQte" class="btn btn-dark px-3 py-1 bg-gray w-36 text-white text-md font-bold uppercase rounded focus:ring focus:ring-gray-300 focus:outline-none active:bg-gray-900 ">
                            +
                            </button>
                            <input type="number" id="data_montant_init" value="12.5" hidden/>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mx-4  font-bold text-xl">
                                <span class="text-gray-900">Quantité:</span>  <span id="totale_qte">0</span>  €
                                </h4>
                                <h4 class="mx-4  font-bold text-xl">
                                    <span class="text-gray-900">Total:</span> <span id="totale_montant">0</span>  €
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <div align="right" class="mx-4">
                                <button type="button" id="payement_submit"  class="btn btn-success">PROCEDER AU PAIMENT</button>
                                </div>

                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <h6 class="mx-4  font-bold text-xl">
                                    <span class="text-gray-900" id="text_payement_id"></span>  
                                </h6>
                                <h6 class="mx-4  font-bold text-xl">
                                    <span class="text-gray-900" id="text_status"></span>  
                                </h6>
                                <h6 class="mx-4  font-bold text-xl">
                                    <span class="text-gray-900" id="text_carte_type"></span>  
                                </h6>
                            </div>
                            <div class="col-md-6">
                              
                            </div>
                        </div>
                        <div class=" formuaire_payement mx-4" >
                        {{-- <form role="form"  action="{{route('payement.store')}}" method="post" id="payment-form"
                        data-cc-on-file="false" > --}}
                        <form role="form"  class="require-validation" id="payment-form" data-cc-on-file="false" >
                                @csrf

                                <input type="number" id="data_stock_somme_qte" name="qte" value="0" hidden/>
                                <input type="number" id="data_stock_somme_montant"  name="montant_total" value="0" hidden/>

                                <input type='hidden' id="payement_id" name='payement_id' require/>
                                <input type='hidden' id="carte_type" name='carte_type' require/>

                                <div class="form-group">
                                    <input type="text" class="  form-control" name="name" id="card-holder-name" placeholder="Nom du titulaire de la carte">
                                </div>

                                 <div class="form-group">
                                     <input type="text" require name="card-number"  class="  card-number form-control" id="card-number" size="16" placeholder="Numéro de la carte">
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                         <input type="text" require name="card-expiry-month" maxlength="2" pattern="[0-9]{2}" class=" card-expiry-month form-control" id="card-expiry-month" size="2" placeholder="Mois">
                                    </div>
                                    <div class="col-md-4">
                                         <input type="text" require name="card-expiry-year"  maxlength="2" pattern="[0-9]{4}" class="card-expiry-year  form-control" id="card-expiry-year" size="4" placeholder="Année">
                                    </div>
                                    <div class="col-md-4">
                                         <input type="text" require name="card-cvc" maxlength="3" pattern="[0-9]{3}" class=" card-cvc  form-control" id="card-cvc" size="4" placeholder="CVC">
                                    </div>
                                </div>
                                <div id="card-errors" role="alert"></div>
                                <div id="submit_botton">
                                    <button id="card-button" type="button" class=" mt-3 btn formuaire_payement" style="background-color: #ea580c; color:white;">PAYER</button>
                                </div>

                            </form>

                </div>

                </div>


    </div>
    </div>
</div>
<div class="mt-5"></div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function() {
    var StripeKey = "{{ config('services.stripe.public') }}";
    Stripe.setPublishableKey(StripeKey);
          
    var $form = $(".require-validation");
    $('#card-button').bind('click', function(e) {
       
        if (!$form.data('cc-on-file')) {
             e.preventDefault();
            Stripe.createToken({
                number: $('#card-number').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#card-expiry-month').val(),
                exp_year: $('#card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });

    function stripeResponseHandler(status, response) {
        var payement_id = document.getElementById("payement_id");
        var carte_type = document.getElementById("carte_type");
        if (response.error) {
            $('.stripe-error').text(response.error.message);
        } else {
            payement_id.value = response.id;
            carte_type.value = response.card.brand;
            var token = response.id;
            $('#payment-form').find('input[type=text]').empty();
            $('#payment-form').append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            // $('#payment-form').submit();
        const  tmp= {
            payement_id: token
            , carte_type: carte_type
            , montant_total: $("#data_stock_somme_montant").val()
            ,qte: $("#data_stock_somme_qte").val()
            ,name: $("#card-holder-name").val()
        };

            $.ajax({
                url: "{{route('payement.store')}}"
                , type: 'POST'
                , data: tmp
                , success: function(response) {
                    alert(JSON.stringify(response));
                    if(response.status_json!=null){
                        document.getElementById("text_carte_type").innerHTML="Carte Type: "+response.carte_type_json;
                        document.getElementById("text_status").innerHTML="Status: "+response.status_json;
                        document.getElementById("text_payement_id").innerHTML="Payement ID: "+response.payement_id_json;
                    }
                }
                , error: function(error) {
                    document.getElementById("text_error").innerHTML="Error chargement: "+error.error_json;
                    console.log(JSON.stringify(error.error_json));
                    alert(error.error_json);
                }
            }); 
        }
    }

});

    /*=================================================*/
      $(document).ready(function() {
           $('.formuaire_payement').css('display', 'blnoneck');
         $('#payement_submit').css('display', 'none');
                 if(Number($("#data_stock_somme_montant").val())>1){
                    $('#payement_submit').css('display', 'block');
                 }
    });


    $(document).on('click', '#payement_submit', function() {
        $('#payement_submit').css('display', 'none');
        $('.formuaire_payement').css('display', 'block');
     });
/*=================================================*/
    $(document).on('click', '#decrementQte', function() {
        var montant_init = $("#data_montant_init").val();
        var data_stock_somme_montant = Number($("#data_stock_somme_montant").val());
        var data_stock_somme_qte = Number($("#data_stock_somme_qte").val());
        var reste_qte = 0;
        var total_montant = 0;
        if(data_stock_somme_qte>1){
             reste_qte = data_stock_somme_qte  - Number($("#decrementQte").val());
        }
        total_montant = (reste_qte*montant_init);

        if(data_stock_somme_qte<1){
            $('#payement_submit').css('display', 'none');
        }
         $("#data_stock_somme_qte").val(reste_qte);
         $("#data_stock_somme_montant").val(total_montant);
        document.getElementById("totale_qte").innerHTML = reste_qte;
        document.getElementById("totale_montant").innerHTML = total_montant;

    });
/*=================================================*/
     $(document).on('click', '#ajoutQte', function() {
        var montant_init = $("#data_montant_init").val();
        var data_stock_somme_montant = Number($("#data_stock_somme_montant").val());
        var data_stock_somme_qte = Number($("#data_stock_somme_qte").val());

        var reste_qte = Number(document.getElementById("totale_qte").innerHTML);
        var total_montant = 0;

        if(data_stock_somme_qte<1){
            $('#payement_submit').css('display', 'none');
        }
        $('#payement_submit').css('display', 'block');
         reste_qte = data_stock_somme_qte  + Number($("#ajoutQte").val());
         total_montant = (reste_qte*montant_init);

        $("#data_stock_somme_qte").val(reste_qte);
        $("#data_stock_somme_montant").val(total_montant);

        document.getElementById("totale_qte").innerHTML = reste_qte;
        document.getElementById("totale_montant").innerHTML = total_montant;

    });


</script>
@endsection
