<?php

/**
 * Manager para PuntajeEvento
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class PuntajeEventoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getPuntajeEventoDAO();
	}

}
?>
