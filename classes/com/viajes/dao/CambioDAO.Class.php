<?php

/**
 * DAO para Cambio
 *
 * @author Marcos
 * @since 06-08-2015
 */
class CambioDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_CAMBIO;
	}

	public function getEntityFactory(){
		return new CambioFactory();
	}
	
	public function getIdFieldName(){
		return "cd_cambio";
	}
	
	public function getFieldsToAdd($entity){

		$fieldsValues = array();
		
		$fieldsValues["cd_solicitud"] = $this->formatIfNull( $entity->getSolicitud()->getOid(), 'null' );
		$fieldsValues["dt_fecha"] = $this->formatString($entity->getDt_fecha());
		$fieldsValues["ds_archivo"] = $this->formatString($entity->getDs_archivo());	
		$fieldsValues["ds_observacion"] = $this->formatString($entity->getDs_observacion());	
		return $fieldsValues;
	}
	
	public function getFieldsToUpdate($entity){

		$fieldsValues = array();
		$fieldsValues["dt_fecha"] = $this->formatString($entity->getDt_fecha());
		$fieldsValues["ds_archivo"] = $this->formatString($entity->getDs_archivo());	
		$fieldsValues["ds_observacion"] = $this->formatString($entity->getDs_observacion());	

		return $fieldsValues;
	}
	
	
	
	public function getFromToSelect(){
		
		$tCambio = $this->getTableName();
		
		$tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		
		$tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		$tCambioEstado = DAOFactory::getCambioEstadoDAO()->getTableName();
		
		
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tSolicitud . " ON($tCambio.cd_solicitud = $tSolicitud.cd_solicitud)";
       
       	$sql .= " LEFT JOIN " . $tCambioEstado . " ON($tCambioEstado.cambio_oid = $tCambio.cd_cambio)";
        $sql .= " LEFT JOIN " . $tEstado . " ON($tCambioEstado.estado_oid = $tEstado.cd_estado)";
        
       
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$fields = array();
		$fields[] = $this->getTableName() . ".cd_cambio as oid ";
		
		$fields[] = $this->getTableName() . ".cd_solicitud ";
		$fields[] = $this->getTableName() . ".dt_fecha ";
		$fields[] = $this->getTableName() . ".ds_archivo ";
		
		$fields[] = $this->getTableName() . ".ds_observacion ";
		
                
        $tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		$fields[] = "$tSolicitud.cd_solicitud as " . $tSolicitud . "_oid ";
		
		
        
       	$tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		$fields[] = "$tEstado.cd_estado as " . $tEstado . "_oid ";
        $fields[] = "$tEstado.ds_estado as " . $tEstado . "_ds_estado ";
        
        $tCambioEstado = DAOFactory::getCambioEstadoDAO()->getTableName();
		$fields[] = "$tCambioEstado.oid as " . $tCambioEstado . "_oid ";
        $fields[] = "$tCambioEstado.fechaDesde as " . $tCambioEstado . "_fechaDesde ";
        $fields[] = "$tCambioEstado.fechaHasta as " . $tCambioEstado . "_fechaHasta ";
        
        
        
        return $fields;
	}	
	
	public function deleteCambioPorSolicitud($solicitud_oid, $idConn=0) {
    	
        $db = CdtDbManager::getConnection( $idConn );

        
        
        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE solicitud_oid = $solicitud_oid ";

        CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>