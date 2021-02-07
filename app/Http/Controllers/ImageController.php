<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;


//añadir el Storage y el File
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

//utilizar el modelo de imagen
use App\Image;

//Cargar los modelos de Comentario y likes;
use App\Comment;
use App\Like;

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
    //$filename es una variable que me llegara por al url
    public function getImage($filename){
        //con el metodo disk seleccionamos la carpeta images
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    } 

    public function detail($id){
        $image = Image::find($id);

        return view('image.detail',[
            'image' => $image,
        ]);
    }

    //metodo para borrar imagenes
    public function delete($id){
        //conseguir objeto del usuario identificado.
        $user = \Auth::user();
        //conseguir el objeto de la imagen
        $image = Image::find($id);
        //Conseguir los comentarios y los likes asociados a la imagen
        //sacarlos para eliminarlos antes que eliminar la imagen.
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();


        //condicion para ver si es el dueno
        if($user && $image && $image->user->id == $user->id){
            //Eliminar comentarios
            if($comments && count($comments) >=1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }

            //Eliminar los likes
            if($likes && count($likes)>=1){
                foreach($likes as $like){
                    $like->delete();
                }
            }

            //Eliminar ficheros de imagen
            Storage::disk('images')->delete($image->image_path);

            //Eliminar el registro de la imagen
            $image->delete();
            $message = array('message'=>'La imagen se ha borrado correctamente');

        }else{
            $message = array('message'=>'La imagen no se ha borrado correctamente');
        }

        //redireccionamos
        return redirect()->route('home')->with($message);
    }

    //metodo para editar imagenes
    public function edit($id){
        
        //Conseguir el objeto del usuario identificado
        $user=\Auth::user();

        //Conseguir el objeto de la imagen  
        $image = Image::find($id);

        //Comprobar si existe user e imagen

        if($user && $image && $image->user->id == $user->id){

        //vista
            return view('image.edit', [
                'image' => $image 
            ]);
        
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){
        
         //Validacion
         $validate=$this->validate($request,[
            'description' => 'required',
            'image_path' => 'image' /*image valida que sea imagen*/  
            
        ]);

        //recogemos el id del imagen con el request
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //Conseguir objeto image
        $image = Image::find($image_id);
        $image->description = $description;

        //Subir fichero
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }


        //Actualizar registro
        $image->update();

        return redirect()->route('image.detail',['id'=>$image_id])
                            ->with(['message' => 'Imagen actualizada con existo']);


    }
}
