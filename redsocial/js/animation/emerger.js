$(document).ready(function(){
    
   $('#add').on('click', function(){
       if($('#em').val() === 'false'){
           $('#em').val('true');
           $('.cardPostForm').animate({
                bottom: 0
            }, 500);
            
            $('.buttonAddPost ').animate({
                bottom: '230px'
            }, 500);
            $('#add').empty();
            $('#add').append('<i class="fas fa-times"></i>');
            
       }else{
           $('#em').val('false');
           $('.cardPostForm').animate({
                bottom: '-500px'
            }, 500);
            $('.buttonAddPost ').animate({
                bottom: '40px'
            }, 500);
            
            $('#add').empty();
            $('#add').append('<i class="fas fa-pencil-alt"></i>');
       }
   });
   
});