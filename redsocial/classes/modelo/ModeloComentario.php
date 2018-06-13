<?php

class ModeloComentario extends Modelo{
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerComentario($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function add($comment){
        return $this->gestor->add($comment);
    }
}    