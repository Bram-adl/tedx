<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index');
Route::get('/about', 'HomeController@about');
Route::get('/partners', 'HomeController@partners');
Route::get('/faqs', 'HomeController@faqs');
Route::get('/core/{name}/profile', 'HomeController@coreProfile');

Route::group(['middleware' => ['verified']], function () {
  Route::get('/ticket/presale-{number}', 'HomeController@ticket')->where(['number' => '[0-9]+']);
});

Route::group(['prefix' => '/member'], function () {
  Route::get('/verify/{token}', 'AuthController@verifyUser');
  Route::get('/confirm', 'AuthController@confirmEmail');
  Route::get('/resend/confirm', 'AuthController@resendConfirmEmail');
  
  Route::post('/register', 'AuthController@registerAudiencePost');
  Route::post('/register/core', 'AuthController@registerCorePost');
  Route::post('/register/volunteer', 'AuthController@registerVolunteerPost');
  Route::post('/login', 'AuthController@authenticate');
  Route::post('/logout', 'AuthController@logout');

  Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', 'AuthController@registerAudience');
    Route::get('/register/core', 'AuthController@registerCore');
    Route::get('/volunteer', 'AuthController@registerVolunteer');
    
    Route::get('/login', 'AuthController@login')->name('login');
  });
  
  Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'MemberController@dashboard');
  });
});
