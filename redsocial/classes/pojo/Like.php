<?php

class Like{
    
    private $idPost, $idPerfil;
    
    function __construct($idPost = 0, $idPerfil = 0){
        $this->idPost = $idPost;
        $this->idPerfil = $idPerfil;
    }
    
    function getIdPost(){
        return $this->idPost;
    }
    
    function setIdPost($idPost){
        $this->idPost = $idPost;
    }
    
    function getIdPerfil(){
        return $this->idPerfil;
    }
    
    function setIdPerfil($idPerfil){
        $this->idPerfil = $idPerfil;
    }
    
    use Comun;
}