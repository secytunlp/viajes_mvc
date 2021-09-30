<?php

/**
 * Acción para inicializar el contexto
 * para editar un rendicion.
 *
 * @author Marcos
 * @since 28-09-2021
 *
 */

class AddRendicionInitAction extends EditEntityInitAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		$form = new CMPRendicionForm($action);

		return $form;

	}



	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){

		$oRendicion = new Rendicion();
		$oUser = CdtSecureUtils::getUserLogged();
		$filter = new CMPRendicionFilter();
		$filter->fillSavedProperties();

        $oCriteria = new CdtSearchCriteria();

        $oCriteria->addFilter("solicitud_oid", $filter->getSolicitud()->getOid(), '=');



        $oRendicionManager =  ManagerFactory::getRendicionManager();
        $oRendicionAux = $oRendicionManager->getEntity($oCriteria);

        if(!empty($oRendicionAux)){
            throw new GenericException( CYT_MSG_RENDICION_CREADA );
        }

		$oSolicitudManager =  ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($filter->getSolicitud()->getOid());


        $oCriteria = new CdtSearchCriteria();
        $oCriteria->addFilter('solicitud_oid', $oSolicitud->getOid(), '=');
        $oCriteria->addNull('fechaHasta');
        $managerSolicitudEstado =  CYTSecureManagerFactory::getSolicitudEstadoManager();
        $oSolicitudEstado = $managerSolicitudEstado->getEntity($oCriteria);

        if (($oSolicitudEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_OTORGADA)) {

            throw new GenericException( CYT_MSG_RENDICIONES_PROHIBIDO_AGREGAR);
        }


		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getObjectByCode($oSolicitud->getDocente()->getOid());


		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_SOLICITANTE) {
            $separarCUIL = explode('-',trim($oUser->getDs_username()));

			if($oDocente->getNu_documento()!=$separarCUIL[1]){
				throw new GenericException( 'asdaddsasd' );
			}





        }
		$oRendicion->setSolicitud($oSolicitud);
        $oRendicion->setDs_investigador($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre());
        $oRendicion->setNu_cuil($oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil());

        $oRendicion->setMotivo_oid($oSolicitud->getMotivo()->getOid());


		return $oRendicion;
	}

	protected function parseEntity($entity, XTemplate $xtpl) {



		parent::parseEntity($entity, $xtpl);

	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_RENDICION_TITLE_ADD;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
	 */
	protected function getSubmitAction(){
		return "add_rendicion";
	}


}
