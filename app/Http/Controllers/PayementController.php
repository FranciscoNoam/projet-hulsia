<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Plan;
use Session;

use Stripe;
use App\User;
use laravel\Cashier\PayementMethod;
class PayementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Plan $plan)
    {
        dd("payementMethod: ".$request->input());
         /*
      Payment intent ID : pi_3LGgj4AdvPjI3wT40hqIIBzj
Status : succeeded
Card type : visa
      */
        Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $user = auth()->user();
    //    $payementMethods = $user->payementMethods();
    //    $payementMethod = $user->defaultPayementMethod();
    $payementMethod = $user->payementMethods();

       dd("payementMethod: ".$payementMethod);
       if($user->hasPayementMethod()){
            $user->updateDefaultPayementMethod($payementMethod);
            $user->updateDefaultPayementMethodFromStripe();
            $user->addPayementMethod($payementMethod);
            // pour siprimer
            $payementMethod->delete();
            $user->deletePayementMehods();

            $user::find(1);
            $user->newSubscription('subscriptions','stripe_plan')->create($payementMethod,[
                "email" =>$user->email,
            ]);

           $payement =  $user->charge(100*100,$payementMethod);

            // rufunding
            dd("refund: ".$payement->id);
            $user->refund($payement->id);
        }



       if($user->hasIncompletePayement('subscriptions')){
            // incomplet main
            dd("$user->hasIncompletePayement('subscriptions')");
       }

       if($user->subscription('subscriptions')->hasIncompletePayement()){
          dd("$user->subscription('subscriptions')->hasIncompletePayement()");
        }
    }

    public function create2(Request $request, Plan $plan)
    {
        Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $user = auth()->user();


       if($request->payement_id){
        dd("tong");
         DB::update("UPDATE users set stripe_id=?",[$request->payement_id]);
         /*   $user->updateDefaultPayementMethod($request->payement_id);
            $user->updateDefaultPayementMethodFromStripe();
            $user->addPayementMethod($payementMethod);
            // pour siprimer
            $payementMethod->delete();
            $user->deletePayementMehods();
*/
            $user::find(1);
            DB::insert("INSERT INTO subscriptions(user_id,name,stripe_id,stripe_plann,quantity,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW()");
            $val=[
$request->nom,$request->payement_id,"",
            ];
                DB::insert("INSERT INTO plans(name,slug,stripe_plann,cost,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW()");

            DB::commit();

           $payement =  $user->charge(100*100,$payementMethod);

            // rufunding
            dd("refund: ".$payement->id);
            $user->refund($payement->id);
        }



       if($user->hasIncompletePayement('subscriptions')){
            // incomplet main
            dd("$user->hasIncompletePayement('subscriptions')");
       }

       if($user->subscription('subscriptions')->hasIncompletePayement()){
          dd("$user->subscription('subscriptions')->hasIncompletePayement()");
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

   /* public function pay(Request $request)
    {
        $auth_user = auth()->user();
        $some_montant = $request->montant*100;
       Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $token = $request->stripeToken;

        $val=[

        ]
        DB::insert("INSERT INTO plans(name,slug,stripe_plann,cost,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW()");
        DB::commit();

        $auth_user->charge($some_montant,$request->stripeToken);

        $charge = Stripe\Charge::create([
            "amount" =>$request->vola*100,
            "currency" =>"usd",
            "source" => $request->stripeToken,
            "description" => "test payement from onlineCode."
        ]);


        return 'Payment Success!';
    } */



    public function store(Request $request)
    {
       $auth_user = auth()->user();
        $some_montant = $request->montant*100;
       
        Stripe\Stripe::setApiKey(config('services.stripe.secret'));
      
     try {
        Stripe\Charge::create([
            "amount" => $some_montant,
            "currency" => "usd",
            "source" => $request->payement_id,
            "description" => "Test Charges"
         ]);
           DB::update("UPDATE users set stripe_id=?",[$request->payement_id]);
           $user::find(1);
       //    DB::insert("INSERT INTO subscriptions(user_id,name,stripe_id,stripe_plann,quantity,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW()");
           $val=[
               $request->nom,$request->payement_id,"",$some_montant
           ];
           DB::insert("INSERT INTO plans(name,slug,stripe_plann,cost,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW())",$val);
           DB::commit(); 
       } catch (\Exception $e) {
          dd( $e->getMessage());
       }
dd("vita");
       Session::flash('success', 'Payment successful!');

          

    //    return back();
    //    return redirect()->route('home')->with('success','Successfully purchased products!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
