$(document).ready(function(){
    $('.menu').data('bool', 'true');
    $('.menu').click(function(){
        
        if($(this).data('bool') === 'true'){
            
            $('.desplegable').animate({
                left: "0px"
            },500,function(){
                $('.menu').data('bool', 'false');
            });     
            
        }else{
            
            $('.desplegable').animate({
                left: "-500px"
            },500,function(){
                $('.menu').data('bool', 'true');
            });   
            
        }
    });
});