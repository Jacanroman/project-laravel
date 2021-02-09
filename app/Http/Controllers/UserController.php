<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller
{
    //En el constructor llamaremos al middleware de autenticacion
    //para moderar el contenido segun autenticacion
    public function __construc(){
        $this->middleware('auth');
    }

    public function index($search=null){

        if(!empty($search)){
            $users = User::where('nick', 'LIKE', '%'.$search.'%')
                            ->orWhere('name', 'LIKE', '%'.$search.'%')
                            ->orwhere('surname', 'LIKE', '%'.$search.'%')
                            ->orderBy('id','desc')
                            ->paginate(5);
        }else{
            $users = User::orderBy('id','desc')->paginate(5);
        }

        

        //vista
        return view('user.index',['users'=>$users]);
    }

    //
    public function config(){

        //vista
        return view('user.config');
    }

    //accion que me permita recibir los datos del formulario
    //recibira una Request y un objeto de tipo request
    public function update(Request $request){

        

        //CONSEGUIR USUARIO IDENTIFICADO
        $user = \Auth::user();
        $id = $user->id;

        //VALIDACION DEL FORMULARIO
        // unique:users significa que sea unico en la tabla usuarios
        // nick'.$id la excepcion es cuando el nick coincide con
        //el nick del usuario con el id

        $validate = $this->validate($request, [
            'name'=>'required|string|max:255',
            'surname'=>'required|string|max:255',
            'nick'=>'required|string|max:255|unique:users,nick,'.$id,
            'email'=>'required|string|email|max:255|unique:users,email,'.$id,
        ]);

        
        //RECOGER DATOS DEL FORMULARIO
        //creamob variables y las rellenamos con los datos del request
        
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

        //ASIGNAR NUEVOS VALORES AL OBJETO DE USUARIO
        /*como son propiedades publicas le podemos 
        asignar directamente el valor que tiene  */    
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;


        //SUBIR LA IMAGEN
        $image_path = $request->file('image_path');
        /*
        var_dump($image_path);
        die();

        Si es un objeto, utilizamos el storage y utilizamos el disco users 
        para guardar la imagen dentro de users
        */
        if($image_path){
            //Poner nombre unico
            $image_path_name = time().$image_path->getClientOriginalName();

            //Guardarla en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            //Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        

        //EJECUTAR CONSULTA Y CAMBIO EN LA BASE DE DATOS
        $user->update();

        return redirect()->route('config')
                        ->with(['message'=>'Usuario actualizado correctamente']);
    }


    public function getImagen($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file,200);
    }

    public function profile($id){
        $user = User::find($id);

        //Vista
        return view('user.profile', [
            'user' => $user
        ]);
    }

   
}
