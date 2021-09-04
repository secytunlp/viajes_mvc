<?php

/**
 * Manager para EventoMaximo
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class EventoMaximoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getEventoMaximoDAO();
	}

}
?>
