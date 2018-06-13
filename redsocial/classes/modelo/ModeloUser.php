<?php

class ModeloUser extends Modelo{
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerUser($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function addUser($user){
        return $this->gestor->add($user);
    }
    
    function comprobateUser($user){
        return $this->gestor->comprobateUserName($user);
    }
    
    function getUserForLogin($param){
        return $this->gestor->getUserForLogin($param);
    }
    
    function getUsers($a, $b){
        return $this->gestor->getAllLimit($a, $b);
    }
    
    function getCount(){
        return $this->gestor->getCount();
    }
    
    function baja($id){
        return $this->gestor->remove($id);
    }
    
    function verify($id){
        return $this->gestor->verify($id);
    }
    
    function noVerify($id){
        return $this->gestor->noVerify($id);
    }
    
    function get($id){
        return $this->gestor->get($id);
    }
    
    function getUsersDenunciadosCount(){
        return $this->gestor->getUsersDenunciadosCount();
    }
    
    function getUsersDenunciados(){
        return $this->gestor->getUsersDenunciados();
    }
    
    function getUserNameByIdPerfil($id){
        return $this->gestor->getUserNameByIdPerfil($id);
    }
    
    function getUserIdByUser($user){
        return $this->gestor->getUserIdByUser($user);
    }
}