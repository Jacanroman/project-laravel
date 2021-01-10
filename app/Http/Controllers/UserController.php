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

        $id = \Auth::user()->id;

        //validamos los datos
        // unique:users significa que sea unico en la tabla usuarios
        // nick'.$id la excepcion es cuando el nick coincide con
        //el nick del usuario con el id
        
        $validate = $this->validate($request, [
            'name'=>'required|string|max:255',
            'surname'=>'required|string|max:255',
            'nick'=>'required|string|max:255|unique:users,nick,'.$id,
            'email'=>'required|string|email|max:255|unique:users,email,'.$id,
        ]);

        //creamob variables y las rellenamos con los
        //datos del request
        
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        /*
        var_dump($id);
        var_dump($name);
        var_dump($email);
        die();
        */
    }
}
