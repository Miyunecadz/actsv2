<?php namespace App\Services;

use Illuminate\Support\Facades\Auth;

class LoginService{
    public function attempt($username,$password)
    {
        $credentials=[
            'username'=>$username,
            'password'=>$password
        ];
    
        return Auth::attempt($credentials);
    }
}