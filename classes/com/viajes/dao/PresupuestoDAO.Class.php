<?php

/**
 * DAO para Presupuesto
 *
 * @author Marcos
 * @since 17-11-2013
 */
class PresupuestoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_PRESUPUESTO;
	}

	public function getEntityFactory(){
		return new PresupuestoFactory();
	}
	
	public function getIdFieldName(){
		return "cd_presupuesto";
	}
	
	public function getFieldsToAdd($entity){
		$fieldsValues = array();
		$fieldsValues["cd_solicitud"] = $this->formatIfNull( $entity->getSolicitud()->getOid(), 'null' );
		$ds_presupuesto = $entity->getDs_presupuesto().'|';
		switch ($entity->getDs_presupuesto()) {
				case CYT_CD_VIATICO:
				
				$ds_presupuesto .= $entity->getDs_dias().'|'.$entity->getDs_lugar();
				break;
				
				case CYT_DS_PASAJE:
				
				$ds_presupuesto .= $entity->getDs_pasajes().'|'.$entity->getDs_destino();
				break;
				
				case CYT_CD_INSCRIPCION:
				$ds_presupuesto .= $entity->getDs_inscripcion();
				break;
			}
		
		
		$fieldsValues["ds_presupuesto"] = $this->formatString( $ds_presupuesto );
		$fieldsValues["cd_tipopresupuesto"] = CYT_CD_PRESUPUESTO_TIPO_2;
		$fieldsValues["nu_monto"] = $this->formatString($this->formatIfNull( $entity->getNu_montopresupuesto(),0 ));
		$fieldsValues["dt_fecha"] = $this->formatDate( $entity->getDt_fecha() );
		
		
		return $fieldsValues;

	}
	
	public function getFromToSelect(){
		
		$tPresupuesto = $this->getTableName();
		
		$tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tSolicitud . " ON($tPresupuesto.cd_solicitud = $tSolicitud.cd_solicitud)";
       
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		$fields = parent::getFieldsToSelect();
		
		$tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		$fields[] = "$tSolicitud.cd_solicitud as " . $tSolicitud . "_oid ";
        
       	return $fields;
	}	
	
	public function deletePresupuestoPorSolicitud($solicitud_oid, $idConn=0) {
    	
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