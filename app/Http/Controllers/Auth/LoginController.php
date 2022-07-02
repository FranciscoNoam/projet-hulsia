<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


use Illuminate\Support\Facades\Auth;
use Socialite;
use App\User;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

  /*  public function redirectToGoogle()
    {
         //    return Socialite::driver('google')->redirect(); 
       
        $user = Socialite::driver('google')->user();
        dd($user);
        //  $user = User::where('google_id', auth()->user()->id)->first();
        if($user){
            return Socialite::driver('google')->redirect('/drive.index'); 
        } else{
            return Socialite::driver('google')->redirect('auth/google/callback'); 
        }
    }

    public function handleGoogleCallback()
    {
        dd("aty");
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                 return redirect('/drive.index');
            }else{
                DB::update("UPDATE users set google_id=?",[$user_id]);
                $newUser = User::where('google_id', $user->id)->first();
                Auth::login($newUser);
                return redirect()->back();
            }
        } catch (Exception $e) {
            return redirect('auth/google');
        } 
    } */

}
