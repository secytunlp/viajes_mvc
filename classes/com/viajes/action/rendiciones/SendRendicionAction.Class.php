<?php

/**
 * Acción para enviar un rendicion.
 *
 * @author Marcos
 * @since 28-09-2021
 *
 */
class SendRendicionAction extends CdtEditAsyncAction {

	
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
		$oCriteria->addFilter('rendicion_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerRendicionEstado =  ManagerFactory::getRendicionEstadoManager();
		$oRendicionEstado = $managerRendicionEstado->getEntity($oCriteria);
		if (($oRendicionEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_CREADA)) {
			
			throw new GenericException( CYT_MSG_RENDICION_ENVIAR_PROHIBIDO);
		}
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_rendicion', $entity->getOid(), '=');

		
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
		return ManagerFactory::getRendicionManager();
	}


}