<?php

/**
 * DAO para AmbitoCambio
 *
 * @author Marcos
 * @since 09-06-2015
 */
class AmbitoCambioDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_CAMBIO_AMBITO;
	}

	public function getEntityFactory(){
		return new AmbitoCambioFactory();
	}
	
	public function getIdFieldName(){
		return "cd_ambito";
	}
	
	public function getFieldsToAdd($entity){

		$fieldsValues = array();
		
		$fieldsValues["cd_cambio"] = $this->formatIfNull( $entity->getCambio()->getOid(), 'null' );
		$fieldsValues["ds_institucion"] = $this->formatString( $entity->getDs_institucion() );
		$fieldsValues["ds_ciudad"] = $this->formatString( $entity->getDs_ciudad() );
		$fieldsValues["ds_pais"] = $this->formatString( $entity->getDs_pais() );
		$fieldsValues["dt_desde"] = $this->formatDate( $entity->getDt_desde() );
		$fieldsValues["dt_hasta"] = $this->formatDate( $entity->getDt_hasta() );
		
		
		return $fieldsValues;
	}
	
	public function getFromToSelect(){
		
		$tAmbitoCambio = $this->getTableName();
		
		$tCambio = DAOFactory::getCambioDAO()->getTableName();
		
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tCambio . " ON($tAmbitoCambio.cd_cambio = $tCambio.cd_cambio)";
       
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		
		
		$fields = parent::getFieldsToSelect();
		
                
        $tCambio = DAOFactory::getCambioDAO()->getTableName();
		$fields[] = "$tCambio.cd_cambio as " . $tCambio . "_oid ";
        
       
        
        return $fields;
	}	
	
	public function deleteAmbitoCambioPorCambio($cambio_oid, $idConn=0) {
    	
        $db = CdtDbManager::getConnection( $idConn );

        
        
        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE cd_cambio = $cambio_oid ";

        CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>