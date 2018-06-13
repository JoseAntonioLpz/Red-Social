$(document).ready(function(){
    
    $('#posts').on('click' , '.like' ,function(e){
        var like = $(this).parent().parent().parent().children('.likeCount');
        e.preventDefault();
        $.ajax({
            url : 'like/like',
            method : 'post',
            dataType: 'json',
            data: {
                idPost: $(this).data('id')
            }
        }).done(function(json){
            if(json.data[0]){
                console.log(like);
                like.text('A ' + json.data[1] + ' Personas les gusta esto');
                console.log(json.data);
            }
        }).fail(function(){
            
        }).always(function(){
            
        });
    });
});