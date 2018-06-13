<?php

class Post{
    private $id, $idPerfil, $texto, $media, $fecha;
    
    function __construct($id = 0, $idPerfil = 0, $texto = '', $media = 0){
        $this->id = $id;
        $this->idPerfil = $idPerfil;
        $this->texto = $texto;
        $this->media = $media;
        $this->fecha = date("Y-m-d H:i:s");
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
    
    function getTexto(){
        return $this->texto;
    }
    
    function setTexto($texto){
        $this->texto = $texto;
    }
    
    function getMedia(){
        return $this->media;
    }
    
    function setMedia($media){
        $this->media = $media;
    }
    
    function getFecha(){
        return $this->fecha;
    }
    
    function setFecha($fecha){
        $this->fecha = $fecha;
    }
    
    use Comun;
}
