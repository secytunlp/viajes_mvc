<?php

/**
 * ModeloPlanilla
 *  
 * @author Marcos
 * @since 05-12-2013
 */


class ModeloPlanilla  extends Entity{

    //variables de instancia.
    
	private $motivo;
	
	private $periodo;
	
	private $tipoInvestigador;

    private $ds_motivo;
    
    private $nu_max;
    

    public function __construct(){
    	
    	$this->motivo = new Motivo();
    	
    	$this->periodo = new Periodo();
    	
    	$this->tipoInvestigador = new Tipoinvestigador();
    	
    	$this->ds_motivo = "";
    	$this->nu_max = "";
    }
    
    
   

    

   

	public function getMotivo()
	{
	    return $this->motivo;
	}

	public function setMotivo($motivo)
	{
	    $this->motivo = $motivo;
	}

	public function getPeriodo()
	{
	    return $this->periodo;
	}

	public function setPeriodo($periodo)
	{
	    $this->periodo = $periodo;
	}

	public function getTipoInvestigador()
	{
	    return $this->tipoInvestigador;
	}

	public function setTipoInvestigador($tipoInvestigador)
	{
	    $this->tipoInvestigador = $tipoInvestigador;
	}

	public function getDs_motivo()
	{
	    return $this->ds_motivo;
	}

	public function setDs_motivo($ds_motivo)
	{
	    $this->ds_motivo = $ds_motivo;
	}

	public function getNu_max()
	{
	    return $this->nu_max;
	}

	public function setNu_max($nu_max)
	{
	    $this->nu_max = $nu_max;
	}
}
?>