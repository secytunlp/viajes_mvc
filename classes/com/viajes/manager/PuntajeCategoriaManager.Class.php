<?php

/**
 * Manager para PuntajeCategoria
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PuntajeCategoriaManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getPuntajeCategoriaDAO();
	}

}
?>
