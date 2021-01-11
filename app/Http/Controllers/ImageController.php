<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//añadir el Storage y el File
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

//utilizar el modelo de imagen
use App\Image;

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


    //Subir imagenes
    public function save(Request $request){
        
        //Validacion
        $validate=$this->validate($request,[
            'description' => 'required',
            'image_path' => 'required|image' /*image valida que sea imagen*/  
            
        ]);


        //Recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');
    
        //Asignar valores nuevo objeto

        //seteamos el id del usuario
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        
        $image->description = $description;

        //Subir fichero
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        //redireccionamos
        return redirect()->route('home')->with([
            'message' => 'La foto ha sido subida correctamente'
        ]);


    }
}
