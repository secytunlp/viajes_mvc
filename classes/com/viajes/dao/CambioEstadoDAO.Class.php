<?php

/**
 * DAO para Cambio Estado
 *
 * @author Marcos
 * @since 08-06-2015
 */
class CambioEstadoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_CAMBIO_ESTADO;
	}

	public function getEntityFactory(){
		return new CambioEstadoFactory();
	}
	
	public function getFieldsToAdd($entity){

		$fieldsValues = array();

		
		$fieldsValues["cambio_oid"] = $this->formatIfNull( $entity->getCambio()->getOid(), 'null' );
		$fieldsValues["estado_oid"] = $this->formatIfNull( $entity->getEstado()->getOid(), 'null' );
		
		
		$fieldsValues["fechaDesde"] = $this->formatDate( $entity->getFechaDesde() );
		$fieldsValues["fechaHasta"] = $this->formatDate( $entity->getFechaHasta() );
		$fieldsValues["motivo"] = $this->formatString( $entity->getMotivo() );
		$fieldsValues["user_oid"] = $this->formatIfNull( $entity->getUser()->getCd_user(), 'null' );
		$fieldsValues["fechaUltModificacion"] = $this->formatString($entity->getFechaUltModificacion());

		return $fieldsValues;
	}
	
	public function getFieldsToUpdate($entity){

		$fieldsValues = array();

		
		$fieldsValues["cambio_oid"] = $this->formatIfNull( $entity->getCambio()->getOid(), 'null' );
		$fieldsValues["estado_oid"] = $this->formatIfNull( $entity->getEstado()->getOid(), 'null' );
		
		
		$fieldsValues["fechaDesde"] = $this->formatDate( $entity->getFechaDesde() );
		$fieldsValues["fechaHasta"] = $this->formatDate( $entity->getFechaHasta() );
		$fieldsValues["motivo"] = $this->formatString( $entity->getMotivo() );
		//$fieldsValues["user_oid"] = $this->formatIfNull( $entity->getUser()->getCd_user(), 'null' );
		$fieldsValues["fechaUltModificacion"] = $this->formatString($entity->getFechaUltModificacion());

		return $fieldsValues;
	}
	
	public function getFromToSelect(){
		
		$tCambioEstado = $this->getTableName();
		
		$tCambio = DAOFactory::getCambioDAO()->getTableName();
		
		$tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		$tUser = CYTSecureDAOFactory::getUserDAO()->getTableName();
		
        $sql  = parent::getFromToSelect();
        
        $sql .= " LEFT JOIN " . $tCambio . " ON($tCambioEstado.cambio_oid = $tCambio.cd_cambio)";
       // $sql .= " LEFT JOIN " . $tUser . " U ON($tCambio.cd_usuario = U.oid)";
       	$sql .= " LEFT JOIN " . $tEstado . " ON($tCambioEstado.estado_oid = $tEstado.cd_estado)";
        
        $sql .= " LEFT JOIN " . $tUser . " ON($tCambioEstado.user_oid = $tUser.oid)";
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		
		$fields = parent::getFieldsToSelect();
		
                
        $tCambio = DAOFactory::getCambioDAO()->getTableName();
		$fields[] = "$tCambio.cd_cambio as " . $tCambio . "_oid ";
        
       	
		
        
        
        $tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		$fields[] = "$tEstado.cd_estado as " . $tEstado . "_oid ";
        $fields[] = "$tEstado.ds_estado as " . $tEstado . "_ds_estado ";
        
        $tUser = CYTSecureDAOFactory::getUserDAO()->getTableName();
		$fields[] = "$tUser.oid AS ".$tUser."_oid";
        $fields[] = "CASE $tUser.ds_name WHEN '' THEN $tUser.ds_username ELSE $tUser.ds_name END AS ".$tUser."_ds_username";
        
        return $fields;
	}	
	
	public function deleteCambioEstadoPorCambio($cambio_oid, $idConn=0) {
    	
        $db = CdtDbManager::getConnection( $idConn );

        
        
        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE cambio_oid = $cambio_oid ";

        CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());
        
        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>