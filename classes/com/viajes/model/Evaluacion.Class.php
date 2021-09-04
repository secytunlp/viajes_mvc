<?php

/**
 * Evaluacion
 *
 * @author Marcos
 * @since 18-11-2013
 */

class Evaluacion extends Entity{

	//variables de instancia.
	
	private $solicitud;
	
	private $periodo;
	
	private $ds_investigador;
	
	private $ds_facultad;
	
	private $cd_motivo;
	private $ds_motivo;
	
	private $cd_tipoinvestigador;
	private $ds_tipoinvestigador;
	
	private $user;

	private $estado;
	
	
	
	private $dt_fecha;
	private $nu_puntaje;
	private $bl_interno;
	private $ds_observacion;
		
	
	private $nu_max;
	
	private $ds_contenido;
	
	private $modeloPlanilla_oid;
	
	private $nu_puntajePlan;
	private $ds_justificacionPlan;
	private $categoria_oid;
	private $cargo_oid;
	private $items;
	private $eventos;
	

	public function __construct(){
		 
		$this->solicitud = new Solicitud();
		
		$this->user = new User();
		
		$this->estado = new Estado();
		
		
			
		$this->dt_fecha = "";
		
		$this->nu_puntaje = "";
		
		$this->bl_interno = "";
		
		
		
		
		
		$this->ds_observacion = "";
		
		$this->ds_contenido = "";
		
		$this->estado = new Estado();
		
		$this->nu_puntajePlan = "";
		
		$this->modeloPlanilla_oid = "";
		
		$this->categoria_oid = "";
		
		$this->cargo_oid = "";
		
		$this->items= new ItemCollection();
		
		$this->eventos= new ItemCollection();
	}




	

	 

	

	

	

	public function getSolicitud()
	{
	    return $this->solicitud;
	}

	public function setSolicitud($solicitud)
	{
	    $this->solicitud = $solicitud;
	}

	public function getDs_investigador()
	{
	    return $this->ds_investigador;
	}

	public function setDs_investigador($ds_investigador)
	{
	    $this->ds_investigador = $ds_investigador;
	}

	public function getDs_facultad()
	{
	    return $this->ds_facultad;
	}

	public function setDs_facultad($ds_facultad)
	{
	    $this->ds_facultad = $ds_facultad;
	}

	public function getCd_motivo()
	{
	    return $this->cd_motivo;
	}

	public function setCd_motivo($cd_motivo)
	{
	    $this->cd_motivo = $cd_motivo;
	}

	public function getDs_motivo()
	{
	    return $this->ds_motivo;
	}

	public function setDs_motivo($ds_motivo)
	{
	    $this->ds_motivo = $ds_motivo;
	}

	public function getCd_tipoinvestigador()
	{
	    return $this->cd_tipoinvestigador;
	}

	public function setCd_tipoinvestigador($cd_tipoinvestigador)
	{
	    $this->cd_tipoinvestigador = $cd_tipoinvestigador;
	}

	public function getDs_tipoinvestigador()
	{
	    return $this->ds_tipoinvestigador;
	}

	public function setDs_tipoinvestigador($ds_tipoinvestigador)
	{
	    $this->ds_tipoinvestigador = $ds_tipoinvestigador;
	}

	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	public function getDt_fecha()
	{
	    return $this->dt_fecha;
	}

	public function setDt_fecha($dt_fecha)
	{
	    $this->dt_fecha = $dt_fecha;
	}

	public function getNu_puntaje()
	{
	    return $this->nu_puntaje;
	}

	public function setNu_puntaje($nu_puntaje)
	{
	    $this->nu_puntaje = $nu_puntaje;
	}

	public function getBl_interno()
	{
	    return $this->bl_interno;
	}

	public function setBl_interno($bl_interno)
	{
	    $this->bl_interno = $bl_interno;
	}

	public function getDs_observacion()
	{
	    return $this->ds_observacion;
	}

	public function setDs_observacion($ds_observacion)
	{
	    $this->ds_observacion = $ds_observacion;
	}

	public function getNu_max()
	{
	    return $this->nu_max;
	}

	public function setNu_max($nu_max)
	{
	    $this->nu_max = $nu_max;
	}
	
	public function getDocente()
	{
	    return $this->docente;
	}

	public function setDocente($docente)
	{
	    $this->docente = $docente;
	}
	
	public function __toString(){
		
		return $this->getUser()->getDs_username();
	}

	public function getDs_contenido()
	{
	    return $this->ds_contenido;
	}

	public function setDs_contenido($ds_contenido)
	{
	    $this->ds_contenido = $ds_contenido;
	}



	public function getModeloPlanilla_oid()
	{
	    return $this->modeloPlanilla_oid;
	}

	public function setModeloPlanilla_oid($modeloPlanilla_oid)
	{
	    $this->modeloPlanilla_oid = $modeloPlanilla_oid;
	}

	public function getNu_puntajePlan()
	{
	    return $this->nu_puntajePlan;
	}

	public function setNu_puntajePlan($nu_puntajePlan)
	{
	    $this->nu_puntajePlan = $nu_puntajePlan;
	}

	public function getCategoria_oid()
	{
	    return $this->categoria_oid;
	}

	public function setCategoria_oid($categoria_oid)
	{
	    $this->categoria_oid = $categoria_oid;
	}

	public function getCargo_oid()
	{
	    return $this->cargo_oid;
	}

	public function setCargo_oid($cargo_oid)
	{
	    $this->cargo_oid = $cargo_oid;
	}

	public function getItems()
	{
	    return $this->items;
	}

	public function setItems($items)
	{
	    $this->items = $items;
	}

	public function getEventos()
	{
	    return $this->eventos;
	}

	public function setEventos($eventos)
	{
	    $this->eventos = $eventos;
	}

	public function getDs_justificacionPlan()
	{
	    return $this->ds_justificacionPlan;
	}

	public function setDs_justificacionPlan($ds_justificacionPlan)
	{
	    $this->ds_justificacionPlan = $ds_justificacionPlan;
	}

	public function getPeriodo()
	{
	    return $this->periodo;
	}

	public function setPeriodo($periodo)
	{
	    $this->periodo = $periodo;
	}
}
?>