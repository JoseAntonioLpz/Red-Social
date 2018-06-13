<?php

class Controlador {

    private $modelo;
    private $sesion;

    function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
        $this->sesion = new Session('social');
        $this->getModel()->setDato('base', Constant::BASE);
        if($this->isLogged()) {
            /*$usuario = $this->getUser();
            $perfil = $this->getPerfil();*/
            $this->getModel()->setDato('header', 'templates/includes/_header_user.html');
            if($this->isProfile()){
                $this->getModel()->setDato('header', 'templates/includes/_header_login.html');
                $ms = new ModeloSeguidor($this->getModel()->getDataBase());
                $mp = new ModeloPost($this->getModel()->getDataBase());
                $this->getModel()->setDatos($this->getPerfil()->get());
                $this->getModel()->setDato('seguidores' , $ms->countFollowers($this->getPerfil()->getId()));
                $this->getModel()->setDato('seguidos' , $ms->countFollow($this->getPerfil()->getId()));
                $this->getModel()->setDato('posts' , $mp->countPost($this->getPerfil()->getId()));
                $this->getModel()->setDato('propuestos', $this->renderRandomProfiles());
            }
            
            if($this->isAdmin()){
                $this->getModel()->setDato('header', 'templates/includes/_header_admin.html');
            }
        }else{
            $this->getModel()->setDato('header', 'templates/includes/_header.html');
        }
    }

    function getModel() {
        return $this->modelo;
    }

    function getSession() {
        return $this->sesion;
    }

    function getUser() {
        return $this->getSession()->getUser();
    }
    
    function getPerfil() {
        return $this->getSession()->getPerfil();
    }

    function isLogged() {
        return $this->getSession()->isLogged();
    }
    
    function isProfile(){
        if($this->isLogged()){
            $res = $this->getSession()->isProfile();
        }else{
            $res = false;
        }
        return $res;
    }
    
    function isAdmin(){
        if($this->isLogged()){
            $res = ($this->getUser()->getAdmin() === '1') ? true : false;
        }else{
            $res = false;
        }
        
        return $res;
    }
    
    function index(){
        if($this->isAdmin()){
            $this->getModel()->setDato('archivo', 'admin/_index.html');
        }elseif($this->isProfile()){
            $this->getModel()->setDato('archivo', 'feed/_main.html');
        }elseif($this->isLogged()){
            $this->getModel()->setDato('archivo', 'acceso/_profiles.html');
        }else{
            $this->getModel()->setDato('archivo', 'acceso/_login.html');
        }
    }
    
    function terminos(){
        echo 'terminos';
    }
    
    function renderRandomProfiles(){
        $html = '<div class="profileRandom">
        <div><img src="perfil/viewPhotoOtherProfiles?id={{id}}" /></div>
        <div><p><a href="perfil/profileTemplate?id={{id}}">{{name}} {{surname}}</a></p></div>
        </div>';
        $con = '';
        $perfiles = $this->getModel()->renderRandomProfiles();
        //var_dump($perfiles);
        //$mp = new ManagerPerfil($this->getModel()->getDataBase());
        //$perfiles = $mp->getRandom();
        foreach($perfiles as $perfil){
            $con .= Util::renderText($html, $perfil->get());
        }
        return $con;
    }
}