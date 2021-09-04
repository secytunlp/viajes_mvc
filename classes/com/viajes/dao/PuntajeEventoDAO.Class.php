<?php

/**
 * DAO para PuntajeEvento
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PuntajeEventoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_PUNTAJE_EVENTO;
	}
	
	public function getEntityFactory(){
		return new PuntajeEventoFactory();
	}
	
	public function getFieldsToAdd($entity){
		$fieldsValues = array();
		$fieldsValues["cd_evaluacion"] = $this->formatIfNull( $entity->getEvaluacion()->getOid(), 'null' );
		$fieldsValues["cd_modeloplanilla"] = $this->formatIfNull( $entity->getModeloplanilla()->getOid(), 'null' );
		$fieldsValues["cd_eventomaximo"] = $this->formatIfNull( $entity->getEventomaximo()->getOid(), 'null' );	
		$fieldsValues["nu_puntaje"] = $this->formatString( $entity->getNu_puntaje() );
		$fieldsValues["ds_justificacion"] = $this->formatString( $entity->getDs_justificacion() );
		return $fieldsValues;
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_puntajeevento";
	}
	
	public function getFromToSelect(){
		$tPuntajeEvento = $this->getTableName();
		$tEventoMaximo = DAOFactory::getEventoMaximoDAO()->getTableName();
		
		$sql  = parent::getFromToSelect();
		
		$sql .= " LEFT JOIN " . $tEventoMaximo . " ON($tPuntajeEvento.cd_eventomaximo = $tEventoMaximo.cd_eventomaximo)";
		
		 return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$fields = parent::getFieldsToSelect();
		
		$tEventoMaximo = DAOFactory::getEventoMaximoDAO()->getTableName();
        $fields[] = "$tEventoMaximo.cd_eventomaximo as " . $tEventoMaximo . "_oid ";
        
        
         return $fields;
	}
	
	public function deletePuntajeEventoPorEvaluacion($evaluacion_oid, $idConn=0) {
    	
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