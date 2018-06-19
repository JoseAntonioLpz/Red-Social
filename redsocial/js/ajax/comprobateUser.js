$(document).ready(function(){
    
    $('#user').on('change', function(){
        var user = $(this).val();
        $.ajax({
            url: "user_ajax/comprobateUser",
            method: "POST",
            dataType: "json",
            data: {
                user: user
            }
        }).done(function(json){
            if(json.data > 0){
                $('#user').removeClass('verde');
                $('#user').addClass('rojo');
            }else{
                $('#user').removeClass('rojo');
                $('#user').addClass('verde');
            }
        }).fail(function(){
            console.log('La llamada Ajax ha fallado');
        });
    });
    
});