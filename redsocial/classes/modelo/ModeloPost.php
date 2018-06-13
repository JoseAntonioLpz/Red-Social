<?php

class ModeloPost extends Modelo{
    private $dataBase;
    private $datos;
    private $gestorPost;
    private $gestorMedia;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestorPost = new ManagerPost($this->dataBase);
        $this->gestorMedia = new ManagerMedia($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function savePost($post){
        return $this->gestorPost->add($post);
    }
    
    function saveMedia($media){
        return $this->gestorMedia->add($media);
    }
    
    function obtainPost($id, $a, $b){
        return $this->gestorPost->get($id, $a, $b);
    }
    
    function obtainSinglePost($id){
        return $this->gestorPost->getSinglePost($id);
    }
    
    function getPostById($id){
        return $this->gestorPost->getById($id);
    }
    
    function getPostCompleteById($id){
        return $this->gestorPost->getPostCompleteById($id);
    }
    
    function countPost($id){
        return $this->gestorPost->countPost($id);
    }
    
    function postCount($id){
        return $this->gestorPost->countPostForPaginate($id);
    }
    
    function searchPost($id, $search){
        return $this->gestorPost->search($id, $search);
    }
}    