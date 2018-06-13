$(document).ready(function(){
   
   $('#posts').on('submit' , '.commentForm' , function (e){
       e.preventDefault();
       var comentplace = $(this).parent().parent().children('div:nth-child(4)');
        $.ajax({
            url: 'comment/comment',
            method: 'post',
            dataType: 'json',
            data:{
                idPost: $(this).children('.id').val(),
                texto: $(this).children('.texto').val()
            }
        }).done(function(json){
            console.log(json.data);
            if(json.data){
                var comment = '<div class="comentario">'
                    + '<div><img src="perfil/viewPhotoOtherProfiles?id=' + json.data.idUser +'"/><p>' + json.data.name + ' ' + json.data.surname + '</p></div>'
                    + '<div><p class="cuerpo">' + json.data.texto  + '<p></div><hr>'
                    + '</div>';
                comentplace.append(comment);
            }
        }).fail(function(){
           console.log('Error en ajax'); 
        }).always(function(){
            $(this).children('.texto').val('')
        });       
   });
   
   $('#posts').on('click' , '.comment' , function (e){
       e.preventDefault();
       
       var form = $(this).parent().parent().parent().children('div:nth-child(6)');
       form.toggleClass('oculto');
       
       
   });
   
});