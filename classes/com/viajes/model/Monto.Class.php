<?php

/**
 * Monto
 *
 * @author Marcos
 * @since 21-11-2013
 */

class Monto extends Entity{

	//variables de instancia.
	
	private $solicitud;
	
	
	private $nu_monto;
	
	
	
	private $ds_institucion;
	
	
	
	private $ds_caracter;
	
	


	public function __construct(){
		 
		$this->solicitud = new Solicitud();
		
		
			
		$this->nu_monto = "";
		
		
		
		$this->ds_institucion = "";
		
		
		
		$this->ds_caracter = "";
		
		
	}




	

	 

	

	

	

	

	public function getSolicitud()
	{
	    return $this->solicitud;
	}

	public function setSolicitud($solicitud)
	{
	    $this->solicitud = $solicitud;
	}

	public function getNu_monto()
	{
	    return $this->nu_monto;
	}

	public function setNu_monto($nu_monto)
	{
	    $this->nu_monto = $nu_monto;
	}

	public function getDs_institucion()
	{
	    return $this->ds_institucion;
	}

	public function setDs_institucion($ds_institucion)
	{
	    $this->ds_institucion = $ds_institucion;
	}

	public function getDs_caracter()
	{
	    return $this->ds_caracter;
	}

	public function setDs_caracter($ds_caracter)
	{
	    $this->ds_caracter = $ds_caracter;
	}
}
?>