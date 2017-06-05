<?php

require_once('UserModel.php');
require_once('RolesModel.php');
/**
* Clase de interface con elmodelo
*/
class InterfaceModelo 
{
	private $Usuarios;

	function __construct()
	{
		$this->cargaUsuarios();
	}

	public function getUsuario($nombre='')
	{
		$usuario = null;
		//si no especifica asumo que pide a todos
		if($nombre == ''){
			$usuario =  $this->Usuarios;
		}
		else{
			$usuario = $this->findByNombre($nombre);
		}
		return $usuario;
	}
	public function creaUsuario($user)
	{
		if ($this->findByNombre($user->getNombre()) != null ) {
			trigger_error('Error Usuario Ya agregado');
		}
		else{
			array_push($this->Usuarios, $user);
			$this->guardaUsuarios();
		}
	}
	public function deleteUsuario($userDelete)
	{
		$Posicion = -1;
		foreach ($this->Usuarios as $key => $user) {
			if($userDelete == $user->getNombre()){
				$Posicion = $key;
			}
		}
		if($Posicion == -1){
			trigger_error('No se puede eliminar el usuario');
			return;
		}
		else{
			unset($this->Usuarios[$Posicion]);
			$this->guardaUsuarios();
		}
		
	}
	private function cargaUsuarios()
	{
		global $path;
		$fp = fopen($path, "r"); 

		if(!$fp){
			trigger_error("No se puedo cargar el archivo");
		    return;
		}
		$users = base64_decode( fread($fp, filesize($path) ) ); 

		$this->Usuarios = unserialize( $users );
		fclose($fp);
		return;
	}
	private function guardaUsuarios()
	{
		global $path;
		$objData = base64_encode( serialize( $this->Usuarios ) );

		if (is_writable($path)) {
		    $fp = fopen($path, "wb"); 
		    fwrite($fp, $objData); 
		    fclose($fp);
		}
		else{
			trigger_error('403: Error No Se puede Generar Archivo');
		}
		return;
	}
	private function findByNombre($nombre)
	{
		if($nombre == ''){
			return $this->Usuarios;
		}
		else{
			foreach ($this->Usuarios as $user) {
				if($user->getNombre() == $nombre){
					return $user;
				}
			}
		}
		return null;
	}
	private function setDefault()
	{
		global $path;
		$role1 = new Roles(1,'PAGE_1');
		$role2 = new Roles(2,'PAGE_2');
		$role3 = new Roles(3,'PAGE_3');

		$permisos = array($role1, $role2, $role3);
		$user1 = new Usuario(1,'ADMIN','ADMIN', $permisos );
		$user2 = new Usuario(2,'rol1','rol1', array($role1) );
		$user3 = new Usuario(3,'rol2','rol2', array($role2) );
		$user4 = new Usuario(4,'rol3','rol3', array($role3) );
		$user5 = new Usuario(5,'rol4','rol4', array($role1, $role2) );

		$this->Usuarios = array($user1, $user2, $user3, $user4, $user5);

		$this->guardaUsuarios();
	}

}