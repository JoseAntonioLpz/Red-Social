<?php

class ModeloBlock extends Modelo{
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerBloqueado($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function block($block){
        return $this->gestor->block($block);
    }
    
    function unblock($block){
        return $this->gestor->unblock($block);
    }
}    