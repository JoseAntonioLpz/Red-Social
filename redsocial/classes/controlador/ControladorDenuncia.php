<?php

class ControladorDenuncia extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        echo 'index denuncia';
    }
    
    function add(){
        if($this->isProfile()){
            $user = Request::read('user');
            //echo $user;
            $motivo = Request::read('motivo');
            $mu = new ModeloUser($this->getModel()->getDataBase());
            $id = $mu->getUserIdByUser($user);
            //echo 'hola' . $id;
            //exit;
            $denuncia = new Denuncia(0, $this->getUser()->getId(), $id, $motivo, 0);
            
            $res = $this->getModel()->add($denuncia);
            
            $res = ($res) ? 'Denuncia completada' : 'No se ha podido cursar la denuncia';
            
            $this->getModel()->setDato('data', $res);
        }else{
            $this->index();
        }
    }
    
    function ress(){
        if($this->isAdmin()){
            $idDenunciado = Request::read('idDenunciado');
            $idUsuario = Request::read('idUsuario');
            $res = $this->getModel()->ress($idUsuario, $idDenunciado);
            
            //$this->getModel()->setDato('archivo', 'admin/_index.html');
            
            header('Location: https://la-red-social-joseantoniolpz.c9users.io/redsocial/user/denAdmin');
            exit;
        }else{
            $this->index();
        }
    }
}