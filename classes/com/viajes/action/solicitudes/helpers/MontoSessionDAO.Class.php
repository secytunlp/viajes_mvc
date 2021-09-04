<?php

/**
 * Helper DAO para administrar en sesión los montos de una 
 * solicitud.
 *  
 * @author Marcos
 * @since 02-01-2014
 */
class MontoSessionDAO extends EntityDAO {

	public function getFieldsToAdd($entity){}
	
	public function getFieldsToUpdate($entity){}
	
	public function getId($entity){}
		
	public function getIdFieldName(){}
	
	public function setId($entity, $id){}
	
	public function getTableName(){}
	
	public function getEntityFactory(){}
	
	public function getVariableSessionName(){
		return "montos";
	}
	
    /**
     * se persiste la nueva entity
     * @param $entity entity a persistir.
     */
    public function addEntity( $entity, $idConn=0 ) {
    	
    	$montos = unserialize( $_SESSION[ $this->getVariableSessionName() ] );
    	
    	if( empty($montos) )
    		$montos = new ItemCollection();
    	$montos->addItem($entity);
        
        $_SESSION[$this->getVariableSessionName()] = serialize($montos);
        
    }
    
    /**
     */
    public function setEntities( $entities, $idConn=0 ) {
    	
        $_SESSION[$this->getVariableSessionName()] = serialize($entities);
        
    }
    
    /**
     * se modifica la entity
     * @param $entity entity a modificar.
     */
    public function updateEntity($entity, $idConn=0) {
        //TODO
    }

    /**
     * se elimina la entity
     * @param $id identificador de la entity a eliminar.
     */
    public function deleteEntity($oid, $idConn=0) {
    	
    	$oid = urldecode($oid);
    	
    	$montos = unserialize( $_SESSION[$this->getVariableSessionName()] );
    	
    	
    	$nuevosMontos = new ItemCollection();
    	foreach ($montos as $oMonto) {
    		
    		if( $oMonto->getDs_institucion() != $oid ){
    			$nuevosMontos->addItem($oMonto);
    		}
    	}
    	
        $_SESSION[$this->getVariableSessionName()] = serialize($nuevosMontos);
    	
    }

    /**
     * quitamos todos los montos de sesión
     */
    public function deleteAll() {
    	unset( $_SESSION[$this->getVariableSessionName()] ) ;
    	
    }
    /**
     * se obtiene una colección de entities dado el filtro de búsqueda
     * @param CdtSearchCriteria $oCriteria filtro de búsqueda.
     * @return ItemCollection
     */
    public function getEntities(CdtSearchCriteria $oCriteria, $idConn=0) {

    	if(isset($_SESSION[$this->getVariableSessionName()]))
			$montos = unserialize( $_SESSION[$this->getVariableSessionName()] );
		else 
			$montos = new ItemCollection();	

		return $montos;
    }

    /**
     * se obtiene la cantidad de entities dado el filtro de búsqueda
     * @param CdtSearchCriteria $oCriteria filtro de búsqueda.
     * @return int
     */
    public function getEntitiesCount(CdtSearchCriteria $oCriteria, $idConn=0) {
        
    	$montos = unserialize($this->getVariableSessionName() );

        return $montos->size();
    }

    /**
     * se obtiene un entity dado el filtro de búsqueda
     * @param CdtSearchCriteria $oCriteria filtro de búsqueda.
     * @return Entity
     */
    public function getEntity(CdtSearchCriteria $oCriteria, $idConn=0) {
		//TODO
    }
	
	public function getEntityById($id) {
		//TODO
    }
		
}
?>