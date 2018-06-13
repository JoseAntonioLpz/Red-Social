<?php

class ControladorSeguidor extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        $this->getModel()->setDato('data', '');
    }
    
    function follow(){
        if($this->isProfile()){
            $idFollow = Request::read('id');
            $follow = new Follow($this->getPerfil()->getId(), $idFollow);
            $res = $this->getModel()->follow($follow);
            $this->getModel()->setDato('data', $res);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
    function unfollow(){
        if($this->isProfile()){
            $idFollow = Request::read('id');
            $follow = new Follow($this->getPerfil()->getId(), $idFollow);
            $res = $this->getModel()->unfollow($follow);
            $this->getModel()->setDato('data', $res);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
    function countFollow(){
        $id = Request::read('id');
        $res = $this->getModel()->countFollow($id);
        $this->getModel()->setDato('data', $res);
    }
    
    function countFollowers(){
        $id = Request::read('id');
        $res = $this->getModel()->countFollowers($id);
        $this->getModel()->setDato('data', $res);
    }
}