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
                return response(['status'=>'Please insert Name']);
            }

        }else{

            $client = new Client();
            $post   = $request->all();

            //remove csrf token
            if(array_key_exists('_token', $post)){
                unset($post['_token']);
            }

            $client->addClient($post);
            return response(['status'=>'success']);

        }
    }

    // This function to get client data
    public function C_GetClient($name){

        $client = new Client();
        $data   = $client->getClient($name);

        if(isset ($data[0])){
            return response($data);
        }else{
            return response(['status'=>'Client not found']);
        }

    }

    // This function to get all client data
    public function C_GetAllClient(){

        $movie = new Client();
        $data  = $movie->getAllClient();

        if(isset ($data[0])){
            return response($data);
        }else{
            return response(['status'=>'Client not found']);
        }

    }

    // This function to remove client data
    public function C_RemoveClient($name){

        $client = new Client();
        $data = $client->getClient($name);

        if(isset($data[0])){
            $client->removeClient($name);
            return response(['status'=>'success']);
        }else{
            return response(['status'=>'Client not found']);
        }

    }

    // This function to remove all client
    public function C_RemoveAllClient(){

        $client = new Client();
        $data = $client->getAllClient();

        if(isset($data[0])){
            $client->removeAllClient();
            return response(['status'=>'success']);
        }else{
            return response(['status'=>'Client not found']);
        }

    }

    // This function to add movie to store
    public function C_AddMovie(Request $request){

        $check = Validator::make($request->all(), ['Name' => 'required', 'Type' => 'required', 'Status' => 'required']);

        if($check->fails()){

            if(!($request->has('Name'))){

                return response(['status'=>'Please insert Name']);

            }elseif(!($request->has('Type'))){

                return response(['status'=>'Please insert DVD Type']);

            }

        }else{

            $movie = new DVD();
            $post   = $request->all();

            //remove csrf token
            if(array_key_exists('_token', $post)){
                unset($post['_token']);
            }

            $movie->addMovie($post);
            return response(['status'=>'success']);

        }
    }

    // This function to get movie data
    public function C_GetMovie($name){

        $movie = new DVD();
        $data  = $movie->getMovie($name);

        if(isset ($data[0])){
            return response($data);
        }else{
            return response(['status'=>'Movie not found']);
        }

    }


    // This function to get all movie data
    public function C_GetAllMovie(){

        $movie = new DVD();
        $data  = $movie->getAllMovie();

        if(isset ($data[0])){
            return response($data);
        }else{
            return response(['status'=>'Movie not found']);
        }

    }

    // This function to remove movie data
    public function C_RemoveMovie($name){

        $movie = new DVD();
        $data = $movie->getMovie($name);

        if(isset($data[0])){
            $movie->removeMovie($name);
            return response(['status'=>'success']);
        }else{
            return response(['status'=>'Movie not found']);
        }

    }

    // This function to remove all movie
    public function C_RemoveAllMovie(){

        $movie = new DVD();
        $data = $movie->getAllMovie();

        if(isset($data[0])){
            $movie->removeAllMovie();
            return response(['status'=>'success']);
        }else{
            return response(['status'=>'Movie not found']);
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
                if($clientStatus == 'Rental'){

                    return response(['status'=>'Client can rent only one movie']);

                 // Otherwise, proceed rental:
                }else{

                    // Set input data to client details
                    $input = ['Movie'=>$movieName] + ['Status' => 'Rental'] + ['Date' => $time->format('Y-m-d H:i:s')];

                    // Add rental to client collection
                    $return = $client->addMovie($input, $name);

                    // If client edit successfully:
                    if(isset($return[0])) {
                        response(['status' => 'success']);
                    }else{
                        return response(['status'=>'Cannot add Client details']);
                    }

                    // Edit movie status to unavailable
                    $return = $movie->editMovie(['Status'=>'NO'], $movieName);

                    // If movie edit successfully:
                    if(isset($return[0])) {
                        response(['status' => 'success']);
                    }else{
                        return response(['status'=>'Cannot edit Movie']);
                    }

                }

             // Otherwise, movie is unavailable:
            }elseif($movieStatus == 'NO'){
                return response(['status'=>'Movie unavailable']);

             // Invalid status:
            }else{
                return response(['status'=>'Movie status invalid']);
            }

         // Otherwise, return failure of client or movie is not found:
        }else{
            return response(['status'=>'Client or Movie not found']);
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
            if(($recentStatus == 'Rental') && ($recentMovie == $movieName)) {

                // Set input data to client details
                $input = ['Movie' => $movieName] + ['Status' => 'Return'] + ['Date' => $time->format('Y-m-d H:i:s')];

                // Add rental to client collection
                $return = $client->addMovie($input, $name);

                // If client edit successfully:
                if (isset($return[0])) {
                    response(['status' => 'success']);
                } else {
                    return response(['status' => 'Cannot add Client details']);
                }

                // Edit movie status to unavailable
                $return = $movie->editMovie(['Status' => 'YES'], $movieName);

                // If movie edit successfully:
                if (isset($return[0])) {
                    response(['status' => 'success']);
                } else {
                    return response(['status' => 'Cannot edit Movie']);
                }

                // Otherwise, most recent of client's details are incorrect:
            }else{
                return response(['status'=>'Details incorrect']);
            }

            // Otherwise, return failure of client or movie is not found:
        }else{
            return response(['status'=>'Client or Movie not found']);
        }

    }

}
