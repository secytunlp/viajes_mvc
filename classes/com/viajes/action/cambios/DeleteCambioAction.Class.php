<?php

/**
 * Acción para eliminar cambios.
 *
 * @author Marcos
 * @since 10-06-2015
 *
 */
class DeleteCambioAction extends DeleteEntityAction {

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/DeleteEntityAction::getEntityManager()
	 */
	protected function getEntityManager(){
		return ManagerFactory::getCambioManager();
	}

	

}
