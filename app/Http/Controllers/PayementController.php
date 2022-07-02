<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Plan;
use Session;
use Stripe;
use App\User;
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
       
    }



    public function store(Request $request)
    {
       $user = auth()->user();
        Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $some_montant = $request->montant_total*100;
      
     try {
        Stripe\Charge::create([
            "amount" => $some_montant,
            "currency" => "usd",
            "source" => $request->payement_id,
            "description" => "Test Charges"
         ]);

         DB::update("UPDATE users set stripe_id=?",[$request->payement_id]);
        //    $user::find(1);
       //    DB::insert("INSERT INTO subscriptions(user_id,name,stripe_id,stripe_plan,quantity,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW()");
           $val=[
               $request->nom,$request->payement_id,"",$some_montant
           ];
           DB::insert("INSERT INTO plans(name,slug,stripe_plan,cost,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW())",$val);
           DB::commit();
       } catch (\Exception $e) {
          $data2=[
            "error_json" =>$e->getMessage()
             ];
        return response()->json($data2);
       }
        $data=[
                "payement_id_json" =>$request->payement_id,
                "status_json" =>"payement terminé avec success!",
                "carte_type_json" =>$request->carte_type
            ];
        // return response()->json($data);
        return view("stripe",compact('data'));
    }


    /*
     public function store(Request $request)
    {
       $user = auth()->user();
        Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $some_montant = $request->montant_total*100;
      
     try {
        Stripe\Charge::create([
            "amount" => $some_montant,
            "currency" => "usd",
            "source" => $request->payement_id,
            "description" => "Test Charges"
         ]);

         DB::update("UPDATE users set stripe_id=?",[$request->payement_id]);
        //    $user::find(1);
       //    DB::insert("INSERT INTO subscriptions(user_id,name,stripe_id,stripe_plan,quantity,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW()");
           $val=[
               $request->nom,$request->payement_id,"",$some_montant
           ];
           DB::insert("INSERT INTO plans(name,slug,stripe_plan,cost,created_at,updated_at) VALUES(?,?,?,?,NOW(),NOW())",$val);
           DB::commit();
       } catch (\Exception $e) {
        //   dd( $e->getMessage());
          $data2=[
            "error_json" =>$e->getMessage()
        ];
        return response()->json($data2);
       }
        $data=[
                "payement_id_json" =>$request->payement_id,
                "status_json" =>"payement terminé avec success!",
                "carte_type_json" =>$request->carte_type
            ];
        return response()->json($data);
    }
    */
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
