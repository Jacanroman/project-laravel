let url = 'http://project-laravel.test';

window.addEventListener("load", function(){
    //comprobar si jquery esta cargado en le proyecto
    //$('body').css("background",'red');

    $('.btn-like').css('cursor','pointer');
    $('.btn-dislike').css('cursor','pointer');

    //Boton de like
    function like(){
        $('.btn-like').unbind('click').click(function(){
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src',url+'/img/heart-68-64red.png');

            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log("has dado like a la publicacion");
                    }else{
                        console.log("error al dar like");
                    } 
                }
            });

            dislike();
        });
    }
    like();

    //Boton de dislike
    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src',url+'/img/heart-68-64black.png');

            $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log("has dado dislike a la publicacion");
                    }else{
                        console.log("error al dar dislike");
                    } 
                }
            });

            like();
        });
    }
    dislike();
});