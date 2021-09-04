<?php

/**
 * CambiarEstadoCambio
 *
 * @author Marcos
 * @since 08-06-2015
 */

class CambiarEstadoCambio extends Entity{

	//variables de instancia.
	
	

	private $cambio;
	
	private $estado;
	
	private $motivo;
	

	public function __construct(){
		
		$this->cambio = new Cambio();
		
		$this->estado = new Estado();
		
		$this->motivo = "";
		
	}



	public function getCambio()
	{
	    return $this->cambio;
	}

	public function setCambio($cambio)
	{
	    $this->cambio = $cambio;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	public function getMotivo()
	{
	    return $this->motivo;
	}

	public function setMotivo($motivo)
	{
	    $this->motivo = $motivo;
	}
}
?>