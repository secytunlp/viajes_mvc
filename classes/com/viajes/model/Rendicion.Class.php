<?php

/**
 * Rendicion
 *
 * @author Marcos
 * @since 28-09-2021
 */

class Rendicion extends Entity{

	//variables de instancia.
	
	private $ds_investigador;
	private $nu_cuil;

	private $estado;
	
	private $solicitud;
	
	private $ds_rendicion;

    /**
     * @return string
     */
    public function getDsRendicion()
    {
        return $this->ds_rendicion;
    }

    /**
     * @param string $ds_rendicion
     */
    public function setDsRendicion($ds_rendicion)
    {
        $this->ds_rendicion = $ds_rendicion;
    }

    /**
     * @return string
     */
    public function getDsInforme()
    {
        return $this->ds_informe;
    }

    /**
     * @param string $ds_informe
     */
    public function setDsInforme($ds_informe)
    {
        $this->ds_informe = $ds_informe;
    }

    /**
     * @return string
     */
    public function getDsCertificado()
    {
        return $this->ds_certificado;
    }

    /**
     * @param string $ds_certificado
     */
    public function setDsCertificado($ds_certificado)
    {
        $this->ds_certificado = $ds_certificado;
    }

    private $ds_informe;

    private $ds_certificado;
	
	  private $dt_fecha;
	 

	 
	  private $ds_observacion;
	  
	
	public function __construct(){
		 
			$this->ds_investigador = '';
		   
		   $this->nu_cuil = '';
		
		  $this->solicitud = new Solicitud();
		  
		 
		  
		   $this->ds_informe = '';

        $this->ds_certificado = '';

        $this->ds_rendicion = '';
		   
		  
		  $this->dt_fecha = '';
		  

		  
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



	public function getDt_fecha()
	{
	    return $this->dt_fecha;
	}

	public function setDt_fecha($dt_fecha)
	{
	    $this->dt_fecha = $dt_fecha;
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