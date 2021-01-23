<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    //Restringimos el acceso con el middleware

    public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){

        //Validamos los datos que nos pasan por el formulario

        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required',
        ]);

        //Recogemos los datos del formulario el id y el comentario

        $image_id = $request->input('image_id');
        $content = $request->input('content');

        
    }
}
