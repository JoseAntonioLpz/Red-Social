<?php

class ControladorUser extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        /*if($this->isLogged()){
            if($this->getUser()->getAdmin() === '1'){
                $this->getModel()->setDato('archivo' , 'admin/_index.html');
                $this->renderUsersAdmin();
            }else{
                $this->getModel()->setDato('archivo' , 'acceso/_profiles.html');
            }
        }else{
            $this->getModel()->setDato('archivo' , 'admin/_denuncias.html');
        }*/
        if($this->isAdmin()){
            $this->getModel()->setDato('archivo' , 'admin/_index.html');
            $this->renderUsersAdmin();
        }elseif($this->isProfile()){
            $this->getModel()->setDato('archivo' , 'acceso/_profiles.html');
        }elseif($this->isLogged()){
            $this->getModel()->setDato('archivo' , 'acceso/_profiles.html');
        }else{
            $this->getModel()->setDato('archivo' , 'acceso/_login.html');
        }
    }
    
    function denAdmin(){
        if($this->isAdmin()){
            $this->getModel()->setDato('archivo' , 'admin/_denuncias.html');
            $this->renderUsersDenAdmin();
        }else{
            $this->index();
        }
    }
     
    function register(){
         $this->getModel()->setDato('archivo' , 'acceso/_register.html');
    }
    
    function adduser(){
        $user = new User();
        
        //echo Util::varDump($user);
        
        $user->read();
        $user->setDate(date("Y-m-d H:i:s"));
        
    	$recaptcha = Request::read('g-recaptcha-response');
    	
    	$url = 'https://www.google.com/recaptcha/api/siteverify';
    	$data = array(
    		'secret' => '6Lc7lVEUAAAAACbZzWl7ggiywhZ_gaMky0dK5iKd',
    		'response' => $recaptcha
    	);
    	$options = array(
    		'http' => array (
    			'method' => 'POST',
    			'content' => http_build_query($data)
    		)
    	);
    	
    	$context = stream_context_create($options);
    	
    	$verify = file_get_contents($url, false, $context);
    	
    	$captcha_success = json_decode($verify);
    	if ($captcha_success->success && $user->getPassword() === Request::read('passRep')) {
    	    
            $res = $this->getModel()->addUser($user);
            if($res){
                $mensaje = 'https://la-red-social-joseantoniolpz.c9users.io/redsocial/user/verify?id=' . $user->getId() . '&data=' . sha1('go' . $user->getId() . $user->getEmail());
                $r = Util::sendMail($user->getEmail(), 'Verifique su identidad', $mensaje);
                $this->getModel()->setDato('mensajes' , 'Alta satisfactoria');        
            }else{
                $this->getModel()->setDato('mensajes' , 'Alta no satisfactoria'); 
            }
            
            $controler = new Controlador($this->getModel());
            
            $controler->index();
    	} else {
            echo 'Captcha mal';
    	}
    }
    
    function comprobateUser(){
        $user = Request::read('user');
        $res = $this->getModel()->comprobateUser($user);
        $this->getModel()->setDato('data' , $res);
    }
    
    function login(){
        $param = Request::read('login');
        $pass = Request::read('pass');
        $user = $this->getModel()->getUserForLogin($param);
        if(Util::validarCodificacion($pass, $user->getPassword())){
            $this->getSession()->login($user);
            if($user->getAdmin() === '1'){
                $this->getModel()->setDato('archivo' , 'admin/_index.html');
                $this->getModel()->setDato('header', 'templates/includes/_header_admin.html');
                $this->renderUsersAdmin();
            }else{
                $this->getModel()->setDato('header', 'templates/includes/_header_user.html');
                $this->getModel()->setDato('archivo' , 'acceso/_profiles.html');
            }
        }else{
            $this->getModel()->setDato('archivo' , 'acceso/_login.html');
            $this->getModel()->setDato('mensajes' , 'Usuario o contraseña incorrecta'); 
        }
    }
    
    function logout(){
        $this->getSession()->logout();
        $this->getModel()->setDato('header', 'templates/includes/_header.html');
        $this->index();
    }
    
    function renderUsersAdmin(){
        if($this->isLogged()){
            if($this->getUser()->getAdmin() === '1'){
                $page = Request::read('page');
                if($page < 1){
                    $page = 1;
                }
                $count = $this->getModel()->getCount();
                $pagination = new Pagination($count, $page, 30);
                $a = $pagination->getOffset();
                $b = $pagination->getRpp();
                $users = $this->getModel()->getUsers($a, $b);
                $htmlUsers = '<tr><td>{{id}}</td><td>{{user}}</td><td>{{email}}</td><td>{{date}}</td><td>{{admin}}</td>
                <td>{{verify}}</td><td><a href="user/baja?id={{id}}">Banear</a></td>
                <td><a href="user/verify?id={{id}}">Verificar</a></td></tr>';
                $usersCadena = '';
                foreach($users as $user){
                    $usersCadena .= Util::renderText($htmlUsers, $user->get());
                }
                $paginationCadena = '<a href="user/index?page=' . $pagination->getFirst() . '">First</a>';
                $paginationCadena .= '<a href="user/index?page=' . $pagination->getPrevius() . '">Prev</a>';
                
                foreach($pagination->getRange(5) as $page){
                    $paginationCadena = '<a href="user/index?page=' . $page . '">' . $page . '</a>';
                }
                
                $paginationCadena .= '<a href="user/index?page=' . $pagination->getNext() . '">Next</a>';
                $paginationCadena .= '<a href="user/index?page=' . $pagination->getLast() . '">Last</a>';
                
                $this->getModel()->setDato('paginate', $paginationCadena);
                $this->getModel()->setDato('adminUsers', $usersCadena);
            }else{
                $this->index();
            }
        }else{
            $this->index();
        }
    }
    
    function renderUsersDenAdmin(){
        if($this->isAdmin()){
            $page = Request::read('page');
                if($page < 1){
                    $page = 1;
                }
                $count = $this->getModel()->getUsersDenunciadosCount();
                $pagination = new Pagination($count, $page, 30);
                $a = $pagination->getOffset();
                $b = $pagination->getRpp();
                $users = $this->getModel()->getUsersDenunciados($a, $b);
                $htmlUsers = '<tr><td>{{id}}</td><td>{{user}}</td><td>{{email}}</td>
                <td>{{date}}</td><td>{{idUsuario}}</td><td>{{motivo}}</td><td>{{resuelta}}</td>
                <td><a href="denuncias/ress?idUsuario={{idUsuario}}&idDenunciado={{id}}">Resolver</a>
                </td></tr>';
                $usersCadena = '';
                foreach($users as $user){
                    $usersCadena .= Util::renderText($htmlUsers, $user);
                }
                $paginationCadena = '<a href="user/denAdmin?page=' . $pagination->getFirst() . '">First</a>';
                $paginationCadena .= '<a href="user/denAdmin?page=' . $pagination->getPrevius() . '">Prev</a>';
                
                foreach($pagination->getRange(5) as $page){
                    $paginationCadena = '<a href="user/denAdmin?page=' . $page . '">' . $page . '</a>';
                }
                
                $paginationCadena .= '<a href="user/denAdmin?page=' . $pagination->getNext() . '">Next</a>';
                $paginationCadena .= '<a href="user/denAdmin?page=' . $pagination->getLast() . '">Last</a>';
                
                $this->getModel()->setDato('paginate', $paginationCadena);
                $this->getModel()->setDato('adminUsers', $usersCadena);
                
        }else{
            $this->index();
        }
    }
    
    /*function renderDenunciasAdmin(){
        if($this->isAdmin()){
            $page = Request::read('page');
                if($page < 1){
                    $page = 1;
                }
        }else{
            $this->index();
        }
    }*/
    
    function baja(){
        if($this->isLogged()){
            if($this->getUser()->getAdmin() === '1'){
                $id = Request::read('id');
                $this->getModel()->baja($id);
                $this->index();
            }else{
                $this->index();
            }
        }else{
            $this->index();
        }    
    }
    
    function verify(){
        if($this->isLogged()){
            if($this->getUser()->getAdmin() === '1'){
                $id = Request::read('id');
                $user = $this->getModel()->get($id);
                if($user->getVerify() === '1'){
                    $this->getModel()->noVerify($id);
                }else{
                    $this->getModel()->verify($id);
                }
                $this->index();
            }else{
                $this->index();
            }
        }else{
            $this->index();
        }
    }
}