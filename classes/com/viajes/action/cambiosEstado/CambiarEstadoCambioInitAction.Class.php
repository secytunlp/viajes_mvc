<?php

/**
 * Acción para inicializar el contexto
 * para cambiar el estado de una solicitud
 *
 * @author Marcos
 * @since 19-03-2014
 *
 */

class CambiarEstadoSolicitudInitAction extends EditEntityInitAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		return new CMPCambiarEstadoSolicitudForm($action);
		
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$cambiarEstadoSolicitud = new CambiarEstadoSolicitud();
		
		$filter = new CMPSolicitudEstadoFilter();
		$filter->fillSavedProperties();
		$cambiarEstadoSolicitud->setSolicitud($filter->getSolicitud());
	
		
		
		return $cambiarEstadoSolicitud;
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_SOLICITUD_ESTADO_CAMBIAR;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "cambiarEstadoSolicitud";
	}


}
