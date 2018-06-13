<?php

class ManagerUser implements Manager{
    
    private $db; 
    
    function __construct($db = null){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'insert into user(user, email, password, date, admin, verify) VALUES (:user, :email, :password, :date, 0, 0)';
        $params = array(
            'user' => $objeto->getUser(),
            'email' => $objeto->getEmail(),
            'password' => Util::codificar($objeto->getPassword(), 10),
            'date' => $objeto->getDate(),
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
        
    }
    
    function getUsersDenunciados(){
        $sql = 'select u.id, u.user, u.email, u.date, d.idUsuario, d.motivo, d.resuelta from user u join denuncias d on u.id = d.idDenunciado';
        
        $res = $this->db->execute($sql);
        $statement = $this->db->getStatement();
        $users = array();
        
        if($res){ 
            while($row = $statement->fetch()){
                $users[] = array(
                    'id' => $row['id'],
                    'user' => $row['user'],
                    'email' => $row['email'],
                    'date' => $row['date'],
                    'idUsuario' => $row['idUsuario'],
                    'motivo' => $row['motivo'],
                    'resuelta' => $row['resuelta'],
                );
            }
        }
        return $users;
    }
    
    function getUsersDenunciadosCount(){
        $sql = 'SELECT count(*) FROM user u join denuncias d on u.id = d.idDenunciado';
        
        $res = $this->db->execute($sql);
        $statement = $this->db->getStatement();
        
        $r = 0;
        if($res && $row = $statement->fetch()){
            $r = $row[0];
        }
        
        return $r;
    }
    
    function getUserForLogin($param){
        $sql = 'select * from user where user = :param or email = :param';
        $params = array('param' => $param);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $user = new User();
        
        if($res && $row = $statement->fetch()){
            $user->set($row);
        }
        
        return $user;
    }
    
    function get($id){
        $sql = 'select * from user where id = :id';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        $user = new User();
        
        if($res && $row = $statement->fetch()){
            $user->set($row);
        }
        
        return $user;
    }
    
    function getAll(){}
    
    function getAllLimit($a, $b){
        $sql = 'SELECT * FROM user WHERE 1 LIMIT :a , :b';
        $params = array(
            'a' => array($a, PDO::PARAM_INT),
            'b' => array($b, PDO::PARAM_INT)
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $users = array();
        if($res){
            while($row = $statement->fetch()){
                $usuario = new User();
                $usuario->set($row);
                $users[] = $usuario;
            }
        }
        
        return $users;
    }
    
    function getCount(){
        $sql = 'SELECT count(*) FROM user';
        
        $res = $this->db->execute($sql);
        $statement = $this->db->getStatement();
        
        $r = 0;
        if($res && $row = $statement->fetch()){
            $r = $row[0];
        }
        
        return $r;
    }
    
    function comprobateUserName($user){
        $sql = 'select user from user where user = :user';
        $params = array(
            'user' => $user    
        );
        
        $res = $this->db->execute($sql, $params);
        $rows = $this->db->getRowNumber();
        $r = 0;
        
        if($res && $rows > 0){
            $r = 1;
        }
        
        return $r;
    }
    
    function remove($id){
        $sql = 'DELETE FROM user WHERE id = :id';
        $params = array(
            'id' => $id    
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function verify($id){
        $sql = 'UPDATE user SET verify = 1 WHERE id = :id';
        
        $params = array(
            'id' => $id    
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function noVerify($id){
        $sql = 'UPDATE user SET verify = 0 WHERE id = :id';
        
        $params = array(
            'id' => $id    
        );
        
        $res = $this->db->execute($sql, $params);
        
        return $res;
    }
    
    function getIdUserByIdPerfil($id){
        $sql = 'select u.id from user u join perfil p on u.id = p.idUsuario where p.id = :id';
        
        $params = array(
            'id' => $id    
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $id = ($res) ? $statement->fetch()[0] : 0;
        
        return $id;
    }
    
    function getUserNameByIdPerfil($id){
        $sql = 'select u.user from user u join perfil p on u.id = p.idUsuario where p.id = :id';
        
        $params = array(
            'id' => $id    
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $name = ($res) ? $statement->fetch()[0] : '';
        
        return $name;
    }
    
    function getUserIdByUser($user){
        $sql = 'select id from user where user = :user';
        
        $params = array(
            'user' => $user    
        );
        
        $res = $this->db->execute($sql, $params);
        $statement = $this->db->getStatement();
        
        $id = ($res) ? $statement->fetch()[0] : 0;
        
        return $id;
    }
}