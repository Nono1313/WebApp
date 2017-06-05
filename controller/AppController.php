<?php

require_once('UserController.php');

/**
* Clase de Controlador Principal
*/
class AppController
{
	function Login(){
		include('../view/login.html');
	}
	function LoginCheck(){
		$nombre = $_POST["nombre"];
		$contrasenna = $_POST["password"];
		
		$error= '';
		if($nombre == '' && $contrasenna== ''){
			trigger_error('Error complete los datos');
			return;
		}

		$interface = new InterfaceModelo();	
		$user = $interface->getUsuario($nombre);

		if($user != null ){

			if($user->getContresenna() == $contrasenna){
				if( is_array($user->getRoles())){
					foreach ($user->getRoles() as $rol) {

						$_SESSION['login_user']= $nombre;

						header('Location:'.$rol->getPagPermitida());
						return;
					}
				}
				else{
					trigger_error('No existen Roles para el usuario');
				}
			}{
				trigger_error('Contraseña Incorrecta');
			}
		}
		else{
			trigger_error('No existen Usuario');
		}
	}
	function IndexRole1(){
		if($this->PuedeEntrar('PAGE_1'))
			include('../view/pageRole1.html');
		else
			trigger_error('Prohibido el acceso');
	}
	function IndexRole2(){
		if($this->PuedeEntrar('PAGE_2'))
			include('../view/pageRole2.html');
		else
			trigger_error('Prohibido el acceso');
	}
	function IndexRole3(){
		if($this->PuedeEntrar('PAGE_3'))
			include('../view/pageRole3.html');
		else
			trigger_error('Prohibido el acceso');
	}
	function Logout(){
		//destruir sesion
		session_unset();
		session_destroy();
		unset($_SESSION["login_user"]);
		unset($_SESSION["timeout"]);

		$url = 'login';
		header('Location:'.$url);
	}
	private function PuedeEntrar($page){
		$respuesta = false;

		if(!isset($_SESSION['login_user']))
			header('Location:login');
		
		$interface = new InterfaceModelo();	
		$user = $interface->getUsuario($_SESSION['login_user']);

		foreach ($user->getRoles() as $rol) {
			if($rol->getPagPermitida() == $page){
				$respuesta = true;
				break;
			}
		}
		return $respuesta;
	}
}