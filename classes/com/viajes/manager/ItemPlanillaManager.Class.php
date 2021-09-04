<?php

/**
 * Manager para ItemPlanilla
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class ItemPlanillaManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getItemPlanillaDAO();
	}

}
?>
