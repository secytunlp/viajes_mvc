<?php

/**
 * ItemPlanilla
 *  
 * @author Marcos
 * @since 06-12-2013
 */


class ItemPlanilla  extends Entity{

    //variables de instancia.
    
	private $ds_itemplanilla;
	
	
    
    private $nu_orden;
    

    public function __construct(){
    	
    	$this->ds_itemplanilla = "";
    	
    	
    	$this->nu_orden = "";
    }
    
    
   

	

	public function getDs_itemplanilla()
	{
	    return $this->ds_itemplanilla;
	}

	public function setDs_itemplanilla($ds_itemplanilla)
	{
	    $this->ds_itemplanilla = $ds_itemplanilla;
	}

	public function getNu_orden()
	{
	    return $this->nu_orden;
	}

	public function setNu_orden($nu_orden)
	{
	    $this->nu_orden = $nu_orden;
	}
}
?>