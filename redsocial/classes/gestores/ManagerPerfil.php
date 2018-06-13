<?php

class ManagerPerfil implements Manager{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'INSERT INTO perfil(name, surname, birthday, sex, idUsuario) VALUES (:name, :surname, :birthday, :sex, :idUsuario)';
        $params = array(
            'name' => $objeto->getName(),
            'surname' => $objeto->getSurname(),
            'birthday' => $objeto->getBirthday(),
            'sex' => $objeto->getSex(),
            'idUsuario' => $objeto->getIdUsuario()
        );
        
        $res = $this->db->execute($sql, $params);
        $id = 0;
        
        if($res){
            $id = $this->db->getId();
            $objeto->setId($id);
        }
        
        return $id;
    }
    
    function edit($objeto){
        $sql = 'UPDATE perfil SET name = :name, surname = :surname, birthday = :birthday, sex = :sex WHERE id = :id';
        $params = array(
            'name' => $objeto->getName(),
            'surname' => $objeto->getSurname(),
            'birthday' => $objeto->getBirthday(),
            'sex' => $objeto->getSex(),
            'id' => $objeto->getId()
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function get($id){
        $sql = 'SELECT * FROM perfil where id = :id';
        $params = array(
            'id' => $id,    
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $perfil = new Perfil;
        
        if($res && $row = $statement->fetch()){
            $perfil->set($row);
        }
        
        return $perfil;
    }
    
    function getByUser($idUser){
        $sql = 'SELECT * FROM perfil where idUsuario = :idUsuario';
        $params = array(
            'idUsuario' => $idUser,    
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $perfiles = array();
        
        if($res){
            while($row = $statement->fetch()){
                $perfil = new Perfil();
                $perfil->set($row);
                $perfiles[] = $perfil->get();
            }
        }
        
        return $perfiles;
    }
    
    function comprobate($id, $idUsuario){
        $sql = 'SELECT count(*) FROM perfil where id = :id AND idUsuario = :idUsuario;';
        $params = array('id' => $id, 'idUsuario' => $idUsuario);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        if($res){
            $r = $statement->fetch();
        }else{
            $r = 0;
        }
        
        return $r;
    }
    
    function getAll(){}
    
    function remove($id){}
    
    function search($id, $search){
        $sql = 'SELECT * FROM perfil WHERE idUsuario NOT IN (SELECT b.idUsuario FROM block b 
        join user u on b.idUsuario = u.id WHERE b.idBlock = :id) AND (name LIKE :search OR surname LIKE :search);';
        $params = array('search' => '%' . $search . '%', 'id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $perfiles = array();
        
        if($res){
            while($row = $statement->fetch()){
                $perfil = new Perfil();
                $perfil->set($row);
                $perfiles[] = $perfil;
            }
        }
        
        return $perfiles;
    }
    
    function getRandom(){
        $sql = 'SELECT * FROM perfil ORDER BY RAND() LIMIT 0 , 3';
        $database = new DataBase();
        $res = $database->execute($sql);
        $statement = $database->getStatement();
        //$res = $this->db->execute($sql);
        //$statement = $this->db->getStatement();
        
        $perfiles = array();
        
        if($res){
            while($row = $statement->fetch()){
                $perfil = new Perfil();
                $perfil->set($row);
                $perfiles[] = $perfil;
            }
        }
        
        return $perfiles;
    }
}