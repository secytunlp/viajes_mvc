<?php

/**
 * Presupuesto
 *
 * @author Marcos
 * @since 22-11-2013
 */

class Presupuesto extends Entity{

	//variables de instancia.
	
	private $solicitud;
	
	private $tipoPresupuesto;
	
	
	private $dt_fecha;
	
	
	
	private $ds_presupuesto;
	
	private $ds_dias;
	
	private $ds_lugar;
	
	private $ds_pasajes;
	
	private $ds_destino;
	
	private $ds_inscripcion;
	
	private $nu_montopresupuesto;
	
	


	public function __construct(){
		 
		$this->solicitud = new Solicitud();
		
		$this->tipoPresupuesto = new TipoPresupuesto();
			
		$this->dt_fecha = "";
		
		$this->ds_presupuesto = "";
		
		$this->ds_dias = "";
		
		$this->ds_lugar = "";
		
		$this->ds_pasajes = "";
		
		$this->ds_destino = "";
		
		$this->ds_inscripcion = "";
		
		$this->nu_montopresupuesto = "";
		
		
	}



	public function getSolicitud()
	{
	    return $this->solicitud;
	}

	public function setSolicitud($solicitud)
	{
	    $this->solicitud = $solicitud;
	}

	public function getTipoPresupuesto()
	{
	    return $this->tipoPresupuesto;
	}

	public function setTipoPresupuesto($tipoPresupuesto)
	{
	    $this->tipoPresupuesto = $tipoPresupuesto;
	}

	public function getDt_fecha()
	{
	    return $this->dt_fecha;
	}

	public function setDt_fecha($dt_fecha)
	{
	    $this->dt_fecha = $dt_fecha;
	}

	public function getDs_presupuesto()
	{
	    return $this->ds_presupuesto;
	}

	public function setDs_presupuesto($ds_presupuesto)
	{
	    $this->ds_presupuesto = $ds_presupuesto;
	}

	public function getNu_montopresupuesto()
	{
	    return $this->nu_montopresupuesto;
	}

	public function setNu_montopresupuesto($nu_montopresupuesto)
	{
	    $this->nu_montopresupuesto = $nu_montopresupuesto;
	}

	public function getDs_dias()
	{
	    return $this->ds_dias;
	}

	public function setDs_dias($ds_dias)
	{
	    $this->ds_dias = $ds_dias;
	}

	public function getDs_lugar()
	{
	    return $this->ds_lugar;
	}

	public function setDs_lugar($ds_lugar)
	{
	    $this->ds_lugar = $ds_lugar;
	}

	public function getDs_pasajes()
	{
	    return $this->ds_pasajes;
	}

	public function setDs_pasajes($ds_pasajes)
	{
	    $this->ds_pasajes = $ds_pasajes;
	}

	public function getDs_destino()
	{
	    return $this->ds_destino;
	}

	public function setDs_destino($ds_destino)
	{
	    $this->ds_destino = $ds_destino;
	}

	public function getDs_inscripcion()
	{
	    return $this->ds_inscripcion;
	}

	public function setDs_inscripcion($ds_inscripcion)
	{
	    $this->ds_inscripcion = $ds_inscripcion;
	}
}
?>