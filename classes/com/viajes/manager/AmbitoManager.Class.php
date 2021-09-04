<?php

/**
 * Manager para Ambito
 *  
 * @author Marcos
 * @since 16-11-2013
 */
class AmbitoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getAmbitoDAO();
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
