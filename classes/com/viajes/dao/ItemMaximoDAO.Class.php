<?php

/**
 * DAO para ItemMaximo
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class ItemMaximoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_ITEM_MAXIMO;
	}
	
	public function getEntityFactory(){
		return new ItemMaximoFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_itemmaximo";
	}
	
	public function getFromToSelect(){
		$tItemMaximo = $this->getTableName();
		$tItemPlanilla = DAOFactory::getItemPlanillaDAO()->getTableName();
		$tPuntajeGrupo = DAOFactory::getPuntajeGrupoDAO()->getTableName();
		
		$sql  = parent::getFromToSelect();
		
		$sql .= " LEFT JOIN " . $tItemPlanilla . " ON($tItemMaximo.cd_itemplanilla = $tItemPlanilla.cd_itemplanilla)";
		$sql .= " LEFT JOIN " . $tPuntajeGrupo . " ON($tItemMaximo.cd_puntajegrupo = $tPuntajeGrupo.cd_puntajegrupo)";
		
		 return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$fields = parent::getFieldsToSelect();
		
		$tItemPlanilla = DAOFactory::getItemPlanillaDAO()->getTableName();
        $fields[] = "$tItemPlanilla.cd_itemplanilla as " . $tItemPlanilla . "_oid ";
        $fields[] = "$tItemPlanilla.ds_itemplanilla as " . $tItemPlanilla . "_ds_itemplanilla ";
        
        $tPuntajeGrupo = DAOFactory::getPuntajeGrupoDAO()->getTableName();
        $fields[] = "$tPuntajeGrupo.cd_puntajegrupo as " . $tPuntajeGrupo . "_oid ";
        $fields[] = "$tPuntajeGrupo.ds_puntajegrupo as " . $tPuntajeGrupo . "_ds_puntajegrupo ";
        $fields[] = "$tPuntajeGrupo.nu_max as " . $tPuntajeGrupo . "_nu_max ";
        $fields[] = "$tPuntajeGrupo.cd_grupopadre as " . $tPuntajeGrupo . "_cd_grupopadre ";
        
         return $fields;
	}
	

	
	
}
?>