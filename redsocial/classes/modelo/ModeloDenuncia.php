<?php

class ModeloDenuncia extends Modelo{
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerDenuncias($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function add($denuncia){
        return $this->gestor->add($denuncia);
    }
    
    function ress($idUsuario, $idDenunciado){
        return $this->gestor->ress($idUsuario, $idDenunciado);
    }
}    