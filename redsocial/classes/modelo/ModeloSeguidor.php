<?php

class ModeloSeguidor extends Modelo{
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerSeguidor($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function follow($follow){
        return $this->gestor->follow($follow);
    }
    
    function unfollow($follow){
        return $this->gestor->unfollow($follow);
    }
    
    function countFollow($id){
        return $this->gestor->countFollow($id);
    }
    
    function countFollowers($id){
        return $this->gestor->countFollowers($id);
    }
}    