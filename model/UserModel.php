<?php

/**
* Usuario
*/
class Usuario {
	
	private $id;
	private $nombre;
	private $contrasenna;
	private $roles = array();

	function __construct($id, $nombre, $contrasenna, $rolesAct=array())
	{
		$this->id = $id;
		$this->nombre = $nombre;
		$this->contrasenna = $contrasenna;
		$this->roles = $rolesAct;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getNombre()
	{
		return $this->nombre;
	}
	public function getContresenna()
	{
		return $this->contrasenna;
	}
	public function getRoles()
	{
		return $this->roles;
	}
	public function setNombre($value)
	{
		$this->nombre = $value;
	}
	public function setContrasenna($value)
	{
		$this->contrasenna = $value;
	}
	public function setRoles($value)
	{
		$this->roles = $value;
	}
}