<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/plans', 'PlanController@index')->name('plans.index');
});


//===== API STRIPE
Route::resource('payement', 'PayementController');
Route::post('payement.create2', 'PayementController@create2')->name('payement.create2');
Route::post('payement.create', 'PayementController@create')->name('payement.create');
Route::post('payement.pay', 'PayementController@pay')->name('payement.pay');


// ========API GOOGLE DRIVE
Route::resource('drive', 'GoogleDriveController');

Route::get('google', function () {    return view('connect_google_drive'); });
Route::get('auth/google', 'GoogleDriveController@redirectToGoogle');
Route::get('auth/google/callback', 'GoogleDriveController@handleGoogleCallback');

Route::get('home.connectDrive', 'HomeController@index2')->name('home.connectDrive');
Route::post('payement.googleDrive', 'PayementController@googleDrive')->name('payement.googleDrive');



