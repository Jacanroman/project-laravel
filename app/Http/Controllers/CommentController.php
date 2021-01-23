<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Importamos el modelo de commentario
use App\Comment;

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
        
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Asigno los valores a mi nuevo objeto a guardar
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardar en la bd;
        $comment->save();

        //Redireccion
        return redirect()->route('image.detail',['id'=>$image_id])
                            ->with([
                                "message" => 'Has publicado tu comentario correctamente'
                            ]);
        
    }
}
