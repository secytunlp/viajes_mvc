<?php

/**
 * Factory para DAOs
 *
 * @author Marcos
 * @since 13-11-2013
 */
class DAOFactory{

	public static function getMotivoDAO(){
		return new MotivoDAO();
	}
	
	public static function getSolicitudDAO(){
		return new SolicitudDAO();
	}
	
	public static function getAmbitoDAO(){
		return new AmbitoDAO();
	}
	
	
	public static function getSolicitudProyectoDAO(){
		return new SolicitudProyectoDAO();
	}
	
	public static function getMontoDAO(){
		return new MontoDAO();
	}
	
	public static function getPresupuestoDAO(){
		return new PresupuestoDAO();
	}

	
	public static function getModeloPlanillaDAO(){
		return new ModeloPlanillaDAO();
	}
	
	public static function getPlanMaximoDAO(){
		return new PlanMaximoDAO();
	}
	
	public static function getPuntajePlanDAO(){
		return new PuntajePlanDAO();
	}
	
	public static function getCategoriaMaximoDAO(){
		return new CategoriaMaximoDAO();
	}
	
	public static function getPuntajeCategoriaDAO(){
		return new PuntajeCategoriaDAO();
	}
	
	public static function getCargoMaximoDAO(){
		return new CargoMaximoDAO();
	}
	
	public static function getCargoPlanillaDAO(){
		return new CargoPlanillaDAO();
	}
	
	public static function getPuntajeCargoDAO(){
		return new PuntajeCargoDAO();
	}
	
	public static function getPuntajeGrupoDAO(){
		return new PuntajeGrupoDAO();
	}
	
	public static function getItemPlanillaDAO(){
		return new ItemPlanillaDAO();
	}
	
	public static function getItemMaximoDAO(){
		return new ItemMaximoDAO();
	}
	
	public static function getPuntajeItemDAO(){
		return new PuntajeItemDAO();
	}
	
	public static function getEventoPlanillaDAO(){
		return new EventoPlanillaDAO();
	}
	
	public static function getEventoMaximoDAO(){
		return new EventoMaximoDAO();
	}
	
	public static function getPuntajeEventoDAO(){
		return new PuntajeEventoDAO();
	}
	
	public static function getCambioDAO(){
		return new CambioDAO();
	}	
	
	public static function getCambioEstadoDAO(){
		return new CambioEstadoDAO();
	}
	
	public static function getAmbitoCambioDAO(){
		return new AmbitoCambioDAO();
	}
	
	public static function getPresupuestoCambioDAO(){
		return new PresupuestoCambioDAO();
	}
}
?>
