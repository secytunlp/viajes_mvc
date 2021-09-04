<?php

/**
 * DAO para ItemPlanilla
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class ItemPlanillaDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_ITEM_PLANILLA;
	}
	
	public function getEntityFactory(){
		return new ItemPlanillaFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_itemplanilla";
	}
	
	
	
	
	

	
	
}
?>