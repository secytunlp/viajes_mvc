<?php

/**
 * DAO para Monto
 *
 * @author Marcos
 * @since 21-11-2013
 */
class MontoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_MONTO;
	}

	public function getEntityFactory(){
		return new MontoFactory();
	}
	
	public function getIdFieldName(){
		return "cd_monto";
	}
	
	public function getFieldsToAdd($entity){

		$fieldsValues = array();
		$fieldsValues["cd_solicitud"] = $this->formatIfNull( $entity->getSolicitud()->getOid(), 'null' );
		$fieldsValues["ds_institucion"] = $this->formatString( $entity->getDs_institucion() );
		$fieldsValues["ds_caracter"] = $this->formatString( $entity->getDs_caracter() );
		$fieldsValues["nu_monto"] = $this->formatIfNull( $entity->getNu_monto(),0 );
		
		
		
		return $fieldsValues;
	}
	
	public function getFromToSelect(){
		
		$tMonto = $this->getTableName();
		
		$tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tSolicitud . " ON($tMonto.cd_solicitud = $tSolicitud.cd_solicitud)";
       
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		
		
		$fields = parent::getFieldsToSelect();
		
                
        $tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		$fields[] = "$tSolicitud.cd_solicitud as " . $tSolicitud . "_oid ";
        
       
        
        return $fields;
	}	
	
	public function deleteMontoPorSolicitud($solicitud_oid, $idConn=0) {
    	
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