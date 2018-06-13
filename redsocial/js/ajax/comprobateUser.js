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
                alert ('El nombre de usuario ya existe');
            }else{
                alert ('Nombre disponible');
            }
        }).fail(function(){
            console.log('La llamada Ajax ha fallado');
        });
    });
    
});