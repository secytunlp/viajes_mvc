<?php

/**
 * DAO para PuntajeItem
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PuntajeItemDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_PUNTAJE_ITEM;
	}
	
	public function getEntityFactory(){
		return new PuntajeItemFactory();
	}
	
	public function getFieldsToAdd($entity){
		$fieldsValues = array();
		$fieldsValues["cd_evaluacion"] = $this->formatIfNull( $entity->getEvaluacion()->getOid(), 'null' );
		$fieldsValues["cd_modeloplanilla"] = $this->formatIfNull( $entity->getModeloplanilla()->getOid(), 'null' );
		$fieldsValues["cd_itemmaximo"] = $this->formatIfNull( $entity->getItemmaximo()->getOid(), 'null' );	
		$fieldsValues["nu_puntaje"] = $this->formatString( $entity->getNu_puntaje() );
		$fieldsValues["nu_cantidad"] = $this->formatString( $entity->getNu_cantidad() );
		return $fieldsValues;
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_puntajeitem";
	}
	
	public function getFromToSelect(){
		$tPuntajeItem = $this->getTableName();
		$tItemMaximo = DAOFactory::getItemMaximoDAO()->getTableName();
		
		$sql  = parent::getFromToSelect();
		
		$sql .= " LEFT JOIN " . $tItemMaximo . " ON($tPuntajeItem.cd_itemmaximo = $tItemMaximo.cd_itemmaximo)";
		
		 return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$fields = parent::getFieldsToSelect();
		
		$tItemMaximo = DAOFactory::getItemMaximoDAO()->getTableName();
        $fields[] = "$tItemMaximo.cd_itemmaximo as " . $tItemMaximo . "_oid ";
        
        
         return $fields;
	}
	
	public function deletePuntajeItemPorEvaluacion($evaluacion_oid, $idConn=0) {
    	
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