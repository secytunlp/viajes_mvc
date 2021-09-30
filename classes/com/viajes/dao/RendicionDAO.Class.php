<?php

/**
 * DAO para Rendicion
 *
 * @author Marcos
 * @since 29-09-2021
 */
class RendicionDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_RENDICION;
	}

	public function getEntityFactory(){
		return new RendicionFactory();
	}



	public function getFieldsToAdd($entity){

		$fieldsValues = array();

		$fieldsValues["cd_solicitud"] = $this->formatIfNull( $entity->getSolicitud()->getOid(), 'null' );
		$fieldsValues["dt_fecha"] = $this->formatString($entity->getDt_fecha());
		$fieldsValues["ds_rendicion"] = $this->formatString($entity->getDs_rendicion());
        $fieldsValues["ds_informe"] = $this->formatString($entity->getDs_informe());
        $fieldsValues["ds_certificado"] = $this->formatString($entity->getDs_certificado());
		$fieldsValues["ds_observacion"] = $this->formatString($entity->getDs_observacion());
		return $fieldsValues;
	}

	public function getFieldsToUpdate($entity){

		$fieldsValues = array();
		$fieldsValues["dt_fecha"] = $this->formatString($entity->getDt_fecha());
        $fieldsValues["ds_rendicion"] = $this->formatString($entity->getDs_rendicion());
        $fieldsValues["ds_informe"] = $this->formatString($entity->getDs_informe());
        $fieldsValues["ds_certificado"] = $this->formatString($entity->getDs_certificado());
		$fieldsValues["ds_observacion"] = $this->formatString($entity->getDs_observacion());

		return $fieldsValues;
	}



    public function getFromToSelect(){

        $tRendicion = $this->getTableName();

        $tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();

        $tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
        $tRendicionEstado = CYTSecureDAOFactory::getRendicionEstadoDAO()->getTableName();

        $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
        $tPeriodo = CYTSecureDAOFactory::getPeriodoDAO()->getTableName();
        $sql  = parent::getFromToSelect();

        $sql .= " LEFT JOIN " . $tSolicitud . " ON($tRendicion.solicitud_oid = $tSolicitud.cd_solicitud)";
        $sql .= " LEFT JOIN " . $tPeriodo . " ON($tSolicitud.cd_periodo = $tPeriodo.cd_periodo)";
        $sql .= " LEFT JOIN " . $tDocente . " ON($tSolicitud.cd_docente = $tDocente.cd_docente)";
        $sql .= " LEFT JOIN " . $tRendicionEstado . " ON($tRendicionEstado.rendicion_oid = $tRendicion.oid)";
        $sql .= " LEFT JOIN " . $tEstado . " ON($tRendicionEstado.estado_oid = $tEstado.cd_estado)";



        return $sql;
    }

    public function getFieldsToSelect(){

        $fields = array();
        $fields[] = $this->getTableName() . ".oid as oid ";

        $fields[] = $this->getTableName() . ".solicitud_oid ";
        $fields[] = $this->getTableName() . ".dt_fecha ";
        $fields[] = $this->getTableName() . ".ds_rendicion ";
        $fields[] = $this->getTableName() . ".ds_informe ";
        $fields[] = $this->getTableName() . ".ds_certificado ";

        $fields[] = $this->getTableName() . ".ds_observacion ";


        $tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
        $fields[] = "$tSolicitud.cd_solicitud as " . $tSolicitud . "_oid ";



        $tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
        $fields[] = "$tEstado.cd_estado as " . $tEstado . "_oid ";
        $fields[] = "$tEstado.ds_estado as " . $tEstado . "_ds_estado ";

        $tRendicionEstado = CYTSecureDAOFactory::getRendicionEstadoDAO()->getTableName();
        $fields[] = "$tRendicionEstado.oid as " . $tRendicionEstado . "_oid ";
        $fields[] = "$tRendicionEstado.fechaDesde as " . $tRendicionEstado . "_fechaDesde ";
        $fields[] = "$tRendicionEstado.fechaHasta as " . $tRendicionEstado . "_fechaHasta ";

        $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
        $fields[] = "$tDocente.cd_docente as " . $tDocente . "_oid ";
        $fields[] = "$tDocente.ds_nombre as " . $tDocente . "_ds_nombre ";
        $fields[] = "$tDocente.ds_apellido as " . $tDocente . "_ds_apellido ";
        $fields[] = "$tDocente.nu_documento as " . $tDocente . "_nu_documento ";
        $fields[] = "$tDocente.nu_precuil as " . $tDocente . "_nu_precuil ";
        $fields[] = "$tDocente.nu_postcuil as " . $tDocente . "_nu_postcuil ";

        $tPeriodo = CYTSecureDAOFactory::getPeriodoDAO()->getTableName();
        $fields[] = "$tPeriodo.cd_periodo as " . $tPeriodo . "_oid ";
        $fields[] = "$tPeriodo.ds_periodo as " . $tPeriodo . "_ds_periodo ";

        return $fields;
    }

    public function deleteRendicionPorSolicitud($solicitud_oid, $idConn=0) {

        $db = CdtDbManager::getConnection( $idConn );



        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE solicitud_oid = $solicitud_oid ";

        CdtUtils::log($sql, __CLASS__,LoggerLevel::getLevelDebug());

        $result = $db->sql_query($sql);
        if (!$result)//hubo un error en la bbdd.
            throw new DBException($db->sql_error());
    }

}
?>
