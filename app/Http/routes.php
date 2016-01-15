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

Route::post	  ('/Client'				   , 'dvdController@C_AddClient' 	   ); // Add new client
Route::get	  ('/Client'				   , 'dvdController@C_GetAllClient'    ); // Get all Client
Route::post	  ('/Movie'					   , 'dvdController@C_AddMovie' 	   ); // Add new movie
Route::get	  ('/Movie'					   , 'dvdController@C_GetAllMovie' 	   ); // Get All movie
Route::get	  ('/Client/{name}/Name'       , 'dvdController@C_GetClient' 	   ); // Get specific client data
Route::get	  ('/Movie/{name}/Name'		   , 'dvdController@C_GetMovie' 	   ); // Get specific movie data
Route::delete ('/Client/{name}/Delete'	   , 'dvdController@C_RemoveClient'    ); // Remove specific client
Route::delete ('/Client/Delete'			   , 'dvdController@C_RemoveAllClient' ); // Remove all client(s)
Route::delete ('/Movie/{name}/Delete'	   , 'dvdController@C_RemoveMovie' 	   ); // Remove specific movie
Route::delete ('/Movie/Delete'			   , 'dvdController@C_RemoveAllMovie'  ); // Remove all movie(s)
Route::post   ('/Rental'                   , 'dvdController@C_Rental' 		   ); // Rent a movie
Route::put    ('/Return/{name}/{movieName}', 'dvdController@C_Return'          ); // Return a movie