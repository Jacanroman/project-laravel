<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    //Restringimos el acceso con el middleware

    public function __construct(){
        $this->middleware('auth');
    }

    //Crear pantalla donde podremos subir nuevas imagenes

    public function create(){
        //cargamos la vista
        return view('image.create');
    }
}
