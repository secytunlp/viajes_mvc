<?php

/**
 * DAO para EventoPlanilla
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class EventoPlanillaDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_EVENTO_PLANILLA;
	}
	
	public function getEntityFactory(){
		return new EventoPlanillaFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_eventoplanilla";
	}
	
	
	
	
	

	
	
}
?>