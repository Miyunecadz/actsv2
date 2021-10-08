<?php namespace App\Repositories;

use App\Models\Business;

class BusinessRepository{
    
    public function create($data)
    {
        Business::create([
            'username'=>$data['username'],
            'password'=>$data['password'],
            'name'=>$data['name']
        ]);
    }
}