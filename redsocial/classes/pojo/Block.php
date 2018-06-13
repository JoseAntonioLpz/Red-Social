<?php

class Block{
    
    private $idUsuario, $idBlock;
    
    function __construct($idUsuario, $idBlock){
        $this->idUsuario = $idUsuario;
        $this->idBlock = $idBlock;
    }
    
    function getIdUsuario(){
        return $this->idUsuario;
    }
    
    function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    
    function getIdBlock(){
        return $this->idBlock;
    }
    
    function setIdBlock($idBlock){
        $this->idBlock = $idBlock;
    }
    
    use Comun;
}