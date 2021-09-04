<?php

/**
 * DAO para PuntajePlan
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PuntajePlanDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_PUNTAJE_PLAN;
	}
	
	public function getEntityFactory(){
		return new PuntajePlanFactory();
	}
	
	public function getFieldsToAdd($entity){
		$fieldsValues = array();
		$fieldsValues["cd_evaluacion"] = $this->formatIfNull( $entity->getEvaluacion()->getOid(), 'null' );
		$fieldsValues["cd_modeloplanilla"] = $this->formatIfNull( $entity->getModeloplanilla()->getOid(), 'null' );
		$fieldsValues["nu_puntaje"] = $this->formatIfNull( $entity->getNu_puntaje(), 'null' );	
		$fieldsValues["ds_justificacion"] = $this->formatString( $entity->getDs_justificacion() );
		return $fieldsValues;
		
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_puntajeplan";
	}
	
	
	
	public function deletePuntajePlanPorEvaluacion($evaluacion_oid, $idConn=0) {
    	
        $db = CdtDbManager::getConnection( $idConn );

        
        
        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE cd_evaluacion = $evaluacion_oid ";

        CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }
	

	
	
}
?>