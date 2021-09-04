<?php

/**
 * PuntajePlan
 *  
 * @author Marcos
 * @since 05-12-2013
 */


class PuntajePlan  extends Entity{

    //variables de instancia.
    
	private $modeloPlanilla;
	
	private $evaluacion;
    
    private $nu_puntaje;
    
    private $ds_justificacion;
    

    public function __construct(){
    	
    	$this->modeloPlanilla = new ModeloPlanilla();
    	
    	$this->evaluacion = new Evaluacion();
    	
    	$this->nu_puntaje = "";
    	$this->ds_justificacion = "";
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