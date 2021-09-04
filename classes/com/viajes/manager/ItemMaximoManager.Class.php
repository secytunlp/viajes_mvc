<?php

/**
 * Manager para ItemMaximo
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class ItemMaximoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getItemMaximoDAO();
	}

}
?>
