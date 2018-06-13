<?php

class Follow{
    
    private $idFollow, $idPerfil;
    
    function __construct($idPerfil, $idFollow){
        $this->idFollow = $idFollow;
        $this->idPerfil = $idPerfil;
    }
    
    function getIdFollow(){
        return $this->idFollow;
    }
    
    function setIdFollow($idFollow){
        $this->idFollow = $idFollow;
    }
    
    function getIdPerfil(){
        return $this->idPerfil;
    }
    
    function setIdPerfil($idPerfil){
        $this->idPerfil = $idPerfil;
    }
    
    use Comun;
}