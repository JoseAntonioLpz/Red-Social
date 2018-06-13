$(document).ready(function(){
    var resCont = $('#respuestas');
    resCont.append('<div class="botResponse"><p>Hola soy tu asistente personal :D</p></div>');
    $('.botones a').click(function(e){
       e.preventDefault();
       var q = $(this).data('quest');
       
       resCont.append('<div class="userQuest"><p>' + q + '</p></div>');
       
       sendQuest(resCont, q);
    });
    
    $('#qBot').click(function(){
        var q = $(this).prev('#question').val();
       
       resCont.append('<div class="userQuest"><p>' + q + '</p></div>');
       sendQuest(resCont, q);
       
       $(this).prev('#question').val('');
    });
    
    resCont.on('click' , 'button', function(){
        var user = $(this).prev().prev().val();
        var motivos = $(this).prev().val();
        $.ajax({
            url: 'denuncia_ajax/add',
            method:'post',
            dataType:'json',
            data:{
               user: user,
               motivo: motivos
            }
        }).done(function(json){
            resCont.append('<div class="botResponse"><p>' + json.data + '</p></div>');
        }).fail(function(){
           resCont.append('<div class="botResponse"><p>El bot no esta disponible en este momento</p></div>');
       });
    });
});

function sendQuest(resCont, q){
    $.ajax({
       url: 'bot_ajax/quest',
       method:'post',
       dataType:'json',
       data:{
           quest: q
       }
   }).done(function(json){
       resCont.append('<div class="botResponse"><p>' + json.respuesta + '</p></div>');
   }).fail(function(){
       resCont.append('<div class="botResponse"><p>El bot no esta disponible en este momento</p></div>');
   });
}