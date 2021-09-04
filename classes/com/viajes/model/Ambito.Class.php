<?php

/**
 * Ambito
 *
 * @author Marcos
 * @since 17-11-2013
 */

class Ambito extends Entity{

	//variables de instancia.
	
	private $solicitud;
	
	
	private $dt_desde;
	
	private $dt_hasta;
	
	private $ds_institucion;
	
	
	
	private $ds_pais;
	private $ds_ciudad;
	


	public function __construct(){
		 
		$this->solicitud = new Solicitud();
		
		
			
		$this->dt_desde = "";
		
		$this->dt_hasta = "";
		
		$this->ds_institucion = "";
		
		
		
		$this->ds_pais = "";
		
		$this->ds_ciudad = "";
	}




	

	 

	

	

	

	public function getSolicitud()
	{
	    return $this->solicitud;
	}

	public function setSolicitud($solicitud)
	{
	    $this->solicitud = $solicitud;
	}

	public function getDt_desde()
	{
	    return $this->dt_desde;
	}

	public function setDt_desde($dt_desde)
	{
	    $this->dt_desde = $dt_desde;
	}

	public function getDt_hasta()
	{
	    return $this->dt_hasta;
	}

	public function setDt_hasta($dt_hasta)
	{
	    $this->dt_hasta = $dt_hasta;
	}

	public function getDs_institucion()
	{
	    return $this->ds_institucion;
	}

	public function setDs_institucion($ds_institucion)
	{
	    $this->ds_institucion = $ds_institucion;
	}

	public function getDs_pais()
	{
	    return $this->ds_pais;
	}

	public function setDs_pais($ds_pais)
	{
	    $this->ds_pais = $ds_pais;
	}

	

	public function getDs_ciudad()
	{
	    return $this->ds_ciudad;
	}

	public function setDs_ciudad($ds_ciudad)
	{
	    $this->ds_ciudad = $ds_ciudad;
	}
}
?>