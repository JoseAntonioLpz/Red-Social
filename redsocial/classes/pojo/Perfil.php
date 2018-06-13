<?php

class Perfil{
    
    private $id, $name, $surname, $birthday, $sex, $idUsuario;
    
    function __construct($id = 0, $name = '', $surname = '', $birthday = '', $sex = '', $idUsuario = 0){
        $this->id = $id;
        $this->name = $name;  
        $this->surname = $surname;  
        $this->birthday = $birthday;  
        $this->sex = $sex;  
        $this->idUsuario = $idUsuario;  
    }
    
    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function getName(){
        return $this->name;
    }
    
    function setName($name){
        $this->name = $name;
    }
    
    function getSurname(){
        return $this->surname;
    }
    
    function setSurname($surname){
        $this->surname = $surname; 
    }
    
    function getBirthday(){
        return $this->birthday;
    }
    
    function setBirthday($birthday){
        $this->birthday = $birthday;
    }
    
    function getSex(){
        return $this->sex;
    }
    
    function setSex($sex){
        $this->sex = $sex;
    }
    
    function getIdUsuario(){
        return $this->idUsuario;
    }
    
    function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    
    use Comun;
}