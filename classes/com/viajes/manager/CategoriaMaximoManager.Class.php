<?php

/**
 * Manager para CategoriaMaximo
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class CategoriaMaximoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getCategoriaMaximoDAO();
	}

}
?>
