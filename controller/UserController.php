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
		if(!$this->PuedeEntrar())
			header('Location:login');
		$PAGE_1 = false;
		$PAGE_2 = false;
		$PAGE_3 = false;

		//
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if( isset($_POST["nombre"]) && isset($_POST["password"]) ){

				$interface = new InterfaceModelo();
				$roles = array();
				if(isset($_POST['rol1'])){
					$rol = new Roles(1,'PAGE_1');
					array_push($roles, $rol);
				}
				if(isset($_POST['rol2'])){
					$rol = new Roles(1,'PAGE_2');
					array_push($roles, $rol);
				}
				if(isset($_POST['rol3'])){
					$rol = new Roles(1,'PAGE_3');
					array_push($roles, $rol);
				}
				if($_POST["nombre"] == '' || $_POST["password"] == ''){
					trigger_error('Ingrese Nombre de usuario y contraseña');
					return;
				}
				if(count($roles) == 0){
					trigger_error('Ingrese por lo menos un rol');
				}
				$user = new Usuario(1,$_POST["nombre"], $_POST["password"], $roles);
				if($interface->creaUsuario($user)){
					header('Location:/users');
				}
			}
			else{
				trigger_error('Ingrese los datos necesairios');
			}
		}
		$user = new Usuario('', '', '', array());
		include ('../view/UserCreate.html');
	}
	function readUser($nombre=''){
		if(!$this->PuedeEntrar())
			header('Location:login');
		$interface = new InterfaceModelo();
		$editable = false;
		//leo todos los usarios
		if ($nombre == '') {
			$usuarios = $interface->getUsuario('');
			if($_SESSION['login_user'] == 'ADMIN')
				$editable = true;
			include ('../view/UsersRead.html');
		}
		//Leo usuario en especifico
		else{
			$user = $interface->getUsuario($nombre);
			if($user !=null){
				include ('../view/UserRead.html');
			}
			else{
				trigger_error("Usuario No Existe");
			}

		}
	}
	function updateUser($nombre=''){
		if(!$this->PuedeEntrar())
			header('Location:login');
		$interface = new InterfaceModelo();

		$user = $interface->getUsuario($nombre);
		
		include ('../view/UserCreate.html');
	}
	function deleteUser($nombre=''){
		if(!$this->PuedeEntrar())
			header('Location:login');

		echo "Eliminado: ".$nombre;

		$interface = new InterfaceModelo();
		$interface->deleteUsuario($nombre);
	}
	private function PuedeEntrar(){
		$respuesta = false;

		if(!isset($_SESSION['login_user']))
			header('Location:/login');
		
		return true;
	}
}