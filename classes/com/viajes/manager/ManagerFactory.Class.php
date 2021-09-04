<?php

/**
 * Factory para Managers
 *  
 * @author Marcos
 * @since 13-11-2013
 */
class ManagerFactory{

	public static function getMotivoManager(){
		return new MotivoManager();
	}
	
	public static function getSolicitudManager(){
		return new SolicitudManager();
	}
	
	public static function getSolicitudProyectoManager(){
		return new SolicitudProyectoManager();
	}
	
	public static function getAmbitoManager(){
		return new AmbitoManager();
	}
	
	public static function getMontoManager(){
		return new MontoManager();
	}
	
	public static function getPresupuestoManager(){
		return new PresupuestoManager();
	}
	
	
	public static function getModeloPlanillaManager(){
		return new ModeloPlanillaManager();
	}
	
	public static function getEvaluacionManager(){
		return new EvaluacionManager();
	}
	
	public static function getPlanMaximoManager(){
		return new PlanMaximoManager();
	}
	
	public static function getPuntajePlanManager(){
		return new PuntajePlanManager();
	}
	
	public static function getCategoriaMaximoManager(){
		return new CategoriaMaximoManager();
	}
	
	public static function getPuntajeCategoriaManager(){
		return new PuntajeCategoriaManager();
	}
	
	public static function getCargoMaximoManager(){
		return new CargoMaximoManager();
	}
	
	public static function getPuntajeCargoManager(){
		return new PuntajeCargoManager();
	}
	
	public static function getPuntajeGrupoManager(){
		return new PuntajeGrupoManager();
	}
	
	public static function getItemPlanillaManager(){
		return new ItemPlanillaManager();
	}
	
	public static function getItemMaximoManager(){
		return new ItemMaximoManager();
	}
	
	public static function getPuntajeItemManager(){
		return new PuntajeItemManager();
	}

	public static function getEventoPlanillaManager(){
		return new EventoPlanillaManager();
	}
	
	public static function getEventoMaximoManager(){
		return new EventoMaximoManager();
	}
	
	public static function getPuntajeEventoManager(){
		return new PuntajeEventoManager();
	}
	
	public static function getCambioManager(){
		return new CambioManager();
	}
	
	public static function getAmbitoCambioManager(){
		return new AmbitoCambioManager();
	}
	
	public static function getPresupuestoCambioManager(){
		return new PresupuestoCambioManager();
	}
	
	public static function getCambioEstadoManager(){
		return new CambioEstadoManager();
	}
}

?>