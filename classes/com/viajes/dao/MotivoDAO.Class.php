<?php

/**
 * DAO para Motivo
 *  
 * @author Marcos
 * @since 13-11-2013
 */
class MotivoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_MOTIVO;
	}
	
	public function getEntityFactory(){
		return new MotivoFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_motivo";
	}
	
	
	
	
	

	
	
}
?>