@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')

                <div class="card pub_image pub_image_detail">
                    <div class="card-header">

                        @if($image->user->image)
                        <div class="container-avatar">
                            <img src="{{ route('user.avatar',['filename'=>$image->user->image])}}" />
                        </div>
                        @endif
                        <div class="data-user">
                            {{$image->user->name.' '.$image->user->surname}}
                            <span class="nickname">
                            {{'| '.$image->user->nick}}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="image-container image-detail">
                            <img src="{{ route('image.file',['filename' => $image->image_path])}}" />
                        </div>
                        
                        <div class="description">
                            <span class="nickname">{{'@'.$image->user->nick}}</span>
                            <span class="nickname date">{{' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                            <p> {{$image->description}} </p>
                        </div>

                        <div class="likes">
                            
                            <!-- comprobar si el usuario le dio like a la imagen -->
                            <?php $user_like = false; ?>
                            @foreach($image->likes as $like)
                                @if($like->user->id == Auth::user()->id)
                                    <?php $user_like = true; ?>
                                @endif
                            @endforeach

                            @if($user_like)
                                <img src="{{asset('img/heart-68-64red.png')}}" data-id="{{$image->id}}" class="btn-dislike" />
                            @else
                                <img src="{{asset('img/heart-68-64black.png')}}" data-id="{{$image->id}}"  class="btn-like" />
                            @endif

                            <span class="number_likes">{{count($image->likes)}}</span>
                        </div>

                        @if(Auth::user() && Auth::user()->id == $image->user->id)
                            <div class="actions">
                                <a href="{{route('image.edit', ['id'=>$image->id])}}" class="btn btn-sm btn-primary">Actualizar</a>
                                <!--
                                <a href="{{route('image.delete',['id'=>$image->id])}}" class="btn btn-sm btn-danger">Borrar</a>
                                -->
                                
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">
                                    Borrar
                                </button>

                                <!-- The Modal -->
                                <div class="modal" id="myModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Estas seguro?</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Si eliminar esta imagen nunca podras recuperarls, estas seguro?
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-success" data-dismiss="modal">Cancelar</button>
                                            <a href="{{route('image.delete',['id'=>$image->id])}}" class="btn btn-sm btn-danger">Borrar definitivamente</a>
                                        </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif

                        <div class="clearfix"></div>
                        <div class="comments">
                            <h2>Comentarios ({{count($image->comments)}})</h2>
                            <hr>
                            <!--Al form le añadimos la ruta para detalle de comentarios-->
                            <form method="POST" action="{{route('comment.save')}}">
                               @csrf 

                               <input type="hidden" name="image_id" value="{{$image->id}}"/>
                               <p>
                                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" ></textarea>
                                    
                                    <!--comprobar si llegan errores desde description -->
                                    @if($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$errors->first('content')}}</strong>
                                        </span>
                                    @endif
                               
                               </p>
                               <button type="submit" class="btn btn-success">
                                Enviar
                               </button>
                            </form>
                                <hr>
                                <h2>Comentarios</h2>
                            @foreach($image->comments as $comment)
                                <div class="comment">
                                    
                                    <span class="nickname">{{'@'.$comment->user->nick}}</span>
                                    <span class="nickname date">{{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                                    <p> {{$comment->content}} </p>
                                    <!--Ponemos un condicional que hace que el boton aparezca si estamos
                                identificados y el usuario sea el dueño de la imagen o el comentario-->

                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                    <a class="btn btn-sm btn-danger" href="{{route('comment.delete',['id' =>$comment->id])}}">
                                        Eliminar
                                    </a>
                                @endif
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

    </div>
</div>
@endsection
