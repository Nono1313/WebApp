<?php

require_once('UserModel.php');
require_once('RolesModel.php');
/**
* Clase de interface con elmodelo
*/
class InterfaceModelo 
{
	private $Usuarios;

	public function getUsuario($nombre='')
	{
		$usuario = null;
		//si no especifica asumo que pide a todos
		if($nombre == ''){
			$usuario =  $this->getUsuarios();
			$this->setDefault();
		}
		else{
			$usuario = $this->findByNombre($nombre);
		}
		
		//Buscarlo aqui

		return $usuario;
	}

	private function cargaUsuarios()
	{
		# code...
	}
	private function guardaUsuarios()
	{
		# code...
	}

	private function getUsuarios()
	{
		//Los leo en archivo o de algun lado
	}

	private function findByNombre($nombre)
	{
		//Los leo en archivo o de algun lado
	}
	private function setDefault()
	{
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

		$objData = serialize( $this->Usuarios );

		if (is_writable('/home/nono/www/WebApp/model/usuarios.class')) {
		    $fp = fopen('/home/nono/www/WebApp/model/usuarios.class', "w"); 
		    fwrite($fp, $objData); 
		    fclose($fp);
		}
		else{
			echo '<h2>Error No Se puede Generar Archivo</h2>';
		}

	}

}