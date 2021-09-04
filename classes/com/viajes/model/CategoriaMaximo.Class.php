<?php

/**
 * CategoriaMaximo
 *  
 * @author Marcos
 * @since 05-12-2013
 */


class CategoriaMaximo  extends Entity{

    //variables de instancia.
    
	private $modeloPlanilla;
	
	private $categoria;
    
    private $nu_max;
    

    public function __construct(){
    	
    	$this->modeloPlanilla = new ModeloPlanilla();
    	
    	$this->categoria = new Categoria();
    	
    	$this->nu_max = "";
    }
    
    
   

	public function getModeloPlanilla()
	{
	    return $this->modeloPlanilla;
	}

	public function setModeloPlanilla($modeloPlanilla)
	{
	    $this->modeloPlanilla = $modeloPlanilla;
	}

	public function getNu_max()
	{
	    return $this->nu_max;
	}

	public function setNu_max($nu_max)
	{
	    $this->nu_max = $nu_max;
	}

	public function getCategoria()
	{
	    return $this->categoria;
	}

	public function setCategoria($categoria)
	{
	    $this->categoria = $categoria;
	}
}
?>