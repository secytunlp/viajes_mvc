<?php

/**
 * Acción para eliminar rendiciones.
 *
 * @author Marcos
 * @since 28-09-2021
 *
 */
class DeleteRendicionAction extends DeleteEntityAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/DeleteEntityAction::getEntityManager()
	 */
	protected function getEntityManager(){
		return ManagerFactory::getRendicionManager();
	}

	

}
