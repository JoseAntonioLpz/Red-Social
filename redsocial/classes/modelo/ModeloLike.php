<?php

class ModeloLike extends Modelo{
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerLike($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function like($like){
        return $this->gestor->add($like);
    }
    
    function unlike($like){
        return $this->gestor->remove($like);
    }
    
    function exist($like){
        return $this->gestor->exist($like);
    }
    
    function countLikePost($id){
        return $this->gestor->countLikesPost($id);
    }
}    