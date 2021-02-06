<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    //Middelware para restringir a usuario identificados
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        //recoger datos del usuario y la imagen
        $user = \Auth::user();

        $likes = Like::where('user_id', $user->id)->orderBy('id','desc')
                                ->paginate(5);


        //vista
        return view('like.index',[
            'likes'=> $likes
        ]);
    }

    public function like($image_id)
    {
        //recoger datos del usuario y la imagen
        $user = \Auth::user();


        //condicion para ver si existe el like y no duplicarlo
        $isset_like =Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->count();

        if($isset_like == 0){

            $like = new Like();
            $like->user_id = $user->id;
            //usamos (int porque en el objeto el image_id viene como string)
            $like->image_id = (int)$image_id;
    
            //Guarda en la base de datos
            $like->save();
    
            //devolver en Json

            return response()->json([
                'like' => $like
            ]);
        }else{
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }
       
    }

    public function dislike($image_id)
    {
        //recoger datos del usuario y la imagen
        $user = \Auth::user();


        //condicion para ver si existe el like y no duplicarlo
        $like =Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->first();

        if($like){
    
            //Eliminar en la base de datos
            $like->delete();
    
            //devolver en Json

            return response()->json([
                'like' => $like,
                'message' => 'Has dado dislike correctamente'
            ]);
        }else{
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }
    }

    
}
