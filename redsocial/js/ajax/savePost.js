$(document).ready(function(){
   
    $('#post').on('submit', function(e){
        e.preventDefault();
        
        var form = $(this);

        var texto = $("#texto").val().replace(/<[^>]*>?/g, '');
        var media = $('#media');   
        var archivo = media[0].files;
        $('.confirm').css('display', 'block');
        //$("#texto").val('');
        //$('#media').replaceWith($('#media').val('').clone(true));
        //form[0].reset();
        if(texto && (archivo.length != 0)){
            $('#salvando').attr("disabled","disabled");
            // Crea un formData y lo envías
            var formData = new FormData(form[0]);
            formData.append('texto', texto);
            formData.append('media', archivo);
            
            $.ajax({
                url: 'post_ajax/savePost',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(res){
                    var post = renderPost(res.data);
                    $('#posts').prepend($(post));
                    $('#salvando').removeAttr("disabled");
                    form[0].reset();
                    $('.confirm').text('Post Enviado');
                    $('.confirm').css('background-image', '');
                    setTimeout(function(){ $('.confirm').css('display', 'none'); $('.confirm').css('background-image', 'url(../images/carga.gif)');}, 3000);
                }
            });
        }else if(texto){
            $('#salvando').attr("disabled","disabled");
            var formData = new FormData(form[0]);
            formData.append('texto',texto);
            
            $.ajax(
                {
                    url: 'post_ajax/savePost',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (res) {
                        //var pepe = JSON.parse(res);
                        //console.log(res.data);
                        var post = renderPost(res.data);
                        $('#posts').prepend($(post));
                        $('#salvando').removeAttr("disabled");
                        form[0].reset();
                        $('.confirm').text('Post Enviado');
                        setTimeout(function(){$('.confirm').text('Enviando post...'); $('.confirm').css('display', 'none');}, 1000);
                    }
                }
            );            
        }else{
            console.log('Nada que hacer');
        }
    });
    
    function renderPost(post){
        if(post.media > '0'){
            var plantilla = '<div class="post">'
            + '<div class="profile">'
            + '<div><img src="perfil/viewPhotoOtherProfiles?id=' + post.idPerfil +'"/></div>'
            + '<div><a href="perfil/profileTemplate?id=' + post.idPerfil +'"><p>' + post.name + ' ' + post.surname + '</p></a></div>'
            + '<div><p>' + post.fecha + '</p></div>'
            + '</div>'
            + '<div class="content"><p>' + post.texto + '</p>'
            + '<img src="post/viewImagePost?id=' + post.id + '"/></div>'
            + '<div class="likeCount"> A 0 Personas les gusta esto</div>'
            + '<div id="commentsPlace"></div>'
            + '<div class="footerPost"><div><a href="#" class="like" data-id="'+ post.id + '"><i class="far fa-heart"></i> Like</a></div>'
            + '<div><a href="#" class="comment"><i class="far fa-comments"></i> Comentar</a></div></div>'
            + '<div class="comentInput oculto">'
            + '<form class="commentForm"><textarea placeholder="Comentar" class="texto"></textarea>'
            + '<input type="submit" value="Comentar" /><input class="id" type="hidden" value="' + post.id + '"/></form>'
            + '</div>'
            + '</div>';
        }else{
            var plantilla = '<div class="post">'
            + '<div class="profile">'
            + '<div><img src="perfil/viewPhotoOtherProfiles?id=' + post.idPerfil +'"/></div>'
            + '<div><a href="perfil/profileTemplate?id=' + post.idPerfil +'"><p>' + post.name + ' ' + post.surname + '</p></a></div>'
            + '<div><p>' + post.fecha + '</p></div>'
            + '</div>'
            + '<div class="content"><p>' + post.texto + '</p>'
            + '</div>'
            + '<div class="likeCount"> A 0 Personas les gusta esto</div>'
            + '<div id="commentsPlace"></div>'
            + '<div class="footerPost"><div><a href="#" class="like" data-id="'+ post.id + '"><i class="far fa-heart"></i> Like</a></div>'
            + '<div><a href="#" class="comment"><i class="far fa-comments"></i> Comentar</a></div></div>'
            + '<div class="comentInput oculto">'
            + '<form class="commentForm"><textarea placeholder="Comentar" class="texto"></textarea>'
            + '<input type="submit" value="Comentar" /><input class="id" type="hidden" value="' + post.id + '"/></form>'
            + '</div>'
            + '</div>';
        }
        
            
            return plantilla;
    }
});
