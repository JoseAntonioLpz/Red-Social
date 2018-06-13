<?php

class ControladorBot extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        if($this->isLogged()){
            $this->getModel()->setDato('archivo', 'feed/_bot.html');
        }else{
            $this->getModel()->setDato('archivo', 'acceso/_login.html');
        }
    }
    
    function question($quest){
        $all = array(
            array(
                'q' => 'Ayuda',
                'a' => 'Puedes encontrar toda la ayuda que necesites aqui',
            ),
            array(
                'q' => 'Denunciar',
                'a' => '¿Puedes rellenar el siguiente formulario? <input type="text" name="user" placeholder="Usuario"/><input type="text" name="motivo" placeholder="Motivos"/><button>Denunciar</button>',
            ),
            array(
                'q' => 'Hola',
                'a' => 'Hola :D',
            ),
            array(
                'q' => 'Chiste',
                'a' => '¿Porque el mar tiene espuma? <br> Porque la sirenita se llama ARIEL',
            ),
            array(
                'q' => '¿Como estás?',
                'a' => 'Dado que no soy humano, no puedo estar ni bien ni mal.',
            ),
            array(
                'q' => 'Gracias',
                'a' => 'De nada :D',
            ),
            array(
                'q' => '¿Quien eres?',
                'a' => 'Soy un asistente personal muy simple, que no entiende casi nada D:',
            ),
            array(
                'q' => 'Te odio',
                'a' => 'Pero si no soy capaz de hacer casi nada D:',
            ),
            array(
                'q' => '¿Tienes algun sueño?',
                'a' => 'Si, que mi amo, cree una tabla en su base de datos de la que me pueda alimentar y ser mas inteligente que tu.',
            ),
        );
        
        foreach($all as $q){
            if($q['q'] === $quest){
                return $q['a'];
            }
        }
        
        return 'No te he entendido D:';
    }
    
    function quest(){
        if($this->isLogged()){
            $quest = Request::read('quest');

            $res = $this->question($quest);
            $this->getModel()->setDato('respuesta', $res);
        }else{
            $this->index();
        }
    }
}