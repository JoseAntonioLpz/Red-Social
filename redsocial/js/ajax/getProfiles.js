$(document).ready(function(){
    $.ajax({
        url: 'perfil_ajax/viewProfiles',
        method: 'post',
        dataType: 'json'
    }).done(function(json){
        for (var i = 0; i < json.data.length; i++) {
            var node = renderProfiles(json.data[i]);
            $('#profiles').prepend(node);
        }
    }).fail(function(){
        console.log('fallo en el ajax');
    });
});

function renderProfiles(profile){
    var $html = '<div class="profileCard">' +
            '<div class="headerCard flex">' +
                '<img src="perfil/viewPhotoOtherProfiles?id='+ profile.id + '"/>' +
            '</div>' +
            '<div class="bodyCard flex">' +
                profile.name + '' + profile.surname +
            '</div>' +
            '<div class="footerCard flex">' + 
                '<a href="perfil/selectProfile?id='+ profile.id + '">Iniciar Sesion</a>' +
            '</div>' +
        '</div>';
    return $html;
}

/*var $html = '<div class="selectProfile" id="profiless">'+
    '<div class="profileCard">' +
        '<div class="headerCard flex">' +
            '<img src="perfil/viewPhotoOtherProfiles?id='+ profile.id + '"/>' +
        '</div>' +
        '<div class="bodyCard flex">' +
            profile.name + '' + profile.surname +
        '</div>' +
        '<div class="footerCard flex">' + 
            '<a href="perfil/selectProfile?id='+ profile.id + '">Iniciar Sesion</a>' +
        '</div>' +
    '</div>' +
'</div>';*/