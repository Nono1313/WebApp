<?php

require_once('../model/InterfaceModelo.php');
/**
* Clase de usuarios
*/
class UserController
{
	
	function __construct()
	{
		# carga de archivo
	}

	function createUser(){

	}
	function readUser($nombre=''){		
		if ($nombre == '') {
			echo('Listo Todos');
			$interface = new InterfaceModelo();
			$interface->getUsuario($nombre);
		}
		else{
			echo('hola: '.$nombre);
		}
	}
	function updateUser(){

	}
	function deleteUser(){

	}
}