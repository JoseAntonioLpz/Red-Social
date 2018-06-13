<?php

class ManagerComentario implements Manager{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'INSERT INTO comentarios(idPerfil, idPost, texto) VALUES (:idPerfil, :idPost, :texto)';
        $params = array(
            'idPerfil' => $objeto->getIdPerfil(),
            'idPost' => $objeto->getIdPost(),
            'texto' => $objeto->getTexto(),
        );
        
        $res = $this->db->execute($sql, $params);
        
        $r = ($res) ? $this->db->getId() : false;
        
        if($r){
            $objeto->setId($r);
        }
        
        return ($r) ? $objeto : $r;
    }
    
    function edit($objeto){}
    
    function get($id){
        $sql = 'SELECT c.id, c.idPost, c.texto, p.id, p.name, p.surname FROM comentarios c join perfil p on c.idPerfil = p.id  WHERE c.idPost = :idPost';
        $params = array(
            'idPost' => $id
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $comments = array();
        
        if($res){
            while($row = $statement->fetch()){
                $comment = new Comentario();
                $comment->set($row);
                $comments[] = array(
                    'id' => $row[0],
                    'idPost' => $row[1],
                    'texto' => $row[2],
                    'idUser' => $row[3],
                    'name' => $row[4],
                    'surname' => $row[5],
                );
            }
        }
        
        return $comments;
    }
    
    function getAll(){}
    
    function remove($id){}
}    