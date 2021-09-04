<?php

/**
 * Manager para PuntajePlan
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PuntajePlanManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getPuntajePlanDAO();
	}

}
?>
