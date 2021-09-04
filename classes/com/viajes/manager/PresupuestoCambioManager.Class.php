<?php

/**
 * Manager para PresupuestoCambio
 *  
 * @author Marcos
 * @since 09-06-2015
 */
class PresupuestoCambioManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getPresupuestoCambioDAO();
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
