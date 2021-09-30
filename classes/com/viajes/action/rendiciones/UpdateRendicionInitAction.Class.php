<?php

/**
 * Acción para inicializar el contexto
 * para editar una rendicion.
 *
 * @author Marcos
 * @since 04-03-2016
 *
 */

class UpdateRendicionInitAction extends UpdateEntityInitAction {


	protected function getEntity(){

		$entity = parent::getEntity();

		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('rendicion_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerRendicionEstado =  CYTSecureManagerFactory::getRendicionEstadoManager();
		$oRendicionEstado = $managerRendicionEstado->getEntity($oCriteria);
		if (($oRendicionEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_CREADA)) {

			throw new GenericException( CYT_MSG_SOLICITUD_MODIFICAR_PROHIBIDO);
		}

		$oSolicitudManager =  ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($entity->getSolicitud()->getOid());

		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getObjectByCode($oSolicitud->getDocente()->getOid());

        //$entity->setSolicitud($oSolicitud);
		$entity->setDs_investigador($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre());

		$entity->setNu_cuil($oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil());
		$entity->setMotivo_oid($oSolicitud->getMotivo()->getOid());

		//CYTSecureUtils::logObject($entity);

		return $entity;
	}


	protected function getEntityManager(){
		return ManagerFactory::getRendicionManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		return new CMPRendicionForm($action);

	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){

		return new Rendicion();
	}




	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_RENDICION_TITLE_UPDATE;
	}

	/**
	 * retorna el action para el submit.
	 * @return string
	 */
	protected function getSubmitAction(){
		return "update_rendicion";
	}


}
