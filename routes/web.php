<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Para utilizar las clases hay que hacer un use de esa clase
//use App\Image;

Route::get('/', function () {

    /*
    //conseguir todas las images
    $images = Image::all();
    foreach($images as $image){
        //var_dump($image);
        echo $image->image_path."<br/>";
        echo $image->description."<br/>";
        echo $image->user->name.' '.$image->user->surname;

        echo '<h4>Comentarios</h4>';
        foreach($image->comments as $comment){
            echo $comment->user->name.' '.$comment->user->surname.':';
            echo $comment->content.'<br/>';
        }

        echo 'LIKES: '.count($image->likes);
        echo "<hr/>";
        
    }
    die();
    */

    
    return view('welcome');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Creamos la ruta de la configuracion de usuario
la llamaremos configuracion
cargamos el controlador UserController y el metodo config
el name de la ruta config*/
Route::get('/configuracion', 'UserController@config')

