<?php

class ManagerPost{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'INSERT INTO post (idPerfil, texto, media, fecha) VALUES (:idPerfil, :texto, :media, :fecha)';
        $params = array(
            'idPerfil' => $objeto->getIdPerfil(),
            'texto' => $objeto->getTexto(),
            'media' => $objeto->getMedia(),
            'fecha' => $objeto->getFecha(),
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
    
    function get($id, $a, $b){
        /*$sql = 'SELECT po.id, po.texto, po.media, po.fecha, pe.id ,pe.name, pe.surname FROM post po join 
        perfil pe on po.idPerfil = pe.id WHERE pe.id IN (SELECT idFollow FROM follow 
        WHERE idPerfil = :id) OR pe.id = :id order by po.fecha desc limit :a , :b;';*/
        
        $sql = 'SELECT po.id, po.texto, po.media, po.fecha, pe.id ,pe.name, pe.surname FROM post po 
        join perfil pe on po.idPerfil = pe.id WHERE pe.id IN (SELECT idFollow FROM follow WHERE idPerfil = :id) 
        AND pe.idUsuario NOT IN (SELECT b.idUsuario FROM block b 
        join user u on b.idUsuario = u.id WHERE b.idBlock in(SELECT p.idUsuario from perfil p where p.id = :id)) 
        OR pe.id = :id order by po.fecha desc limit :a , :b;';
        
        $params = array(
            'id' => $id,
            'a' => array($a, PDO::PARAM_INT),
            'b' => array($b, PDO::PARAM_INT),
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $ml = new ManagerLike($this->db);
        $mc = new ManagerComentario($this->db);
        $posts = array();
        if($res){
            while($row = $statement->fetch()){
                $post = array(
                    'id' => $row[0],
                    'idPerfil' => $row[4],
                    'texto' => $row['texto'],
                    'media' => $row['media'],
                    'name' => $row['name'],
                    'surname' => $row['surname'],
                    'fecha' => $row['fecha'],
                    'likes' => $ml->countLikesPost($row[0]),
                    'comentarios' => $mc->get($row[0])
                );
                
                $posts[] = $post;
            }
        }
        
        return $posts;
    }
    
    function getSinglePost($id){
        $sql = 'SELECT po.id, po.texto, po.fecha, po.media, pe.id ,pe.name, pe.surname FROM post po join 
        perfil pe on po.idPerfil = pe.id WHERE pe.id = :id order by po.fecha desc;';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $ml = new ManagerLike($this->db);
        $mc = new ManagerComentario($this->db);
        $posts = array();
        if($res){
            while($row = $statement->fetch()){
                $post = array(
                    'id' => $row[0],
                    'idPerfil' => $row[4],
                    'texto' => $row['texto'],
                    'media' => $row['media'],
                    'name' => $row['name'],
                    'surname' => $row['surname'],
                    'fecha' => $row['fecha'],
                    'likes' => $ml->countLikesPost($row[0]),
                    'comentarios' => $mc->get($row[0])
                );
                
                $posts[] = $post;
            }
        }
        
        return $posts;
    }
    
    function getById($id){
        $sql = 'SELECT * from post where id = :id;';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $post = new Post();
        
        if($res && $row = $statement->fetch()){
            $post->set($row);
        }
        
        return $post;
    }
    
    function getPostCompleteById($id){
        $sql = 'SELECT po.id, po.texto, po.fecha, po.media, pe.id ,pe.name, pe.surname FROM post po join 
        perfil pe on po.idPerfil = pe.id WHERE po.id = :id';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $post = null;
        
        if($res && $row = $statement->fetch()){
            $post = array(
                'id' => $row[0],
                'idPerfil' => $row[4],
                'texto' => $row['texto'],
                'media' => $row['media'],
                'name' => $row['name'],
                'surname' => $row['surname'],
                'fecha' => $row['fecha'],
            );    
        }
        
        return $post;
    }
    
    function countPost($idPerfil){
        $sql = 'SELECT count(*) FROM post WHERE idPerfil = :idPerfil';
        $params = array('idPerfil' => $idPerfil);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $r = 0;
        
        if($res && $row = $statement->fetch()){
            $r = $row[0]; 
        }
        
        return $r;
    }
    
    function countPostForPaginate($id){
        $sql = 'SELECT count(*) FROM post po join perfil pe on 
        po.idPerfil = pe.id WHERE pe.id IN (SELECT idFollow FROM 
        follow WHERE idPerfil = :id) OR pe.id = :id;';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();

        $count = 0;
        
        if($res && $row = $statement->fetch()){
           $count = $row[0];
        }
        
        return $count;
    }
    
    function search($id, $search){
        $sql = 'SELECT po.id, po.texto, po.fecha, po.media, pe.id ,pe.name, pe.surname FROM post po join 
        perfil pe on po.idPerfil = pe.id WHERE po.texto LIKE :search AND pe.idUsuario NOT IN (SELECT b.idUsuario FROM block b 
        join user u on b.idUsuario = u.id WHERE b.idBlock = :id) order by po.fecha desc;';
        $params = array('search' => '%' . $search . '%', 'id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $ml = new ManagerLike($this->db);
        $mc = new ManagerComentario($this->db);
        $posts = array();
        if($res){
            while($row = $statement->fetch()){
                $post = array(
                    'id' => $row[0],
                    'idPerfil' => $row[4],
                    'texto' => $row['texto'],
                    'media' => $row['media'],
                    'name' => $row['name'],
                    'surname' => $row['surname'],
                    'fecha' => $row['fecha'],
                    'likes' => $ml->countLikesPost($row[0]),
                    'comentarios' => $mc->get($row[0])
                );
                
                $posts[] = $post;
            }
        }
        
        return $posts;
    }
    
    function getAll(){}
    
    function remove($id){}
}    