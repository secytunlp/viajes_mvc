<?php

/**
 * Helper manager para administrar en sesión los ámbitos de una solicitud
 *  
 * @author Marcos
 * @since 02-01-2014
 */
class MontoSessionManager extends EntityManager{

	public function getDAO(){
		return new MontoSessionDAO();
	}
	
	public function deleteAll() {
    	$this->getDAO()->deleteAll();
    }
    
    public function setEntities( $entities ) {
    	$this->getDAO()->setEntities($entities);
    }
    
    protected function validateOnAdd(Entity $entity){
    	
    	//TODO validaciones	
    }
    
	protected function validateOnUpdate(Entity $entity){
		//TODO validaciones
	}

	protected function validateOnDelete($id){
		//TODO validaciones
	}	
}

?>
