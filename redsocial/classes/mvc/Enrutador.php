<?php

class Enrutador {
    
    private $rutas = array();

    function __construct() {
        $this->rutas['index'] = new Ruta('Modelo' , 'Vista', 'Controlador');
        
        $this->rutas['user'] = new Ruta('ModeloUser' , 'Vista', 'ControladorUser');
        $this->rutas['user_ajax'] = new Ruta('ModeloUser' , 'VistaAjax', 'ControladorUser');
        
        $this->rutas['perfil'] = new Ruta('ModeloPerfil' , 'Vista', 'ControladorPerfil');
        $this->rutas['perfil_ajax'] = new Ruta('ModeloPerfil' , 'VistaAjax', 'ControladorPerfil');
        
        $this->rutas['follow'] = new Ruta('ModeloSeguidor' , 'VistaAjax', 'ControladorSeguidor');
        
        $this->rutas['block'] = new Ruta('ModeloBlock' , 'VistaAjax', 'ControladorBlock');
        
        $this->rutas['post'] = new Ruta('ModeloPost' , 'Vista', 'ControladorPost');
        $this->rutas['post_ajax'] = new Ruta('ModeloPost' , 'VistaAjax', 'ControladorPost');
        
        $this->rutas['like'] = new Ruta('ModeloLike' , 'VistaAjax', 'ControladorLike');
        
        $this->rutas['comment'] = new Ruta('ModeloComentario' , 'VistaAjax', 'ControladorComentario');
        
        $this->rutas['bot_ajax']  = new Ruta('Modelo' , 'VistaAjax', 'ControladorBot');
        $this->rutas['bot']  = new Ruta('Modelo' , 'Vista', 'ControladorBot');
        
        $this->rutas['denuncias']  = new Ruta('ModeloDenuncia' , 'Vista', 'ControladorDenuncia');
        $this->rutas['denuncia_ajax']  = new Ruta('ModeloDenuncia' , 'VistaAjax', 'ControladorDenuncia');
    }

    function getRoute($ruta) {
        if (!isset($this->rutas[$ruta])) {
            return $this->rutas['index'];
        }
        return $this->rutas[$ruta];
    }
}