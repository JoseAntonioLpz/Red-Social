<?php

class ManagerLike{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'INSERT INTO likes(idPost, idPerfil) VALUES (:idPost, :idPerfil)';
        $params = array(
            'idPost' => $objeto->getIdPost(),
            'idPerfil' => $objeto->getIdPerfil()
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function remove($objeto){
        $sql = 'DELETE FROM likes WHERE idPost = :idPost AND idPerfil = :idPerfil';
        $params = array(
            'idPost' => $objeto->getIdPost(),
            'idPerfil' =>$objeto->getIdPerfil()
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function exist($objeto){
        $sql = 'SELECT count(*) FROM likes WHERE idPerfil = :idPerfil && idPost = :idPost';
        $params = array(
            'idPost' => $objeto->getIdPost(),
            'idPerfil' =>$objeto->getIdPerfil()
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $r = false;
        
        if($res && $row = $statement->fetch()){
            $r = $row[0];
        }
        
        return $r;
    }
    
    function countLikesPost($idPost){
        $sql = 'SELECT count(*) FROM likes WHERE idPost = :idPost';
        $params = array(
            'idPost' => $idPost
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $r = false;
        
        if($res && $row = $statement->fetch()){
            $r = $row[0];
        }
        
        return $r;
    }
    
    function countLikesPerfil($idPerfil){
        $sql = 'SELECT count(*) FROM likes WHERE idPerfil = :idPerfil';
        $params = array(
            'idPerfil' => $idPerfil
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $r = false;
        
        if($res && $row = $statement->fetch()){
            $r = $row[0];
        }
        
        return $r;
    }
}    