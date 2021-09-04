<?php

/**
 * DAO para PresupuestoCambio
 *
 * @author Marcos
 * @since 09-06-2015
 */
class PresupuestoCambioDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_CAMBIO_PRESUPUESTO;
	}

	public function getEntityFactory(){
		return new PresupuestoCambioFactory();
	}
	
	public function getIdFieldName(){
		return "cd_presupuesto";
	}
	
	public function getFieldsToAdd($entity){
		$fieldsValues = array();
		$fieldsValues["cd_cambio"] = $this->formatIfNull( $entity->getCambio()->getOid(), 'null' );
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
		
		$tPresupuestoCambio = $this->getTableName();
		
		$tCambio = DAOFactory::getCambioDAO()->getTableName();
		
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tCambio . " ON($tPresupuestoCambio.cd_cambio = $tCambio.cd_cambio)";
       
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		$fields = parent::getFieldsToSelect();
		
		$tCambio = DAOFactory::getCambioDAO()->getTableName();
		$fields[] = "$tCambio.cd_cambio as " . $tCambio . "_oid ";
        
       	return $fields;
	}	
	
	public function deletePresupuestoCambioPorCambio($cambio_oid, $idConn=0) {
    	
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