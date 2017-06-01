<?php

/**
* Roles
*/
class Roles
{
	private $id;
	private $pagPermitida;
	
	function __construct($idNuevo, $pagPermitidaNueva)
	{
		$this->id = $idNuevo;
		$this->pagPermitida = $pagPermitidaNueva;
	}
	public function getPagPermitida(){
		return $this->pagPermitida;
	}
	public function setPagPermitida($pagPermitidaNueva){
		$this->pagPermitida = $pagPermitidaNueva;
	}
}