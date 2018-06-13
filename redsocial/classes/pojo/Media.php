<?php

class Media{
    
    private $id, $idPubli, $url;
    
    function __construct($id = 0, $idPubli = 0, $url = ''){
        $this->id = $id;
        $this->idPubli = $idPubli;
        $this->url = $url;
    }
    
    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function getIdPubli(){
        return $this->idPubli;
    }
    
    function setIdPubli($idPubli){
        $this->idPubli = $idPubli;
    }
    
    function getUrl(){
        return $this->url;
    }
    
    function setUrl($url){
        $this->url = $url;
    }
    
    use Comun;
}