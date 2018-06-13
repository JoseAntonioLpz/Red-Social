<?php

class Comentario{
    
    private $id, $idPerfil, $idPost, $texto;
    
    function __construct($id = 0, $idPerfil = 0, $idPost = 0, $texto = ''){
        $this->id = $id;
        $this->idPerfil = $idPerfil;
        $this->idPost = $idPost;
        $this->texto = $texto;
    }
    
    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function getIdPerfil(){
        return $this->idPerfil;
    }
    
    function setIdPerfil($idPerfil){
        $this->idPerfil = $idPerfil;
    }
    
    function getIdPost(){
        return $this->idPost;
    }
    
    function setIdPost($idPost){
        $this->idPost = $idPost;
    }
    
    function getTexto(){
        return $this->texto;
    }
    
    function setTexto($texto){
        $this->texto = $texto;
    }
    
    use Comun;
}