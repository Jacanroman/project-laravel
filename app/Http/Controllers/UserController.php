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

    //accion que me permita recibir los datos del formulario
    //recibira una Request y un objeto de tipo request
    public function update(Request $request){
        //creamob variables y las rellenamos con los
        //datos del request
        $id = \Auth::user()->id;
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        var_dump($id);
        var_dump($name);
        var_dump($email);

        die();
    }
}
