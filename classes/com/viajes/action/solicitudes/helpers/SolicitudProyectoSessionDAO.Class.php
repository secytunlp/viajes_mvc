<?php

/**
 * Helper DAO para administrar en sesión los proyectos de una 
 * solicitud.
 *  
 * @author Marcos
 * @since 19-12-2013
 */
class SolicitudProyectoSessionDAO extends EntityDAO {

	public function getFieldsToAdd($entity){}
	
	public function getFieldsToUpdate($entity){}
	
	public function getId($entity){}
		
	public function getIdFieldName(){}
	
	public function setId($entity, $id){}
	
	public function getTableName(){}
	
	public function getEntityFactory(){}
	
	public function getVariableSessionName(){
		return "solicitud_proyectos";
	}
	
    /**
     * se persiste la nueva entity
     * @param $entity entity a persistir.
     */
    public function addEntity( $entity, $idConn=0 ) {
    	
    	$proyectos = unserialize( $_SESSION[ $this->getVariableSessionName() ] );
    	
    	if( empty($proyectos) )
    		$proyectos = new ItemCollection();
    	//if (!$proyectos->existObjectComparator($entity, new FacultadComparator())) {	
        	$proyectos->addItem($entity);
    	//}
        
        $_SESSION[$this->getVariableSessionName()] = serialize($proyectos);
        
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
    	
    	$solicitudProyectos = unserialize( $_SESSION[$this->getVariableSessionName()] );
    	
    	//el oid representaría la facultad??
    	$nuevosProyectos = new ItemCollection();
    	foreach ($solicitudProyectos as $oSolicitudProyecto) {
    		
    		if( $oSolicitudProyecto->getProyecto()->getOid() != $oid ){
    			$nuevosProyectos->addItem($oSolicitudProyecto);
    		}
    	}
    	
        $_SESSION[$this->getVariableSessionName()] = serialize($nuevosProyectos);
    	
    }
    
	/**
     * se selecciona la entity
     * @param $id identificador de la entity a eliminar.
     */
    public function selectEntity($oid,$checked, $idConn=0) {
    	
    	$oid = urldecode($oid);
    	
    	$solicitudProyectos = unserialize( $_SESSION[$this->getVariableSessionName()] );
    	
    	//el oid representaría la facultad??
    	$nuevosProyectos = new ItemCollection();
    	foreach ($solicitudProyectos as $oSolicitudProyecto) {
    		
    		if( $oSolicitudProyecto->getProyecto()->getOid() == $oid ){
    			$seleccionado = ($checked=='true')?1:0;
				//CdtUtils::log('Marcos: '.$checked.' - '.$seleccionado);
    			$oSolicitudProyecto->setBl_seleccionado($seleccionado);
    		}
    		//else $oSolicitudProyecto->setBl_seleccionado(0);
    		$nuevosProyectos->addItem($oSolicitudProyecto);
    	}
    	
        $_SESSION[$this->getVariableSessionName()] = serialize($nuevosProyectos);
    	
    }

    /**
     * quitamos todos los proyectos de sesión
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
			$proyectos = unserialize( $_SESSION[$this->getVariableSessionName()] );
		else 
			$proyectos = new ItemCollection();	

		return $proyectos;
    }

    /**
     * se obtiene la cantidad de entities dado el filtro de búsqueda
     * @param CdtSearchCriteria $oCriteria filtro de búsqueda.
     * @return int
     */
    public function getEntitiesCount(CdtSearchCriteria $oCriteria, $idConn=0) {
        
    	$proyectos = unserialize($this->getVariableSessionName() );

        return $proyectos->size();
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