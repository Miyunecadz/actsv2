<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if((new LoginService)->attempt($request->username,$request->password)){

            $request->session()->regenerate();

            return redirect(route('home'));
           
        }

        return redirect(route('login'))->withInput();
    
    }
}
