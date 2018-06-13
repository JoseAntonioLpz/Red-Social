$(document).ready(function(){
    
    $('#block').on('click', '.block' ,function(e){
        e.preventDefault();
        
        var idFollow = $(this).data('id');
        $.ajax({
           url: 'block/block',
           method: 'post',
           dataType: 'json',
           data:{
               id: idFollow,
           }
        }).done(
            function(json){
                if(json.data){
                    $('.block').addClass('unblock');
                    $('.block').removeClass('block');
                    $('.unblock').text('Desbloquear');
                }
        }).fail(
            function(){
                console.log('Fallo en AJAX')
        }); 
    });
    
    $('#block').on('click', '.unblock' ,function(e){
        e.preventDefault();
        
        var idFollow = $(this).data('id');
        $.ajax({
           url: 'block/unblock',
           method: 'post',
           dataType: 'json',
           data:{
               id: idFollow,
           }
        }).done(
            function(json){
                if(json.data){
                    $('.unblock').addClass('block');
                    $('.unblock').removeClass('unblock');
                    $('.block').text('Bloquear');
                }
        }).fail(
            function(){
                console.log('Fallo en AJAX')
        }); 
    });
});