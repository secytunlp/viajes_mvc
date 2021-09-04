<?php

/**
 * Acción para inicializar el contexto
 * para editar un cambio.
 *
 * @author Marcos
 * @since 09-06-2015
 *
 */

class AddCambioInitAction extends EditEntityInitAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		$form = new CMPCambioForm($action);
		
		return $form;
		
	}
	
 	

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		
		$oCambio = new Cambio();
		$oUser = CdtSecureUtils::getUserLogged();
		$filter = new CMPCambioFilter();
		$filter->fillSavedProperties();
		
		//CYTSecureUtils::logObject($filter->getSolicitud());
		
		$oSolicitudManager =  ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($filter->getSolicitud()->getOid());
		
		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getObjectByCode($oSolicitud->getDocente()->getOid());
           
		
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_SOLICITANTE) {
            $separarCUIL = explode('-',trim($oUser->getDs_username()));
            
			if($oDocente->getNu_documento()!=$separarCUIL[1]){
				throw new GenericException( 'asdaddsasd' );
			}
			
			
			
           
            
        }
		$oCambio->setSolicitud($oSolicitud);
        $oCambio->setDs_investigador($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre());
        $oCambio->setNu_cuil($oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil());
        
        $oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
		//ambitos.
		$ambitosManager = new AmbitoManager();
		$oCambio->setAmbitos( $ambitosManager->getEntities($oCriteria) );
		
		//presupuestos.
		$presupuestosManager = new PresupuestoManager();
		$oCambio->setPresupuestos( $presupuestosManager->getEntities($oCriteria) );
        
		return $oCambio;
	}
	
	protected function parseEntity($entity, XTemplate $xtpl) {

		$manager = new AmbitoSessionManager();
		$manager->setEntities( $entity->getAmbitos() );
		
		$manager = new PresupuestoSessionManager();
		$manager->setEntities( $entity->getPresupuestos() );
		
		parent::parseEntity($entity, $xtpl);
		
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_CAMBIO_TITLE_ADD;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "add_cambio";
	}


}
