<?php

/**
 * Acción para inicializar el contexto
 * para editar una solicitud.
 *
 * @author Marcos
 * @since 10-01-2014
 *
 */

class UpdateSolicitudInitAction extends UpdateEntityInitAction {

	
	protected function getEntity(){
		if (date('Y-m-d')>CYT_FECHA_CIERRE) {
			throw new GenericException( CYT_MSG_FIN_PERIODO );
		}
		$entity = parent::getEntity();

		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerSolicitudEstado =  CYTSecureManagerFactory::getSolicitudEstadoManager();
		$oSolicitudEstado = $managerSolicitudEstado->getEntity($oCriteria);
		if (($oSolicitudEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_CREADA)) {
			
			throw new GenericException( CYT_MSG_SOLICITUD_MODIFICAR_PROHIBIDO);
		}
		
		$oPeriodoManager = CYTSecureManagerFactory::getPeriodoManager();
		$oPerioActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
		
		if (($entity->getPeriodo()->getOid()!=$oPerioActual->getOid())) {
			
			throw new GenericException( CYT_MSG_SOLICITUD_MODIFICAR_PROHIBIDO_1);
		}
		
		/*$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $entity->getOid(), '=');
		$oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
		$proyectosManager = ManagerFactory::getSolicitudProyectoManager();
		$proyectosActuales = $proyectosManager->getEntities($oCriteria);
		$proyectos = new ItemCollection();
		foreach ($proyectosActuales as $oProyectoSolicitud) {
			$oProyectoSolicitud->getProyecto()->setDt_ini($oProyectoSolicitud->getDt_alta());
			$oProyectoSolicitud->getProyecto()->setDt_fin($oProyectoSolicitud->getDt_baja());
			$proyectos->addItem($oProyectoSolicitud->getProyecto());
		}
		
		$entity->setProyectos( $proyectos );*/
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $entity->getOid(), '=');
		$oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
		$proyectosManager = ManagerFactory::getSolicitudProyectoManager();
		$proyectosActuales = $proyectosManager->getEntities($oCriteria);
		
		
		$entity->setProyectos( $proyectosActuales );
		
		
			
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_solicitud', $entity->getOid(), '=');
		//ambitos.
		$ambitosManager = new AmbitoManager();
		$entity->setAmbitos( $ambitosManager->getEntities($oCriteria) );
		
		//montos.
		$montosManager = new MontoManager();
		$entity->setMontos( $montosManager->getEntities($oCriteria) );
		
		//presupuestos.
		$presupuestosManager = new PresupuestoManager();
		$entity->setPresupuestos( $presupuestosManager->getEntities($oCriteria) );
			
		
		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getObjectByCode($entity->getDocente()->getOid());
		
		$entity->setDs_investigador($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre());
        
		$oUser = CdtSecureUtils::getUserLogged();
		$entity->setNu_cuil($oUser->getDs_username());
		
		//CYTSecureUtils::logObject($entity);
		
		return $entity;
	}
	
	protected function parseEntity($entity, XTemplate $xtpl) {

		$manager = new AmbitoSessionManager();
		$manager->setEntities( $entity->getAmbitos() );
		
		$manager = new MontoSessionManager();
		$manager->setEntities( $entity->getMontos() );
		
		$manager = new PresupuestoSessionManager();
		$manager->setEntities( $entity->getPresupuestos() );
		
		$manager = new SolicitudProyectoSessionManager();
		$manager->setEntities( $entity->getProyectos());
		
		parent::parseEntity($entity, $xtpl);
		
	}
	
	protected function getEntityManager(){
		return ManagerFactory::getSolicitudManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		$form = new CMPSolicitudForm($action);
		
		return $form;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$oSolicitud = new Solicitud();
		
		
		
		return $oSolicitud;
	}


	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_SOLICITUD_TITLE_UPDATE;
	}

	/**
	 * retorna el action para el submit.
	 * @return string
	 */
	protected function getSubmitAction(){
		return "update_solicitud";
	}


}