<?php

/**
 * Manager para PlanMaximo
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PlanMaximoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getPlanMaximoDAO();
	}

}
?>
