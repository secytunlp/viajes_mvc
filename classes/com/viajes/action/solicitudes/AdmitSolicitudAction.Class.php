<?php

/**
 * Acción para admitir una solicitud.
 *
 * @author Marcos
 * @since 21-03-2014
 *
 */
class AdmitSolicitudAction extends CdtEditAsyncAction {

	
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
		$oCriteria->addFilter('solicitud_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerSolicitudEstado =  CYTSecureManagerFactory::getSolicitudEstadoManager();
		$oSolicitudEstado = $managerSolicitudEstado->getEntity($oCriteria);
		if (($oSolicitudEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_RECIBIDA)) {
			
			throw new GenericException( CYT_MSG_SOLICITUD_ADMITIR_PROHIBIDO);
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
		return ManagerFactory::getSolicitudManager();
	}


}