<?php

class ControladorBlock extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        $this->getModel()->setDato('data', '');
    }
    
    function block(){
        if($this->isProfile()){
            $idBlock = Request::read('id');
            $block = new Block($this->getUser()->getId(), $idBlock);
            $res = $this->getModel()->block($block);
            $this->getModel()->setDato('data', $res);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
    function unblock(){
        if($this->isProfile()){
            $idBlock = Request::read('id');
            $block = new Block($this->getUser()->getId(), $idBlock);
            $res = $this->getModel()->unblock($block);
            $this->getModel()->setDato('data', $res);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
}