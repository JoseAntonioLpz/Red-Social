$(document).ready(function(){
   var div = $('#posts');
   var id = $('#idPerfil').val();
   
   $.ajax({
       url: 'post_ajax/obtainSinglePost',
       method: 'post',
       dataType: 'json',
       data:{
           id : id
       }
   }).done(function(json){
       for(var i = 0; i < json.data.length; i++){
          if(json.data[i].media > '0'){
            var comments  = renderComments(json.data[i].comentarios);  
            var plantilla = '<div class="post">'
            + '<div class="profile">'
            + '<div><img src="perfil/viewPhotoOtherProfiles?id=' + json.data[i].idPerfil +'"/></div>'
            + '<div><a href="perfil/profileTemplate?id=' + json.data[i].idPerfil +'"><p>' + json.data[i].name + ' ' + json.data[i].surname + '</p></a></div>'
            + '<div><p>' + json.data[i].fecha + '</p></div>'
            + '</div>'
            + '<div class="content"><p>' + json.data[i].texto + '</p>'
            + '<img src="post/viewImagePost?id=' + json.data[i].id + '"/></div>'
            + '<div class="likeCount"> A ' +  json.data[i].likes +  ' Personas les gusta esto</div>'
            + '<div id="commentsPlace">' + comments + '</div>'
            + '<div class="footerPost"><div><a href="#" class="like" data-id="'+ json.data[i].id + '"><i class="far fa-heart"></i> Like</a></div>'
            + '<div><a href="#" class="comment"><i class="far fa-comments"></i> Comentar</a></div></div>'
            + '<div class="comentInput oculto">'
            + '<form class="commentForm"><textarea placeholder="Comentar" class="texto"></textarea>'
            + '<input type="submit" value="Comentar" /><input class="id" type="hidden" value="' + json.data[i].id + '"/></form>'
            + '</div>'
            + '</div>';
          }else{
            var comments  = renderComments(json.data[i].comentarios);  
            var plantilla = '<div class="post">'
            + '<div class="profile">'
            + '<div><img src="perfil/viewPhotoOtherProfiles?id=' + json.data[i].idPerfil +'"/></div>'
            + '<div><a href="perfil/profileTemplate?id=' + json.data[i].idPerfil +'"><p>' + json.data[i].name + ' ' + json.data[i].surname + '</p></a></div>'
            + '<div><p>' + json.data[i].fecha + '</p></div>'
            + '</div>'
            + '<div class="content"><p>' + json.data[i].texto + '</p></div>'
            + '<div class="likeCount"> A ' +  json.data[i].likes +  ' Personas les gusta esto</div>'
            + '<div id="commentsPlace">' + comments + '</div>'
            + '<div class="footerPost"><div><a href="#" class="like" data-id="'+ json.data[i].id + '"><i class="far fa-heart"></i> Like</a></div>'
            + '<div><a href="#" class="comment"><i class="far fa-comments"></i> Comentar</a></div></div>'
            + '<div class="comentInput oculto">'
            + '<form class="commentForm"><textarea placeholder="Comentar" class="texto"></textarea>'
            + '<input type="submit" value="Comentar" /><input class="id" type="hidden" value="' + json.data[i].id + '"/></form>'
            + '</div>'
            + '</div>';
          }
            
            div.append($(plantilla));
       }
   }).fail(function(){
       console.log('No se han podido obtener los post');
   });
});

function renderComments(comentarios){
    var html = '';
    for(var i = 0; i < comentarios.length; i++){
        html += '<div class="comentario">'
        + '<div><img src="perfil/viewPhotoOtherProfiles?id=' + comentarios[i].idUser +'"/><p>' + comentarios[i].name + ' ' + comentarios[i].surname + '</p></div>'
        + '<div><p class="cuerpo">' + comentarios[i].texto  + '<p></div><hr>'
        + '</div>';
    }
    return html;
}