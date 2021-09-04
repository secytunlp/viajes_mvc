<?php

/**
 * Helper DAO para administrar en sesión los presupuestos de una 
 * solicitud.
 *  
 * @author Marcos
 * @since 02-01-2014
 */
class PresupuestoSessionDAO extends EntityDAO {

	public function getFieldsToAdd($entity){}
	
	public function getFieldsToUpdate($entity){}
	
	public function getId($entity){}
		
	public function getIdFieldName(){}
	
	public function setId($entity, $id){}
	
	public function getTableName(){}
	
	public function getEntityFactory(){}
	
	public function getVariableSessionName(){
		return "presupuestos";
	}
	
    /**
     * se persiste la nueva entity
     * @param $entity entity a persistir.
     */
    public function addEntity( $entity, $idConn=0 ) {
    	
    	$presupuestos = unserialize( $_SESSION[ $this->getVariableSessionName() ] );
    	
    	if( empty($presupuestos) )
    		$presupuestos = new ItemCollection();
    	$this->validateOnAdd($entity);
    	$presupuestos->addItem($entity);
        
        $_SESSION[$this->getVariableSessionName()] = serialize($presupuestos);
        
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
    	
    	$presupuestos = unserialize( $_SESSION[$this->getVariableSessionName()] );
    	
    	
    	$nuevosPresupuestos = new ItemCollection();
    	foreach ($presupuestos as $oPresupuesto) {
	    	$ds_presupuesto = $oPresupuesto->getDs_presupuesto().' - ';
			switch ($oPresupuesto->getDs_presupuesto()) {
					case CYT_CD_VIATICO:
					
					$ds_presupuesto .= CYT_LBL_PRESUPUESTO_DIAS.': '.$oPresupuesto->getDs_dias().' - '.CYT_LBL_PRESUPUESTO_LUGAR.': '.$oPresupuesto->getDs_lugar();
					break;
					
					case CYT_DS_PASAJE:
					
					$ds_presupuesto .= $oPresupuesto->getDs_pasajes().' - '.CYT_LBL_PRESUPUESTO_DESTINO.': '.$oPresupuesto->getDs_destino();
					break;
					
					case CYT_CD_INSCRIPCION:
					$ds_presupuesto .= CYT_LBL_PRESUPUESTO_DESCRIPCION.': '.$oPresupuesto->getDs_inscripcion();
					break;
				}
    		if( $ds_presupuesto != $oid ){
    			$nuevosPresupuestos->addItem($oPresupuesto);
    		}
    	}
    	
        $_SESSION[$this->getVariableSessionName()] = serialize($nuevosPresupuestos);
    	
    }

    /**
     * quitamos todos los presupuestos de sesión
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
			$presupuestos = unserialize( $_SESSION[$this->getVariableSessionName()] );
		else 
			$presupuestos = new ItemCollection();	

		return $presupuestos;
    }

    /**
     * se obtiene la cantidad de entities dado el filtro de búsqueda
     * @param CdtSearchCriteria $oCriteria filtro de búsqueda.
     * @return int
     */
    public function getEntitiesCount(CdtSearchCriteria $oCriteria, $idConn=0) {
        
    	$presupuestos = unserialize($this->getVariableSessionName() );

        return $presupuestos->size();
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
    	
    	
    	$error = '';
    		
    	/*if((CYTSecureUtils::formatDateToPersist($entity->getDt_fecha())<CYTSecureUtils::formatDateToPersist(CYT_RANGO_INI.CYT_PERIODO_YEAR))||(CYTSecureUtils::formatDateToPersist($entity->getDt_fecha())>CYTSecureUtils::formatDateToPersist(CYT_RANGO_FIN.((int)CYT_PERIODO_YEAR+1)))){
    			$error .= CYT_MSG_PRESUPUESTO_FECHA_FUERA_RANGO.'<br>';
    			
    		}*/
    		
    		
    		
    	
    	if ($error) {
    		throw new GenericException( $error );
    	}
    }
		
}
?>