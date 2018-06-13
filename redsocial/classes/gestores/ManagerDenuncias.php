<?php

class ManagerDenuncias implements Manager{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'INSERT INTO denuncias(idUsuario, idDenunciado, motivo, resuelta) VALUES (:idUsuario, :idDenunciado, :motivo, 0)';
        $params = array(
            'idUsuario' => $objeto->getIdUsuario(),
            'idDenunciado' => $objeto->getIdDenunciado(), 
            'motivo' => $objeto->getMotivo() 
        );
        
        //echo 'hola' . Util::varDump($objeto);
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function edit($objeto){}
    
    function ress($idUsuario, $idDenunciado){
        $sql = 'UPDATE denuncias SET resuelta = 1 WHERE idUsuario = :idUsuario AND idDenunciado = :idDenunciado';
        $params = array(
            'idUsuario' => $idUsuario,
            'idDenunciado' => $idDenunciado
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function get($id){
        
    }
    
    function getAll(){
        $sql = 'SELECT * FROM denuncias';
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $denuncias = array();
        
        if($res){
            while($row = $statement->fetch()){
                $denuncia = new Denuncia();
                $denuncia->set($row);
                $denuncias[] = $denuncia;
            }
        }
        
        return $denuncias;
    }
    
    function getNoRess(){
        $sql = 'SELECT * FROM denuncias WHERE resuelta = 0';
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $denuncias = array();
        
        if($res){
            while($row = $statement->fetch()){
                $denuncia = new Denuncia();
                $denuncia->set($row);
                $denuncias[] = $denuncia;
            }
        }
        
        return $denuncias;
    }
    
    function remove($id){}
}