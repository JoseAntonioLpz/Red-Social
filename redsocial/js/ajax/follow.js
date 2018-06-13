$(document).ready(function(){
    
    $('#peles').on('click', '.follow' ,function(e){
        e.preventDefault();
        
        var idFollow = $(this).data('id');
        $.ajax({
           url: 'follow/follow',
           method: 'post',
           dataType: 'json',
           data:{
               id: idFollow,
           }
        }).done(
            function(json){
                if(json.data){
                    $('.follow').addClass('unfollow');
                    $('.follow').removeClass('follow');
                    $('.unfollow').text('Dejar de seguir');
                    var nSeguidores = parseInt($('#Nseguidores').text());
                    nSeguidores = nSeguidores + 1;
                    $('#Nseguidores').text(nSeguidores);
                }
        }).fail(
            function(){
                console.log('Fallo en AJAX')
        }); 
    });
    
    $('#peles').on('click', '.unfollow' ,function(e){
        e.preventDefault();
        
        var idFollow = $(this).data('id');
        $.ajax({
           url: 'follow/unfollow',
           method: 'post',
           dataType: 'json',
           data:{
               id: idFollow,
           }
        }).done(
            function(json){
                if(json.data){
                    $('.unfollow').addClass('follow');
                    $('.unfollow').removeClass('unfollow');
                    $('.follow').text('Seguir');
                    var nSeguidores = parseInt($('#Nseguidores').text());
                    nSeguidores = nSeguidores - 1;
                    $('#Nseguidores').text(nSeguidores);
                }
        }).fail(
            function(){
                console.log('Fallo en AJAX')
        }); 
    });
});