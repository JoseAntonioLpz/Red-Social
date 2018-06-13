<?php

class ControladorLike extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        echo 'index like';
    }
    
    function like(){
        if($this->isProfile()){
            $like = new Like();
            $like->read();
            $like->setIdPerfil($this->getPerfil()->getId());
            //echo Util::varDump($like);
            $r[] = ($this->getModel()->exist($like)) ? $this->getModel()->unlike($like) : $this->getModel()->like($like);
            $r[] = $this->getModel()->countLikePost($like->getIdPost());
            $this->getModel()->setDato('data', $r);
        }else{
            $this->index();
        }    
    }
}