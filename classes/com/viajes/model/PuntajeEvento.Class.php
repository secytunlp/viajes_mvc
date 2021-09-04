<?php

/**
 * PuntajeEvento
 *  
 * @author Marcos
 * @since 06-12-2013
 */


class PuntajeEvento  extends Entity{

    //variables de instancia.
    
	private $modeloPlanilla;
	
	private $evaluacion;
    
    private $eventoMaximo;
    
    private $nu_cantidad;
    
    private $nu_puntaje;
    
    private $ds_justificacion;
    

    public function __construct(){
    	
    	$this->modeloPlanilla = new ModeloPlanilla();
    	
    	$this->evaluacion = new Evaluacion();
    	
    	$this->eventoMaximo = new EventoMaximo();
    	
    	$this->nu_cantidad="";
    	
    	$this->nu_puntaje="";
    	
    	$this->ds_justificacion="";
    }
    
    
   

	

	public function getModeloPlanilla()
	{
	    return $this->modeloPlanilla;
	}

	public function setModeloPlanilla($modeloPlanilla)
	{
	    $this->modeloPlanilla = $modeloPlanilla;
	}

	public function getEvaluacion()
	{
	    return $this->evaluacion;
	}

	public function setEvaluacion($evaluacion)
	{
	    $this->evaluacion = $evaluacion;
	}

	

	public function getEventoMaximo()
	{
	    return $this->eventoMaximo;
	}

	public function setEventoMaximo($eventoMaximo)
	{
	    $this->eventoMaximo = $eventoMaximo;
	}

	public function getNu_cantidad()
	{
	    return $this->nu_cantidad;
	}

	public function setNu_cantidad($nu_cantidad)
	{
	    $this->nu_cantidad = $nu_cantidad;
	}

	public function getNu_puntaje()
	{
	    return $this->nu_puntaje;
	}

	public function setNu_puntaje($nu_puntaje)
	{
	    $this->nu_puntaje = $nu_puntaje;
	}

	public function getDs_justificacion()
	{
	    return $this->ds_justificacion;
	}

	public function setDs_justificacion($ds_justificacion)
	{
	    $this->ds_justificacion = $ds_justificacion;
	}
}
?>