<?php

/**
 * PuntajeItem
 *  
 * @author Marcos
 * @since 06-12-2013
 */


class PuntajeItem  extends Entity{

    //variables de instancia.
    
	private $modeloPlanilla;
	
	private $evaluacion;
    
    private $itemMaximo;
    
    private $nu_cantidad;
    
    private $nu_puntaje;
    

    public function __construct(){
    	
    	$this->modeloPlanilla = new ModeloPlanilla();
    	
    	$this->evaluacion = new Evaluacion();
    	
    	$this->itemMaximo = new ItemMaximo();
    	
    	$this->nu_cantidad="";
    	
    	$this->nu_puntaje="";
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

	

	public function getItemMaximo()
	{
	    return $this->itemMaximo;
	}

	public function setItemMaximo($itemMaximo)
	{
	    $this->itemMaximo = $itemMaximo;
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
}
?>