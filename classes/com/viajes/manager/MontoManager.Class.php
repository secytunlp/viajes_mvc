<?php

/**
 * Manager para Monto
 *  
 * @author Marcos
 * @since 21-11-2013
 */
class MontoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getMontoDAO();
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
