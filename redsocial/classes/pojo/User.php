<?php

class User{
    
    private $id, $user, $email, $password, $date, $admin, $verify;
    
    function __construct($id = 0, $user = '', $email = '', $password = '' ,$admin = 0, $verify = 0){
        $this->id = $id;
        $this->user = $user;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->verify = $verify;
    }
    
    use Comun;
    
    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function getUser(){
        return $this->user;
    }
    
    function setUser($user){
        $this->user = $user;
    }
    
    function getEmail(){
        return $this->email;
    }
    
    function setEmail($email){
        $this->email = $email;
    }
    
    function getPassword(){
        return $this->password;
    }
    
    function setPassword($password){
        $this->password = $password;
    }
    
    function getDate(){
        return $this->date;
    }
    
    function setDate($date){
        $this->date = $date;
    }
    
    function getAdmin(){
        return $this->admin;
    }
    
    function setAdmin($admin){
        $this->admin = $admin;
    }
    
    function getVerify(){
        return $this->verify;
    }
    
    function setVerify($verify){
        $this->verify = $verify;
    }
    
}