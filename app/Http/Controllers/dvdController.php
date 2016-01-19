<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Client;
use App\Model\DVD;
use Validator;
use DB;
use DateTime;
class dvdController extends Controller
{

    // Function to add all Shop's client
    public function C_AddClient(Request $request){

        $check = Validator::make($request->all(), ['Name' => 'required']);

        // If request detail incomplete:
        if($check->fails()){

            if(!($request->has('Name'))){
                return response()->json(['status'=>'Please insert Name'], 403);
            }

        }else{

            $client = new Client();
            $post   = $request->all();

            //remove csrf token
            if(array_key_exists('_token', $post)){
                unset($post['_token']);
            }

            if($client->addClient($post)){
                return response()->json(['status'=>'success'], 201);
            }else{
                return response()->json(['status'=>'Failed to add client'], 404);
            }

        }
    }

    // This function to get client data
    public function C_GetClient($name){

        $client = new Client();
        $data   = $client->getClient($name);

        if(isset ($data[0])){
            return response($data, 200);
        }else{
            return response()->json(['status'=>'Client not found'], 404);
        }

    }

    // This function to get all client data
    public function C_GetAllClient(){

        $movie = new Client();
        $data  = $movie->getAllClient();

        if(isset ($data[0])){
            return response($data, 200);
        }else{
            return response()->json(['status'=>'Client not found'], 404);
        }

    }

    // This function to remove client data
    public function C_RemoveClient($name){

        $client = new Client();

        if($client->removeClient($name)){
            return response()->json(['status'=>'success'], 200);
        }else{
            return response()->json(['status'=>'Client not found'], 404);
        }

    }

    // This function to remove all client
    public function C_RemoveAllClient(){

        $client = new Client();

        if($client->removeClient($name)){
            return response()->json(['status'=>'success'], 200);
        }else{
            return response()->json(['status'=>'Client not found'], 404);
        }

    }

    // This function to add movie to store
    public function C_AddMovie(Request $request){

        $check = Validator::make($request->all(), ['Name' => 'required', 'Type' => 'required', 'Status' => 'required']);

        if($check->fails()){

            if(!($request->has('Name'))){
                return response()->json(['status'=>'Please insert Name'], 403);
            }elseif(!($request->has('Type'))){
                return response()->json(['status'=>'Please insert DVD Type'], 403);
            }

        }else{

            $movie = new DVD();
            $post   = $request->all();

            //remove csrf token
            if(array_key_exists('_token', $post)){
                unset($post['_token']);
            }

            if($movie->addMovie($post)){
                return response()->json(['status'=>'success'], 201);
            }else{
                return response()->json(['status'=>'Failed to add movie'], 404);
            }

        }
    }

    // This function to get movie data
    public function C_GetMovie($name){

        $movie = new DVD();
        $data  = $movie->getMovie($name);

        if(isset ($data[0])){
            return response($data, 200);
        }else{
            return response()->json(['status'=>'Movie not found'], 404);
        }

    }

    // This function to get all movie data
    public function C_GetAllMovie(){

        $movie = new DVD();
        $data  = $movie->getAllMovie();

        if(isset ($data[0])){
            return response($data, 200);
        }else{
            return response()->json(['status'=>'Movie not found'], 404);
        }

    }

    // This function to remove movie data
    public function C_RemoveMovie($name){

        $movie = new DVD();

        if($movie->removeMovie($name)){
            return response()->json(['status'=>'success'], 200);
        }else{
            return response()->json(['status'=>'Movie not found'], 404);
        }

    }

    // This function to remove all movie
    public function C_RemoveAllMovie(){

        $movie = new DVD();

        if($movie->removeMovie($name)){
            return response()->json(['status'=>'success'], 200);
        }else{
            return response()->json(['status'=>'Movie not found'], 404);
        }

    }

    // This function to rent the movie from post request data
    public function C_Rental(Request $request){

        $client = new Client();
        $movie  = new DVD();
        $time   = new DateTime();

        // Post request from specific input
        $name      = $request->input('Name');
        $movieName = $request->input('Movie');

        // Get data from specific input
        $clientData = $client->getClient($name);
        $movieData  = $movie->getMovie($movieName);

        // If selected client and movie is reachable:
        if((isset($clientData[0])) && (isset($movieData[0]))){

            $movieStatus  = $movieData[0]['Status'];

            // If there is available Details key:
            if(isset($clientData[0]['Details'])){

                // Get most recent status
                $clientStatus = last($clientData[0]['Details'])['Status'];

            }else{

                // Define None for unavailable key
                $clientStatus = 'None';

            }

            // If movie is available:
            if($movieStatus == 'YES'){

                // If client already rent movie:
                if($clientStatus == 'Rented'){

                    return response()->json(['status'=>'Client can rent only one movie'], 403);

                    // Otherwise, proceed rental:
                }else{

                    // Set input data to client details
                    $input = ['Movie'=>$movieName] + ['Status' => 'Rented'] + ['Date' => $time->format('Y-m-d H:i:s')];

                    // Add rental to client collection

                    // If client edit successfully:
                    if($client->addMovie($input, $name)) {

                        response()->json(['status'=>'success'], 201);

                        // Edit movie status to unavailable

                        // If movie edit successfully:
                        if($movie->editMovie(['Status'=>'NO'], $movieName)) {
                            return response()->json(['status'=>'success'], 200);
                        }else{
                            return response()->json(['status'=>'Failed to edit movie'], 404);
                        }

                    }else{
                        return response()->json(['status'=>'Failed to add movie'], 404);
                    }

                }

             // Otherwise, movie is unavailable:
            }elseif($movieStatus == 'NO'){
                return response()->json(['status'=>'Movie unavailable'], 403);

                // Invalid status:
            }else{
                return response()->json(['status'=>'Movie status invalid'], 403);
            }

         // Otherwise, return failure of client or movie is not found:
        }else{
            return response()->json(['status'=>'Client or Movie not found'], 404);
        }

    }

    // This function to return rental movie
    public function C_Return($name, $movieName){

        $client = new Client();
        $movie  = new DVD();
        $time   = new DateTime();

        $clientData = $client->getClient($name);
        $movieData  = $movie->getMovie($movieName);

        // If selected client and movie is reachable:
        if((isset($clientData[0])) || (isset($movieData[0]))){

            $recentStatus = last($clientData[0]['Details'])['Status'];
            $recentMovie  = last($clientData[0]['Details'])['Movie'];

            // If correct rental status and movie at most recent detail:
            if(($recentStatus == 'Rented') && ($recentMovie == $movieName)) {

                // Set input data to client details
                $input = ['Movie' => $movieName] + ['Status' => 'Returned'] + ['Date' => $time->format('Y-m-d H:i:s')];

                // Add rental to client collection

                // If client edit successfully:
                if ($client->addMovie($input, $name)) {

                    response()->json(['status'=>'success'], 201);

                    // Edit movie status to available

                    // If movie edit successfully:
                    if ($movie->editMovie(['Status' => 'YES'], $movieName)) {
                        return response()->json(['status'=>'success'], 200);
                    }else{
                        return response()->json(['status'=>'Failed to edit movie'], 404);
                    }

                } else {
                    return response()->json(['status'=>'Failed to add movie'], 404);
                }

                // Otherwise, most recent of client's details are incorrect:
            }else{
                return response()->json(['status'=>'Details incorrect'], 403);
            }

            // Otherwise, return failure of client or movie is not found:
        }else{
            return response()->json(['status'=>'Client or Movie not found'], 404);
        }

    }

}
