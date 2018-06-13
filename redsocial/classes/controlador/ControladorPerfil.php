<?php

class ControladorPerfil extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        if($this->isProfile()){
            $this->getModel()->setDato('archivo', 'feed/_main.html');
        }elseif($this->isLogged()){
            $this->getModel()->setDato('archivo', 'acceso/_profiles.html');
        }else{
            $this->getModel()->setDato('archivo', 'acceso/_login.html');
        }
    }
    
    function nuevo(){
        if($this->isLogged()){
            $this->getModel()->setDato('archivo', 'acceso/_new.html');
        }else{
            $this->index();
        }
    }
    
    function add_perfil(){
        if($this->isLogged()){
            $perfil = new Perfil();
            $perfil->read();
            $perfil->setIdUsuario($this->getUser()->getId());
            if(Request::read('terms')){
                $res = $this->getModel()->add($perfil);
                if($res){
                    $this->getModel()->setDato('mensajes', 'Perfil creado con éxito');
                    //$this->viewProfiles();
                    $this->getModel()->setDato('archivo', 'acceso/_profiles.html');
                }else{
                    $this->getModel()->setDato('mensajes', 'Ha habido un problema con la creacion de su perfil');
                    $this->getModel()->setDato('archivo', 'acceso/_new.html');
                }
                
            }else{
                $this->getModel()->setDato('mensajes', 'Debes aceptar los terminos y condiciones');
                $this->getModel()->setDato('archivo', 'acceso/_new.html');
            }
        }else{
            $this->index();
        }
    }
    
    /*function viewProfiles(){
        if($this->isLogged()){
            $this->getModel()->setDato('archivo', 'acceso/_profiles.html');
            $profiles = $this->getModel()->getProfiles($this->getUser()->getId());
            $profiles = $this->renderProfiles($profiles);
            $this->getModel()->setDato('profiles', $profiles);
        }else{
            $this->index();
        }
    }
    
    function renderProfiles($profiles){
        if($this->isLogged()){
            $html = '<div><img src="#"/><a href="{{id}}">{{name}} {{surname}}</a></div>';
            $res = '';
            foreach($profiles as $profile){
                $res .= Util::renderText($html, $profile->get());
            }
        }else{
            $res = '';
        }
        return $res;
    }*/
    
    function viewProfiles(){
        if($this->isLogged()){
            $profiles = $this->getModel()->getProfiles($this->getUser()->getId());
            $this->getModel()->setDato('data', $profiles);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
    function selectProfile(){
        if($this->isLogged()){
            $id = Request::read('id');
            if($this->isMyProfile($id)){
                $perfil = $this->getModel()->getProfile($id);
                if($perfil){
                    $this->getSession()->setPerfil($perfil);
                    $this->getModel()->setDatos($perfil->get());
                    $this->getModel()->setDato('header', 'templates/includes/_header_login.html');
                    $this->getModel()->setDato('archivo', 'feed/_main.html');
                    $ms = new ModeloSeguidor($this->getModel()->getDataBase());
                    $mp = new ModeloPost($this->getModel()->getDataBase());
                    $this->getModel()->setDatos($this->getPerfil()->get());
                    $this->getModel()->setDato('seguidores' , $ms->countFollowers($this->getPerfil()->getId()));
                    $this->getModel()->setDato('seguidos' , $ms->countFollow($this->getPerfil()->getId()));
                    $this->getModel()->setDato('posts' , $mp->countPost($this->getPerfil()->getId()));
                    $this->getModel()->setDato('propuestos', $this->renderRandomProfiles());
                }else{
                    $this->index();
                }
            }else{
                $this->getModel()->setDato('mensaje', 'No puede iniciar sesion con ese perfil');
                $this->index();
            }
        }else{
            $this->index();
        }
    }
    
    function isMyProfile($id){
        return $this->getModel()->comprobate($id, $this->getUser()->getId());
    }
    
    function profileTemplate(){
        $id = Request::read('id');
        //echo Util::varDump($this->getModel()->isBlock($this->getUser()->getId(), $this->getModel()->getIdUserByIdPerfil($id)));
        if($id && !$this->getModel()->isBlock($this->getUser()->getId(), $this->getModel()->getIdUserByIdPerfil($id))){
            $perfil = $this->getModel()->getProfile($id);
            $this->getModel()->setDatos($perfil->get());
            $ms = new ModeloSeguidor($this->getModel()->getDataBase());
            $mp = new ModeloPost($this->getModel()->getDataBase());
            $mu = new ModeloUser($this->getModel()->getDataBase());
            $this->getModel()->setDato('seguidores', $ms->countFollowers($perfil->getId()));
            $this->getModel()->setDato('seguidos', $ms->countFollow($perfil->getId()));
            $this->getModel()->setDato('posts' , $mp->countPost($perfil->getId()));
            $this->getModel()->setDato('user' , $mu->getUserNameByIdPerfil($perfil->getId()));
            
            $this->getModel()->setDato('archivo', 'feed/_profile.html');
            if($this->isMyProfile($id) && $this->getPerfil()->getId() === $id){
                $this->getModel()->setDato('modificar', '<a class="modify" href="perfil/modificar">Modificar Perfil</a>');
            }else{
                if($this->getModel()->isFollower($id ,$this->getPerfil()->getId())){
                    $this->getModel()->setDato('follow', '<a class="unfollow" data-id="' . $id . '" href="#">Dejar de seguir</a>');
                }else{
                    $this->getModel()->setDato('follow', '<a class="follow" data-id="' . $id . '" href="#">Seguir</a>');
                }
                $idB = $this->getModel()->getIdUserByIdPerfil($id);
                
                //echo 'hola' . $this->getUser()->getId() . '<br>';
                if($this->getUser()->getId() !== $idB){
                    if($this->getModel()->isBlock($idB, $this->getUser()->getId())){
                        $this->getModel()->setDato('block', '<a class="unblock" data-id="' . $idB . '" href="#">Desbloquear</a>');
                    }else{
                        $this->getModel()->setDato('block', '<a class="block" data-id="' . $idB . '" href="#">Bloquear</a>');
                    }   
                }
            }
        }else{
            if($this->getModel()->isBlock($this->getUser()->getId(), $this->getModel()->getIdUserByIdPerfil($id))){
                $this->getModel()->setDato('archivo', 'feed/_profile_block.html');
            }else{
                $this->index();
            }
        }
    }
    
    function search(){
        if($this->isProfile()){
            $search = Request::read('search');
            $perfiles = $this->getModel()->search($this->getUser()->getId(), $search);
            //echo Util::varDump($perfiles);
            if(count($perfiles) > 0){
                $this->getModel()->setDato('search', $this->renderProfiles($perfiles));
                $count = count($perfiles);
                $this->getModel()->setDato('Cuenta', 'Resultados totales: ' . $count . ' Perfiles');
            }else{
                $this->getModel()->setDato('Cuenta', 'No hay perfiles que mostrar');
            }
            
            $mp = new ModeloPost($this->getModel()->getDataBase());
            $controlerPost = new ControladorPost($this->getModel());
            $posts = $mp->searchPost($this->getUser()->getId(),$search);
            
            if(count($posts) > 0){
                $this->getModel()->setDato('postSearch', $controlerPost->renderPost($posts));
                $count = count($posts);
                $this->getModel()->setDato('cuentaPost', 'Resultados totales: ' . $count. ' Posts');
            }else{
                $this->getModel()->setDato('cuentaPost', 'No hay Post que mostrar');
            }
            
            $this->getModel()->setDato('archivo', 'feed/_search.html');
        }else{
            $this->index();
        }
    }
    
    function renderProfiles($profiles){
        $html = '<div class="profileCard m0 mrigth10">
                    <div class="headerCard flex">
                        <img src="perfil/viewPhotoOtherProfiles?id={{id}}"/>
                    </div>
                    <div class="bodyCard flex">
                        {{name}} {{surname}}
                    </div>
                    <div class="footerCard flex">
                        <a href="perfil/profileTemplate?id={{id}}">Ir al perfil</a>
                    </div>
                </div>';
        $concat = '';
        foreach ($profiles as $profile) {
            $concat .= Util::renderText($html, $profile->get());
        }
        return $concat;
    }

    function viewPhoto(){
        if($this->isLogged()){
            if($this->isLogged()) {
                header('Content-type: image/*');
                $archivo = './profiles/' . $this->getPerfil()->getId();
                if(!file_exists($archivo)) {
                    if($this->getPerfil()->getSex() === 'Hombre'){
                        $archivo = './profiles/m0';
                    }elseif($this->getPerfil()->getSex() === 'Mujer'){
                        $archivo = './profiles/f0';
                    }else{
                        $archivo = './profiles/f0';
                    }
                }
                readfile($archivo);
                exit();
            } else {
                $this->index();
            }
        }
    }
    
    function viewPhotoOtherProfiles(){
        if($this->isLogged()){
            if($this->isLogged()) {
                header('Content-type: image/*');
                $id = Request::read('id');
                $archivo = './profiles/' . $id;
                $perfil = $this->getModel()->getProfile($id);
                if(!file_exists($archivo)) {
                    if($perfil->getSex() === 'Hombre'){
                        $archivo = './profiles/m0';
                    }elseif($perfil->getSex() === 'Mujer'){
                        $archivo = './profiles/f0';
                    }else{
                        $archivo = './profiles/f0';
                    }
                }
                readfile($archivo);
                exit();
            } else {
                $this->index();
            }
        }
    }
    
    function modificar(){
        if($this->isProfile()){
            $this->getModel()->setDato('archivo', 'feed/_modify.html');
        }else{
            $this->index();
        }
    }
    
    function updateProfile(){
        if($this->isProfile()){
            $perfil = new Perfil();
            $perfil->read();
            $perfil->setId($this->getPerfil()->getId());
            $perfil->setIdUsuario($this->getPerfil()->getIdUsuario());
            $res = $this->getModel()->updateProfile($perfil);
            $this->getModel()->setDato('archivo', 'feed/_modify.html');
            if($res){
                $this->getSession()->setPerfil($perfil);
                $this->getModel()->setDatos($perfil->get());
                $this->getModel()->setDato('mensaje', 'Perfil actualizado');
            }else{
                $this->getModel()->setDato('mensaje', 'Perfil no actualizado');
            }
        }else{
            $this->index();
        }
    }
    
    function updateImage(){
        if($this->isProfile()){
            $fu = new FileUpload('foto', $this->getPerfil()->getId() , './profiles', 2 * 1024 * 1024, FileUpload::SOBREESCRIBIR);
            if($fu->upload()){
                $this->getModel()->setDato('mensaje', 'Imagen actualizada con exito');
            }else{
                $this->getModel()->setDato('mensaje', 'Ha habido un error al subir la imagen');
            }
            $this->getModel()->setDato('archivo', 'feed/_modify.html');
        }else{
            $this->index();
        }
    }
    
}    