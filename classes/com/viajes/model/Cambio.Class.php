<?php

/**
 * Cambio
 *
 * @author Marcos
 * @since 08-06-2015
 */

class Cambio extends Entity{

	//variables de instancia.
	
	private $ds_investigador;
	private $nu_cuil;

	private $estado;
	
	private $solicitud;
	
	private $ds_archivo;
	
	  private $dt_fecha;
	 
	  private $ambitos;
	  
	  private $presupuestos;
	 
	  private $ds_observacion;
	  
	
	public function __construct(){
		 
			$this->ds_investigador = '';
		   
		   $this->nu_cuil = '';
		
		  $this->solicitud = new Solicitud();
		  
		 
		  
		   $this->ds_archivo = '';
		   
		  
		  $this->dt_fecha = '';
		  
		  $this->ambitos= new ItemCollection();
		  
		  $this->presupuestos= new ItemCollection();
		  
		  $this->ds_observacion = '';
		  
	}




	

    
	public function __toString(){
		
		return "";
	}

	

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	public function getSolicitud()
	{
	    return $this->solicitud;
	}

	public function setSolicitud($solicitud)
	{
	    $this->solicitud = $solicitud;
	}

	public function getDs_archivo()
	{
	    return $this->ds_archivo;
	}

	public function setDs_archivo($ds_archivo)
	{
	    $this->ds_archivo = $ds_archivo;
	}

	public function getDt_fecha()
	{
	    return $this->dt_fecha;
	}

	public function setDt_fecha($dt_fecha)
	{
	    $this->dt_fecha = $dt_fecha;
	}

	public function getAmbitos()
	{
	    return $this->ambitos;
	}

	public function setAmbitos($ambitos)
	{
	    $this->ambitos = $ambitos;
	}

	public function getPresupuestos()
	{
	    return $this->presupuestos;
	}

	public function setPresupuestos($presupuestos)
	{
	    $this->presupuestos = $presupuestos;
	}

	public function getDs_observacion()
	{
	    return $this->ds_observacion;
	}

	public function setDs_observacion($ds_observacion)
	{
	    $this->ds_observacion = $ds_observacion;
	}

	public function getDs_investigador()
	{
	    return $this->ds_investigador;
	}

	public function setDs_investigador($ds_investigador)
	{
	    $this->ds_investigador = $ds_investigador;
	}

	public function getNu_cuil()
	{
	    return $this->nu_cuil;
	}

	public function setNu_cuil($nu_cuil)
	{
	    $this->nu_cuil = $nu_cuil;
	}
}
?>