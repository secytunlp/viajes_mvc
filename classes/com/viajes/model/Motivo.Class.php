<?php

/**
 * Motivo
 *  
 * @author Marcos
 * @since 13-11-2013
 */


class Motivo  extends Entity{

    //variables de instancia.

    private $ds_motivo;
    
    private $ds_letra;
    

    public function __construct(){
    	
    	$this->ds_motivo = "";
    	$this->ds_letra = "";
    }
    
    
    public function getDs_motivo()
    {
        return $this->ds_motivo;
    }

    public function setDs_motivo($ds_motivo)
    {
        $this->ds_motivo = $ds_motivo;
    }


    

    public function getDs_letra()
    {
        return $this->ds_letra;
    }

    public function setDs_letra($ds_letra)
    {
        $this->ds_letra = $ds_letra;
    }
}
?>