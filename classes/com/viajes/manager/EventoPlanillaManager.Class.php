<?php

/**
 * Manager para EventoPlanilla
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class EventoPlanillaManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getEventoPlanillaDAO();
	}

}
?>
