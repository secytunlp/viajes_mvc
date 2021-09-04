<?php

/**
 * PuntajeCategoria
 *  
 * @author Marcos
 * @since 05-12-2013
 */


class PuntajeCategoria  extends Entity{

    //variables de instancia.
    
	private $modeloPlanilla;
	
	private $evaluacion;
    
    private $categoriaMaximo;
    

    public function __construct(){
    	
    	$this->modeloPlanilla = new ModeloPlanilla();
    	
    	$this->evaluacion = new Evaluacion();
    	
    	$this->categoriaMaximo = new CategoriaMaximo();
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

	

	public function getCategoriaMaximo()
	{
	    return $this->categoriaMaximo;
	}

	public function setCategoriaMaximo($categoriaMaximo)
	{
	    $this->categoriaMaximo = $categoriaMaximo;
	}
}
?>