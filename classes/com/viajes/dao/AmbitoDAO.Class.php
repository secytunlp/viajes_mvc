<?php

/**
 * DAO para Ambito
 *
 * @author Marcos
 * @since 17-11-2013
 */
class AmbitoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_AMBITO;
	}

	public function getEntityFactory(){
		return new AmbitoFactory();
	}
	
	public function getIdFieldName(){
		return "cd_ambito";
	}
	
	public function getFieldsToAdd($entity){

		$fieldsValues = array();
		
		$fieldsValues["cd_solicitud"] = $this->formatIfNull( $entity->getSolicitud()->getOid(), 'null' );
		$fieldsValues["ds_institucion"] = $this->formatString( $entity->getDs_institucion() );
		$fieldsValues["ds_ciudad"] = $this->formatString( $entity->getDs_ciudad() );
		$fieldsValues["ds_pais"] = $this->formatString( $entity->getDs_pais() );
		$fieldsValues["dt_desde"] = $this->formatDate( $entity->getDt_desde() );
		$fieldsValues["dt_hasta"] = $this->formatDate( $entity->getDt_hasta() );
		
		
		return $fieldsValues;
	}
	
	public function getFromToSelect(){
		
		$tAmbito = $this->getTableName();
		
		$tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tSolicitud . " ON($tAmbito.cd_solicitud = $tSolicitud.cd_solicitud)";
       
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		
		
		$fields = parent::getFieldsToSelect();
		
                
        $tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		$fields[] = "$tSolicitud.cd_solicitud as " . $tSolicitud . "_oid ";
        
       
        
        return $fields;
	}	
	
	public function deleteAmbitoPorSolicitud($solicitud_oid, $idConn=0) {
    	
        $db = CdtDbManager::getConnection( $idConn );

        
        
        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE cd_solicitud = $solicitud_oid ";

        CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>