<?php
namespace App\Model;

use DB;
use Jenssegers\Mongodb\Model as Eloquent;

class DVD extends Eloquent {

    protected $collection = 'DVD';

    public function addMovie($post){
        if($this->insert($post)){
            return true;
        }else{
            return false;
        }
    }
    public function getMovieID($id){
        $rd = DB::collection($this->getTable())->where('_id', $id);
        return $rd->get();
    }
    public function getMovie($name){
        $rd = DB::collection($this->getTable())->where('Name', $name);
        return $rd->get();
    }
    public function getAllMovie(){
        $rd = DB::collection($this->getTable());
        return $rd->get();
    }
    public function editMovie($post, $name){
        $rd = DB::collection($this->getTable())->where('Name', $name);
        $rd->update($post);
        return $rd->get();
    }
    public function removeMovie($name){
        $rd = DB::collection($this->getTable())->where('Name', $name);
        $rd->delete();
        return $rd->get();
    }
    public function removeAllMovie(){
        $rd = DB::collection($this->getTable());
        $rd->delete();
        return $rd->get();
    }
}