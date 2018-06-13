<?php

class ManagerBloqueado{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function block($objeto){
        
        //echo Util::varDump($objeto);
        $sql = 'INSERT INTO block(idUsuario, idBlock) VALUES (:idUsuario, :idBlock)';
        $params = array(
            'idUsuario' => $objeto->getIdUsuario(),
            'idBlock' => $objeto->getIdBlock()
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }

    function unblock($objeto){
        $sql = 'DELETE FROM block WHERE idBlock = :idBlock AND idUsuario = :idUsuario';
        $params = array(
            'idUsuario' => $objeto->getIdUsuario(),
            'idBlock' => $objeto->getIdBlock()
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function isBlock($id, $idUsuario){
        $sql = 'SELECT count(*) FROM block WHERE idBlock = :idBlock AND idUsuario = :idUsuario;';
        $params = array(
            'idBlock' => $id,
            'idUsuario' => $idUsuario
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        if($res && $row = $statement->fetch()){
            return $row[0];
        }
        
        return 0;
    }
    
}    