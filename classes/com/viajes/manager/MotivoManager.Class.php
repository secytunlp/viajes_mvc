<?php

/**
 * Manager para Motivo
 *  
 * @author Marcos
 * @since 31-10-2013
 */
class MotivoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getMotivoDAO();
	}

}
?>
