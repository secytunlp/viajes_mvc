<?php

/**
 * EventoPlanilla
 *  
 * @author Marcos
 * @since 06-12-2013
 */


class EventoPlanilla  extends Entity{

    //variables de instancia.
    
	private $ds_eventoplanilla;
	
	
    
    private $nu_orden;
    

    public function __construct(){
    	
    	$this->ds_eventoplanilla = "";
    	
    	
    	$this->nu_orden = "";
    }
    
    
   

	

	public function getDs_eventoplanilla()
	{
	    return $this->ds_eventoplanilla;
	}

	public function setDs_eventoplanilla($ds_eventoplanilla)
	{
	    $this->ds_eventoplanilla = $ds_eventoplanilla;
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