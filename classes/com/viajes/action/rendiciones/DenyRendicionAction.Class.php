<?php

/**
 * Acción para rechazar la rendición
 *
 * @author Marcos
 * @since 07-06-2016
 *
 */
class DenyRendicionAction extends AddEntityAction{

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::edit();
	 */
	protected function edit( $entity ){
		
		$this->getEntityManager()->confirm($entity->getRendicion(),CYT_ESTADO_SOLICITUD_CREADA,$entity->getObservaciones() );
		$result["oid"] = $entity->getOid();		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		return new CMPDenyRendicionForm();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		
		return new DenyRendicion();
	}

	protected function getEntityManager(){
		return CYTSecureManagerFactory::getRendicionManager();
	}



	


}
