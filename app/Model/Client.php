<?php
namespace App\Model;

use DB;
use Jenssegers\Mongodb\Model as Eloquent;

class Client extends Eloquent {

    protected $collection = 'CLIENT';

    public function addClient($post){
        if($this->insert($post)){
            return true;
        }else{
            return false;
        }
    }
    public function getClientID($id){
        $rd = DB::collection($this->getTable())->where('_id', $id);
        return $rd->get();
    }
    public function getClient($name){
        $rd = DB::collection($this->getTable())->where('Name', $name);
        return $rd->get();
    }
    public function getAllClient(){
        $rd = DB::collection($this->getTable());
        return $rd->get();
    }
    public function editClient($post, $name){
        $rd = DB::collection($this->getTable())->where('Name', $name);
        $rd->update($post);
        return $rd->get();
    }
    public function removeClient($name){
        $rd = DB::collection($this->getTable())->where('Name', $name);
        $rd->delete();
        return $rd->get();
    }
    public function removeAllClient(){
        $rd = DB::collection($this->getTable());
        $rd->delete();
        return $rd->get();
    }
    public function addMovie($input,$name){
        $rd = DB::collection($this->getTable())->where('Name', $name);
        $rd->push('Details', $input);
        return $rd->get();
    }
}