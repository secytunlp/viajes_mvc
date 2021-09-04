<?php

/**
 * Manager para PuntajeItem
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class PuntajeItemManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getPuntajeItemDAO();
	}

}
?>
