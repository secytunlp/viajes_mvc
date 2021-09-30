<?php

/**
 * Acción para admitir una rendición.
 *
 * @author Marcos
 * @since 03-06-2016
 *
 */
class AdmitRendicionAction extends CdtEditAsyncAction {

	
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
		$managerRendicionEstado =  CYTSecureManagerFactory::getRendicionEstadoManager();
		$oRendicionEstado = $managerRendicionEstado->getEntity($oCriteria);
		if (($oRendicionEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_RECIBIDA)) {
			
			throw new GenericException( CYT_MSG_RENDICION_ADMITIR_PROHIBIDO);
		}
		
		return $entity;
    }

    /**
     * (non-PHPdoc)
     * @see CdtEditAsyncAction::edit();
     */
    protected function edit($entity) {
        $this->getEntityManager()->confirm($entity,CYT_ESTADO_SOLICITUD_ADMITIDA);
    }
    
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/DeleteEntityAction::getEntityManager()
	 */
	protected function getEntityManager(){
		return CYTSecureManagerFactory::getRendicionManager();
	}


}