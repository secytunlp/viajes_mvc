<?php

/**
 * Acción para cambiar el estado de la solicitud
 *
 * @author Marcos
 * @since 19-03-2014
 *
 */
class CambiarEstadoSolicitudAction extends AddEntityAction{

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::edit();
	 */
	protected function edit( $entity ){
		
		$this->getEntityManager()->cambiarEstado($entity->getSolicitud(),$entity->getEstado(),$entity->getMotivo() );
		$result["oid"] = $entity->getOid();		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		return new CMPCambiarEstadoSolicitudForm();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		
		return new CambiarEstadoSolicitud();
	}

	protected function getEntityManager(){
		return ManagerFactory::getSolicitudManager();
	}



	


}
