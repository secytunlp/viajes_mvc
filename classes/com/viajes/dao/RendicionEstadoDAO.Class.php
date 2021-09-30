<?php

/**
 * DAO para Cambio Estado
 *
 * @author Marcos
 * @since 29-09-2021
 */
class RendicionEstadoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_RENDICION_ESTADO;
	}

	public function getEntityFactory(){
		return new RendicionEstadoFactory();
	}

	public function getFieldsToAdd($entity){

		$fieldsValues = array();


		$fieldsValues["rendicion_oid"] = $this->formatIfNull( $entity->getRendicion()->getOid(), 'null' );
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


		$fieldsValues["rendicion_oid"] = $this->formatIfNull( $entity->getRendicion()->getOid(), 'null' );
		$fieldsValues["estado_oid"] = $this->formatIfNull( $entity->getEstado()->getOid(), 'null' );


		$fieldsValues["fechaDesde"] = $this->formatDate( $entity->getFechaDesde() );
		$fieldsValues["fechaHasta"] = $this->formatDate( $entity->getFechaHasta() );
		$fieldsValues["motivo"] = $this->formatString( $entity->getMotivo() );
		//$fieldsValues["user_oid"] = $this->formatIfNull( $entity->getUser()->getCd_user(), 'null' );
		$fieldsValues["fechaUltModificacion"] = $this->formatString($entity->getFechaUltModificacion());

		return $fieldsValues;
	}

	public function getFromToSelect(){

		$tRendicionEstado = $this->getTableName();

		$tRendicion = DAOFactory::getRendicionDAO()->getTableName();

		$tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		$tUser = CYTSecureDAOFactory::getUserDAO()->getTableName();

        $sql  = parent::getFromToSelect();

        $sql .= " LEFT JOIN " . $tRendicion . " ON($tRendicionEstado.rendicion_oid = $tRendicion.oid)";
       // $sql .= " LEFT JOIN " . $tUser . " U ON($tRendicion.cd_usuario = U.oid)";
       	$sql .= " LEFT JOIN " . $tEstado . " ON($tRendicionEstado.estado_oid = $tEstado.cd_estado)";

        $sql .= " LEFT JOIN " . $tUser . " ON($tRendicionEstado.user_oid = $tUser.oid)";

        return $sql;
	}

	public function getFieldsToSelect(){

		$tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();

		$fields = parent::getFieldsToSelect();


        $tRendicion = DAOFactory::getRendicionDAO()->getTableName();
		$fields[] = "$tRendicion.oid as " . $tRendicion . "_oid ";





        $tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		$fields[] = "$tEstado.cd_estado as " . $tEstado . "_oid ";
        $fields[] = "$tEstado.ds_estado as " . $tEstado . "_ds_estado ";

        $tUser = CYTSecureDAOFactory::getUserDAO()->getTableName();
		$fields[] = "$tUser.oid AS ".$tUser."_oid";
        $fields[] = "CASE $tUser.ds_name WHEN '' THEN $tUser.ds_username ELSE $tUser.ds_name END AS ".$tUser."_ds_username";

        return $fields;
	}

	public function deleteRendicionEstadoPorRendicion($rendicion_oid, $idConn=0) {

        $db = CdtDbManager::getConnection( $idConn );



        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE rendicion_oid = $rendicion_oid ";

        CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>
