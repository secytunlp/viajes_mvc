<?php

/**
 * Acción para inicializar el contexto
 * para rechazar una rendición
 *
 * @author Marcos
 * @since 07-06-2016
 *
 */

class DenyRendicionInitAction extends EditEntityInitAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		return new CMPDenyRendicionForm($action);
		
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$denyRendicion = new DenyRendicion();
		
		$rendicion_oid = CdtUtils::getParam('id');
			
		if (!empty( $rendicion_oid )) {
			$rendicion = new Rendicion();
			$rendicion->setOid($rendicion_oid);
			$denyRendicion->setRendicion($rendicion);
		}
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('rendicion_oid', $rendicion_oid, '=');
		$oCriteria->addNull('fechaHasta');
		$managerRendicionEstado =  CYTSecureManagerFactory::getRendicionEstadoManager();
		$oRendicionEstado = $managerRendicionEstado->getEntity($oCriteria);
		if (($oRendicionEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_RECIBIDA)) {
			
			throw new GenericException( CYT_MSG_RENDICION_ADMITIR_PROHIBIDO);
		}
	
		return $denyRendicion;
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_RENDICION_RECHAZAR;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "deny_rendicion";
	}


}
