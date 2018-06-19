$(document).ready(function(){
    $('input[name="email"]').on('change', function(){
        var val = $(this).val();
        if(mail(val)){
            $(this).removeClass('rojo');
            $(this).addClass('verde');
        }else{
            $(this).removeClass('verde');
            $(this).addClass('rojo');
        }
    });
    
    $('input[name="password"]').on('change', function(){
        var val = $(this).val();
        if(pass(val)){
            $(this).removeClass('rojo');
            $(this).addClass('verde');
        }else{
            $(this).removeClass('verde');
            $(this).addClass('rojo');
        }
    });
    
    $('input[name="passRep"]').on('change', function(){
        var val = $(this).val();
        if(pass(val) && val === $('input[name="password"]').val()){
            $(this).removeClass('rojo');
            $(this).addClass('verde');
        }else{
            $(this).removeClass('verde');
            $(this).addClass('rojo');
        }
    });
    
    $('#register').submit(function(e){
        if($('.rojo').length > 0){
            e.preventDefault();
        }
    });
});

function mail(input){
    var r = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    return r.test(input);
}

function pass(input){
    var r = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
    return r.test(input);
}