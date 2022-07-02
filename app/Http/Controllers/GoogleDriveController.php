<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


use IlluminateFoundationAuthAuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\User;
use Illuminate\Support\Facades\DB;
class GoogleDriveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function redirectToGoogle()
    {
         //    return Socialite::driver('google')->redirect(); 
        //   $user = User::where('google_id', auth()->user()->id)->first();
        
       return Socialite::driver('google')->redirect(); 
        dd($user);
         if($user){
            return redirect('/drive.index'); 
            // return Socialite::driver('google')->redirect('/drive.index'); 
        } else{
           return  redirect(['auth/google/callback']); 
            // return Socialite::driver("config('google')")->redirect(['auth/google/callback']); 
        }
    }

    public function handleGoogleCallback()
    {
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
    } 

    public function index()
    {
        $contents = collect(Storage::cloud()->listContents('/', false));
         //parcourir sous dossier:facture par exemple
      /*  foreach ($contents as $key => $value) {
            if($value['name'] == $folder_parent)
                 $root = $value['path'];
        } */
               // Get the files inside the folder...
        //        $files = collect(Storage::cloud()->listContents('/', false))
        //        ->where('type', '=', 'file');
        //    return $files;
    
           dd($contents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
