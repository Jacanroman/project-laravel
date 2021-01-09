<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function config(){

        //vista
        return view('user.config');
    }
}
