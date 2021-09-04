<?php

/**
 * DAO para PuntajeCategoria
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PuntajeCategoriaDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_PUNTAJE_CATEGORIA;
	}
	
	public function getEntityFactory(){
		return new PuntajeCategoriaFactory();
	}
	
	public function getFieldsToAdd($entity){
		$fieldsValues = array();
		$fieldsValues["cd_evaluacion"] = $this->formatIfNull( $entity->getEvaluacion()->getOid(), 'null' );
		$fieldsValues["cd_modeloplanilla"] = $this->formatIfNull( $entity->getModeloplanilla()->getOid(), 'null' );
		$fieldsValues["cd_categoriamaximo"] = $this->formatIfNull( $entity->getCategoriamaximo()->getOid(), 'null' );	
		
		return $fieldsValues;
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_puntajecategoria";
	}
	
	public function getFromToSelect(){
		$tPuntajeCategoria = $this->getTableName();
		$tCategoriaMaximo = DAOFactory::getCategoriaMaximoDAO()->getTableName();
		
		$sql  = parent::getFromToSelect();
		
		$sql .= " LEFT JOIN " . $tCategoriaMaximo . " ON($tPuntajeCategoria.cd_categoriamaximo = $tCategoriaMaximo.cd_categoriamaximo)";
		
		 return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$fields = parent::getFieldsToSelect();
		
		$tCategoriaMaximo = DAOFactory::getCategoriaMaximoDAO()->getTableName();
        $fields[] = "$tCategoriaMaximo.cd_categoriamaximo as " . $tCategoriaMaximo . "_oid ";
        
        
         return $fields;
	}
	
	
	public function deletePuntajeCategoriaPorEvaluacion($evaluacion_oid, $idConn=0) {
    	
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