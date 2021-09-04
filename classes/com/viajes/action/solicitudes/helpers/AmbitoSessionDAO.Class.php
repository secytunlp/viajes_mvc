<?php

/**
 * Helper DAO para administrar en sesión los ambitos de una 
 * solicitud.
 *  
 * @author Marcos
 * @since 20-12-2013
 */
class AmbitoSessionDAO extends EntityDAO {

	public function getFieldsToAdd($entity){}
	
	public function getFieldsToUpdate($entity){}
	
	public function getId($entity){}
		
	public function getIdFieldName(){}
	
	public function setId($entity, $id){}
	
	public function getTableName(){}
	
	public function getEntityFactory(){}
	
	public function getVariableSessionName(){
		return "ambitos";
	}
	
    /**
     * se persiste la nueva entity
     * @param $entity entity a persistir.
     */
    public function addEntity( $entity, $idConn=0 ) {
    	
    	$ambitos = unserialize( $_SESSION[ $this->getVariableSessionName() ] );
    	
    	if( empty($ambitos) )
    		$ambitos = new ItemCollection();
    	$this->validateOnAdd($entity);
    	$ambitos->addItem($entity);
        
        $_SESSION[$this->getVariableSessionName()] = serialize($ambitos);
        
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
    	
    	$ambitos = unserialize( $_SESSION[$this->getVariableSessionName()] );
    	
    	
    	$nuevosAmbitos = new ItemCollection();
    	foreach ($ambitos as $oAmbito) {
    		
    		if( $oAmbito->getDs_institucion() != $oid ){
    			$nuevosAmbitos->addItem($oAmbito);
    		}
    	}
    	
        $_SESSION[$this->getVariableSessionName()] = serialize($nuevosAmbitos);
    	
    }

    /**
     * quitamos todos los ambitos de sesión
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
			$ambitos = unserialize( $_SESSION[$this->getVariableSessionName()] );
		else 
			$ambitos = new ItemCollection();	

		return $ambitos;
    }

    /**
     * se obtiene la cantidad de entities dado el filtro de búsqueda
     * @param CdtSearchCriteria $oCriteria filtro de búsqueda.
     * @return int
     */
    public function getEntitiesCount(CdtSearchCriteria $oCriteria, $idConn=0) {
        
    	$ambitos = unserialize($this->getVariableSessionName() );

        return $ambitos->size();
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
    
/**
	 * (non-PHPdoc)
	 * @see classes/com/entities/manager/EntityManager::validateOnAdd()
	 */
    protected function validateOnAdd(Entity $entity){
    	
    	/*$oSolicitudManager =  ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode(CdtUtils::getParam('solicitud_oid'));*/
    	$error = '';
    		if(CYTSecureUtils::formatDateToPersist($entity->getDt_desde())>CYTSecureUtils::formatDateToPersist($entity->getDt_hasta())){
    			$error .= CYT_MSG_AMBITO_DESDE_MAYOR.'<br>';
    			
    		}
    		if((CYTSecureUtils::formatDateToPersist($entity->getDt_desde())<CYTSecureUtils::formatDateToPersist(CYT_RANGO_INI.CYT_PERIODO_YEAR))||(CYTSecureUtils::formatDateToPersist($entity->getDt_desde())>CYTSecureUtils::formatDateToPersist(CYT_RANGO_FIN.((int)CYT_PERIODO_YEAR+1)))){
    			$error .= CYT_MSG_AMBITO_DESDE_FUERA_RANGO.'<br>';
    			
    		}
    		/*if((CYTSecureUtils::formatDateToPersist($entity->getDt_hasta())<CYTSecureUtils::formatDateToPersist(CYT_RANGO_INI.CYT_PERIODO_YEAR))||(CYTSecureUtils::formatDateToPersist($entity->getDt_hasta())>CYTSecureUtils::formatDateToPersist(CYT_RANGO_FIN.((int)CYT_PERIODO_YEAR+1)))){
    			$error .= CYT_MSG_AMBITO_HASTA_FUERA_RANGO.'<br>';
    			
    		}*/
    		
    		/*if((CYTSecureUtils::formatDateToPersist($entity->getDt_desde())<CYTSecureUtils::formatDateToPersist(CYT_RANGO_INI.$oSolicitud->getPeriodo()->getDs_periodo()))||(CYTSecureUtils::formatDateToPersist($entity->getDt_desde())>CYTSecureUtils::formatDateToPersist(CYT_RANGO_FIN.((int)$oSolicitud->getPeriodo()->getDs_periodo()+1)))){
    			$error .= CYT_MSG_AMBITO_DESDE_FUERA_RANGO.'<br>';
    			
    		}*/
    		
    		
    		
    		
    	
    	if ($error) {
    		throw new GenericException( $error );
    	}
    }
		
}
?>