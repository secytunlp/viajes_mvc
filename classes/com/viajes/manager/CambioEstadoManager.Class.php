<?php

/**
 * Manager para Cambio Estado
 *  
 * @author Marcos
 * @since 09-06-2015
 */
class CambioEstadoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getCambioEstadoDAO();
	}

	public function add(Entity $entity) {
    	
		parent::add($entity);
		
    }	
    
     public function update(Entity $entity) {
     	
     	
		parent::update($entity);
     }

    
    
    
	/**
     * se elimina la entity
     * @param int identificador de la entity a eliminar.
     */
    public function delete($id) {
        
		parent::delete( $id );
		
    	
    }
	
	
	
	
}
?>
