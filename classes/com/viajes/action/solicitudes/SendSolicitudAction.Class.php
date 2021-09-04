<?php

/**
 * Acción para enviar una solicitud.
 *
 * @author Marcos
 * @since 24-02-2014
 *
 */
class SendSolicitudAction extends CdtEditAsyncAction {

	
    protected function getEntity() {
    	if (date('Y-m-d')>CYT_FECHA_CIERRE) {
			throw new GenericException( CYT_MSG_FIN_PERIODO );
		}
        $entity = null;

		//recuperamos dado su identifidor.
		$oid = CdtUtils::getParam('id');
			
		if (!empty( $oid )) {
						
			$manager = $this->getEntityManager();
			$entity = $manager->getEntityById($oid);
		}else{
		
			$entity = parent::getEntity();
		
		}
		
    	$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerSolicitudEstado =  CYTSecureManagerFactory::getSolicitudEstadoManager();
		$oSolicitudEstado = $managerSolicitudEstado->getEntity($oCriteria);
		if (($oSolicitudEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_CREADA)) {
			
			throw new GenericException( CYT_MSG_SOLICITUD_ENVIAR_PROHIBIDO);
		}
		
    	$oPeriodoManager = CYTSecureManagerFactory::getPeriodoManager();
		$oPerioActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
		
		if (($entity->getPeriodo()->getOid()!=$oPerioActual->getOid())) {
			
			throw new GenericException( CYT_MSG_SOLICITUD_MODIFICAR_PROHIBIDO_1);
		}
		
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
		
		return $entity;
    }

    /**
     * (non-PHPdoc)
     * @see CdtEditAsyncAction::edit();
     */
    protected function edit($entity) {
        $this->getEntityManager()->send($entity);
    }
    
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/DeleteEntityAction::getEntityManager()
	 */
	protected function getEntityManager(){
		return ManagerFactory::getSolicitudManager();
	}


}