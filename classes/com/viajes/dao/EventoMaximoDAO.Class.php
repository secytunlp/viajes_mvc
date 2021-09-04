<?php

/**
 * DAO para EventoMaximo
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class EventoMaximoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_EVENTO_MAXIMO;
	}
	
	public function getEntityFactory(){
		return new EventoMaximoFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_eventomaximo";
	}
	
	public function getFromToSelect(){
		$tEventoMaximo = $this->getTableName();
		$tEventoPlanilla = DAOFactory::getEventoPlanillaDAO()->getTableName();
		$tPuntajeGrupo = DAOFactory::getPuntajeGrupoDAO()->getTableName();
		
		$sql  = parent::getFromToSelect();
		
		$sql .= " LEFT JOIN " . $tEventoPlanilla . " ON($tEventoMaximo.cd_eventoplanilla = $tEventoPlanilla.cd_eventoplanilla)";
		$sql .= " LEFT JOIN " . $tPuntajeGrupo . " ON($tEventoMaximo.cd_puntajegrupo = $tPuntajeGrupo.cd_puntajegrupo)";
		
		 return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$fields = parent::getFieldsToSelect();
		
		$tEventoPlanilla = DAOFactory::getEventoPlanillaDAO()->getTableName();
        $fields[] = "$tEventoPlanilla.cd_eventoplanilla as " . $tEventoPlanilla . "_oid ";
        $fields[] = "$tEventoPlanilla.ds_eventoplanilla as " . $tEventoPlanilla . "_ds_eventoplanilla ";
        
        $tPuntajeGrupo = DAOFactory::getPuntajeGrupoDAO()->getTableName();
        $fields[] = "$tPuntajeGrupo.cd_puntajegrupo as " . $tPuntajeGrupo . "_oid ";
        $fields[] = "$tPuntajeGrupo.ds_puntajegrupo as " . $tPuntajeGrupo . "_ds_puntajegrupo ";
        $fields[] = "$tPuntajeGrupo.nu_max as " . $tPuntajeGrupo . "_nu_max ";
        
         return $fields;
	}
	

	
	
}
?>