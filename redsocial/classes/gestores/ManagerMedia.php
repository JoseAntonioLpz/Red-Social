<?php

class ManagerMedia implements Manager{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'INSERT INTO media(idPubli, url) VALUES (:idPubli, :url);';
        $params = array(
            'idPubli' => $objeto->getIdPubli(),
            'url' =>$objeto->getUrl()
        );
        
        $res = $this->db->execute($sql, $params);
        
        $id = 0;
        
        if($res){
            $id = $this->db->getId();
            $objeto->setId($id);
        }
        
        return $id;
    }
    
    function edit($objeto){}
    
    function get($id){}
    
    function getAll(){}
    
    function remove($id){}
}    