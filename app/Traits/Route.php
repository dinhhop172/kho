<?php
namespace App\Traits;

trait Route{
    public function getListUserRoute(){
        return route('users.index');
    }
    public function getShowUserRoute($id){
        return route('users.show', ['id' => $id]);
    }
    public function getCreateUserRoute(){
        return route('users.create');
    }
    
}