<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

Route::post	  ('/clients'		           , 'dvdController@C_AddClient' 	   ); // Add new client
Route::get	  ('/clients'				   , 'dvdController@C_GetAllClient'    ); // Get all Client
Route::post	  ('/movies'				   , 'dvdController@C_AddMovie' 	   ); // Add new movie
Route::get	  ('/movies'				   , 'dvdController@C_GetAllMovie' 	   ); // Get All movie
Route::get	  ('/clients/{name}'           , 'dvdController@C_GetClient' 	   ); // Get specific client data
Route::get	  ('/movies/{name}'		       , 'dvdController@C_GetMovie' 	   ); // Get specific movie data
Route::delete ('/clients/{name}'	       , 'dvdController@C_RemoveClient'    ); // Remove specific client
Route::delete ('/clients'		           , 'dvdController@C_RemoveAllClient' ); // Remove all client(s)
Route::delete ('/movies/{name}'	           , 'dvdController@C_RemoveMovie' 	   ); // Remove specific movie
Route::delete ('/movies'		           , 'dvdController@C_RemoveAllMovie'  ); // Remove all movie(s)
Route::post   ('/rental'                   , 'dvdController@C_Rental' 		   ); // Rent a movie
Route::put    ('/return/{name}/{movieName}', 'dvdController@C_Return'          ); // Return a movie