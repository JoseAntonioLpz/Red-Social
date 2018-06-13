<?php

class ManagerSeguidor{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function follow($objeto){
        $sql = 'INSERT INTO follow(idPerfil, idFollow) VALUES (:idPerfil, :idFollow)';
        $params = array(
            'idPerfil' => $objeto->getIdPerfil(),
            'idFollow' => $objeto->getIdFollow()
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function countFollow($id){
        $sql = 'SELECT count(*) from follow where idPerfil = :id';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        if($res && $row = $statement->fetch()){
            return $row[0];
        }
        
        return 0;
    }
    
    function countFollowers($id){
        $sql = 'SELECT count(*) from follow where idFollow = :id';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        if($res && $row = $statement->fetch()){
            return $row[0];
        }
        
        return 0;
    }
    
    function unfollow($objeto){
        $sql = 'DELETE FROM follow WHERE idPerfil = :idPerfil AND idFollow = :idFollow';
        $params = array(
            'idPerfil' => $objeto->getIdPerfil(),
            'idFollow' => $objeto->getIdFollow()
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function isFollower($id, $idPerfil){
        $sql = 'SELECT count(*) FROM follow WHERE idPerfil = :idPerfil AND idFollow = :idFollow;';
        $params = array(
            'idPerfil' => $idPerfil,
            'idFollow' => $id
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        if($res && $row = $statement->fetch()){
            return $row[0];
        }
        
        return 0;
    }
    
}    