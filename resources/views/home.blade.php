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

    <div class="container my-5 " style=" max-height: 400px; ">
            <div class="row px-5 py-5 flex items-stretch">
                
                <div class="col-md-5">

            
                    <div class="demo_product card shadow-md p-3 mb-5 bg-body rounded row" style="width: auto;">
                        <img src="{{ asset('images/logo_laravel.png')}}" class="card-img-top" height="400px" width="auto" alt="...">
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
                        <div class=" formuaire_payement mx-4" >
                        <form  action="{{route('payement.store')}}" method="post" id="payment-form">
                                @csrf
                                
                                <input type="number" id="data_stock_somme_qte" name="qte" value="0" hidden/>
                                <input type="number" id="data_stock_somme_montant"  name="montant" value="0" hidden/>

                                <div class="form-group">
                                    <input type="text" class="  form-control" name="name" id="card-name-user" placeholder="Nom du titulaire de la carte">
                                </div>
                                <div class="form-group">
                                    <div id="card-element" class="form-control"> </div>
                                </div> 

                                 <div id="card-errors" role="alert"></div> 

                                 <input type="text" name="payement_method" class="  form-control" id="payement_method" hidden>
                                <input type="hidden" id="stripe_key" name="stripe_id" value="{{ env('STRIPE_PUBLIC_KEY) }}"/>
                                <button type="submit" class="btn formuaire_payement" id="submit-payed" style="background-color: #ea580c; color:white;">PAYER</button> 
                            </form>

                </div>

                </div>

               
    </div>
    </div>
</div>
<div class="mt-5"></div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="https://js.stripe.com/v3"></script>
<script type="text/javascript">

  /*=================================================*/
 const stripe=  Stripe("{{ env('STRIPE_PUBLIC_KEY') }}");
    const elements = stripe.elements();
    const cardElements = elements.create('card',{
        classes:{
            base : 'StripeElement bg-white w-1/2 p-2 my-2 rounded-lg'
        }
    });

    cardElements.mount('#card-element');
    const cardButton = document.getElementById("submit-payed");
    const cardHolderName = document.getElementById('card-name-user');

    cardButton.addEventListener('click',async(e) =>{
        e.preventDefault();

        const { paymentMethod, error } = await stripe.createPaymentMethod('card', cardElement);
    
        if (error) {
            alert("error");
            // Display "error.message" to the user...
        } else {
            // The card has been verified successfully...
            document.getElementById("payement_method").value = paymentMethod.id;
        }
        document.getElementById("payement_method").value = paymentMethod.id;
        document.getElementById("form").submit();
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
