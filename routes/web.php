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


//GENERALES
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


//RUTAS USUARIOS
/*Creamos la ruta de la configuracion de usuario
la llamaremos configuracion
cargamos el controlador UserController y el metodo config
el name de la ruta config*/
Route::get('/configuracion', 'UserController@config')->name('config');

/* creamos la ruta por post para editar */
Route::post('/user/update', 'UserController@update')->name('user.update');

/* Creamo la ruta para mostrar el avatar*/
Route::get('/user/avatar/{filename}', 'UserController@getImagen')->name('user.avatar');

//Ruta profile
Route::get('/perfil/{id}','UserController@profile')->name('profile');

//Ruta para gente
Route::get('/gente/{search?}','UserController@index')->name('user.index');



//RUTAS DE IMAGEN

/*creamos la ruta para insertar imagenes (formulario para introducir)*/
Route::get('/upload-image', 'ImageController@create')->name('image.create');

//Creamos la ruta para guardar la imagen
Route::post('/image/save','ImageController@save')->name('image.save');

/* Creamo la ruta para mostrar la imagen*/
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');

// ruta para el detalle de la imagen
Route::get('/imagen/{id}', 'ImageController@detail')->name('image.detail');

// ruta para la eliminacion de una imagen
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');

//Ruta para la actualizacion de una imagen
Route::get('/image/editar/{id}','ImageController@edit')->name('image.edit');

//Ruta para actualizar la imagen
Route::post('/image/update', 'ImageController@update')->name('image.update');



//RUTAS COMMENTARIO
/* creamos la ruta por post para el formulario de detalle de comentarios */
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
// ruta para la eliminacion de un comentario
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');



//RUTAS DE LIKES
//Ruta para dar likes
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');

//Dislike (borrar like)
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');

//Ruta para likes
Route::get('/likes','LikeController@index')->name('likes');




