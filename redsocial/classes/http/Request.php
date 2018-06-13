<?php

class Request{
	
	static function get($nombre) {
		if(isset($_GET[$nombre])){
			return $_GET[$nombre];
		}
		
		return null; 
	}
	
	static function getpost($nombre){
		$valor = self::get($nombre);
		
		if($valor == null){
			$valor = self::post($nombre);
		}
		
		return $valor;
	}
	
	static function post($nombre, $index = null){
		if($index === null){
			if(isset($_POST[$nombre])){
				return $_POST[$nombre];
			}
		}else{
			if(isset($_POST[$nombre])){
				return $_POST[$nombre][$index];
			}
		}
		return null; 
	}
	
	static function postget($nombre){ 
		$valor = self::post($nombre);
		
		if($valor == null){
			$valor = self::get($nombre);
		}
		
		return $valor;
	}
	
	static function read($nombre){
		return self::postget($nombre);
	}
}