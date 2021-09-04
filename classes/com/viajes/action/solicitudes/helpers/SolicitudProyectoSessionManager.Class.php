<?php

/**
 * Helper manager para administrar en sesión los proyectos de una solicitud
 *  
 * @author Marcos
 * @since 19-12-2013
 */
class SolicitudProyectoSessionManager extends EntityManager{

	public function getDAO(){
		return new SolicitudProyectoSessionDAO();
	}
	
	public function select($oid,$checked) {
    	$this->getDAO()->selectEntity($oid,$checked);
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
