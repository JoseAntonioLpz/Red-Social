<?php

class ModeloPerfil extends Modelo{
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerPerfil($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function add($perfil){
        return $this->gestor->add($perfil);
    }
    
    function getProfiles($idUser){
        return $this->gestor->getByUser($idUser);
    }
    
    function getProfile($id){
        return $this->gestor->get($id);
    }
    
    function comprobate($id, $idUser){
        return $this->gestor->comprobate($id, $idUser);
    }
    
    function isFollower($id, $idPerfil){
        $gestor = new ManagerSeguidor($this->dataBase);
        return $gestor->isFollower($id, $idPerfil);
    }
    
    function isBlock($idBloqueado, $idUser){
        $gestor = new ManagerBloqueado($this->dataBase);
        return $gestor->isBlock($idBloqueado, $idUser);
    }
    
    function getIdUserByIdPerfil($id){
        $gestor = new ManagerUser($this->dataBase);
        return $gestor->getIdUserByIdPerfil($id);
    }
    
    function getVerifyByIdPerfil($id){
        $gestor = new ManagerUser($this->dataBase);
        return $gestor->getVerifyByIdPerfil($id);
    }
    
    function search($id, $search){
        return $this->gestor->search($id, $search);
    }
    
    function updateProfile($perfil){
        return $this->gestor->edit($perfil);
    }
}
