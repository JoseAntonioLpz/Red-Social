<?php

class Denuncia{
    
    private $id, $idUsuario, $idDenunciado, $motivo, $resuelta;
    
    function __construct($id = 0, $idUsuario = 0, $idDenunciado = 0, $motivo = '', $resuelta = 0){
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idDenunciado = $idDenunciado;
        $this->motivo = $motivo;
        $this->resuelta = $resuelta;
    }
    
    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function getIdUsuario(){
        return $this->idUsuario;
    }
    
    function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    
    function getIdDenunciado(){
        return $this->idDenunciado;
    }
    
    function setIdDenunciado($idDenunciado){
        $this->idDenunciado = $idDenunciado;
    }
    
    function getMotivo(){
        return $this->motivo;
    }
    
    function setMotivo($motivo){
        $this->motivo = $motivo;
    }
    
    function getResuelta(){
        return $this->resuelta;
    }
    
    function setResuelta($resuelta){
        $this->resuelta = $resuelta;
    }
    
    use Comun;
}