<?php

class ControladorComentario extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        echo 'index comentario';
    }
    
    function comment(){
        if($this->isProfile()){
            $comment = new Comentario();
            $comment->read();
            $comment->setIdPerfil($this->getPerfil()->getId());
            $comment = $this->getModel()->add($comment);
            $res = array(
                'id' => $comment->getId(),
                'idPost' => $comment->getIdPost(),
                'texto' => $comment->getTexto(),
                'idUser' => $this->getPerfil()->getId(),
                'name' => $this->getPerfil()->getName(),
                'surname' => $this->getPerfil()->getSurname(),
            );
            
            $this->getModel()->setDato('data', $res);
        }else{
            $this->index();
        }
    }
    
}