<?php

/**
 * Acción para enviar un cambio.
 *
 * @author Marcos
 * @since 11-06-2015
 *
 */
class SendCambioAction extends CdtEditAsyncAction {

	
    protected function getEntity() {
    	
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
		$oCriteria->addFilter('cambio_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerCambioEstado =  ManagerFactory::getCambioEstadoManager();
		$oCambioEstado = $managerCambioEstado->getEntity($oCriteria);
		if (($oCambioEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_CREADA)) {
			
			throw new GenericException( CYT_MSG_CAMBIO_ENVIAR_PROHIBIDO);
		}
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_cambio', $entity->getOid(), '=');
		//ambitos.
		$ambitosManager = new AmbitoCambioManager();
		$entity->setAmbitos( $ambitosManager->getEntities($oCriteria) );
		
	
		//presupuestos.
		$presupuestosManager = new PresupuestoCambioManager();
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
		return ManagerFactory::getCambioManager();
	}


}