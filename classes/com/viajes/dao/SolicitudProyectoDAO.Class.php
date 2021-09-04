<?php

/**
 * DAO para Solicitud Proyecto
 *
 * @author Marcos
 * @since 20-11-2013
 */
class SolicitudProyectoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_SOLICITUD_PROYECTO;
	}

	public function getEntityFactory(){
		return new SolicitudProyectoFactory();
	}
	
	public function getFieldsToAdd($entity){
		$fieldsValues = array();
		
		$fieldsValues["solicitud_oid"] = $this->formatIfNull( $entity->getSolicitud()->getOid(), 'null' );
		$fieldsValues["proyecto_oid"] = $this->formatIfNull( $entity->getProyecto()->getOid(), 'null' );
		
		
		$fieldsValues["dt_alta"] = $this->formatDate( $entity->getDt_alta() );
		$fieldsValues["dt_baja"] = $this->formatDate( $entity->getDt_baja() );
		$fieldsValues["bl_seleccionado"] = $this->formatIfNull( $entity->getBl_seleccionado(),0 );
		
		return $fieldsValues;
		
	}
	
	public function getFromToSelect(){
		
		$tSolicitudProyecto = $this->getTableName();
		
		$tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
		
		$tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
		
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		
		$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
		
		$tTipoEstadoProyecto = CYTSecureDAOFactory::getTipoEstadoProyectoDAO()->getTableName();
		
		$tDisciplina = CYTSecureDAOFactory::getDisciplinaDAO()->getTableName();
		$tEspecialidad = CYTSecureDAOFactory::getEspecialidadDAO()->getTableName();
		
        $sql  = parent::getFromToSelect();
        $sql .= " LEFT JOIN " . $tSolicitud . " ON($tSolicitudProyecto.solicitud_oid = $tSolicitud.cd_solicitud)";
       
        $sql .= " LEFT JOIN " . $tProyecto . " ON($tSolicitudProyecto.proyecto_oid = $tProyecto.cd_proyecto)";
       	/*$sql .= " LEFT JOIN " . $tIntegrante . " ON($tProyecto.cd_proyecto = $tIntegrante.cd_proyecto)";
        $sql .= " LEFT JOIN " . $tDocente . " ON($tIntegrante.cd_docente = $tDocente.cd_docente)";*/
        $sql .= " LEFT JOIN " . $tTipoEstadoProyecto . " ON($tProyecto.cd_estado = $tTipoEstadoProyecto.cd_estado)";
        
        $sql .= " LEFT JOIN " . $tIntegrante . " DIR ON($tProyecto.cd_proyecto = DIR.cd_proyecto)";
        $sql .= " LEFT JOIN " . $tDocente . " DOCDIR ON(DIR.cd_docente = DOCDIR.cd_docente)";
        
        $sql .= " LEFT JOIN " . $tDisciplina . " ON($tProyecto.cd_disciplina = $tDisciplina.cd_disciplina)";
        $sql .= " LEFT JOIN " . $tEspecialidad . " ON($tProyecto.cd_especialidad = $tEspecialidad.cd_especialidad)";
       
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		
		
		$fields = parent::getFieldsToSelect();
		
        
        $tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
        $fields[] = "$tSolicitud.cd_solicitud as " . $tSolicitud . "_oid ";
        
        $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
        $fields[] = "$tProyecto.cd_proyecto as " . $tProyecto . "_oid ";
        $fields[] = "$tProyecto.ds_titulo as " . $tProyecto . "_ds_titulo ";
        $fields[] = "$tProyecto.ds_codigo as " . $tProyecto . "_ds_codigo ";
        $fields[] = "$tProyecto.ds_abstract1 as " . $tProyecto . "_ds_abstract1 ";
        
        
         
       /*$tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
       $fields[] = "$tIntegrante.cd_integrante as " . $tIntegrante . "_oid ";*/
        
       	
        /*$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
        $fields[] = "$tDocente.cd_docente as " . $tDocente . "_oid ";
        $fields[] = "$tDocente.ds_apellido as " . $tDocente . "_ds_apellido ";
        $fields[] = "$tDocente.ds_nombre as " . $tDocente . "_ds_nombre ";*/
        
        $tTipoEstadoProyecto = CYTSecureDAOFactory::getTipoEstadoProyectoDAO()->getTableName();
        $fields[] = "$tTipoEstadoProyecto.cd_estado as " . $tTipoEstadoProyecto . "_oid ";
        $fields[] = "$tTipoEstadoProyecto.ds_estado as " . $tTipoEstadoProyecto . "_ds_estado ";
       
        $tDocente = 'DOCDIR';
        $fields[] = "$tDocente.cd_docente as " . $tDocente . "_oid ";
        $fields[] = "$tDocente.ds_apellido as " . $tDocente . "_ds_apellido ";
        $fields[] = "$tDocente.ds_nombre as " . $tDocente . "_ds_nombre ";
        
        $tDisciplina = CYTSecureDAOFactory::getDisciplinaDAO()->getTableName();
        $fields[] = "$tDisciplina.cd_disciplina as " . $tDisciplina . "_oid ";
        $fields[] = "$tDisciplina.ds_disciplina as " . $tDisciplina . "_ds_disciplina ";
        
        $tEspecialidad = CYTSecureDAOFactory::getEspecialidadDAO()->getTableName();
        $fields[] = "$tEspecialidad.cd_especialidad as " . $tEspecialidad . "_oid ";
        $fields[] = "$tEspecialidad.ds_especialidad as " . $tEspecialidad . "_ds_especialidad ";
        
        return $fields;
	}	
	
	
	public function deleteSolicitudProyectoPorSolicitud($solicitud_oid, $idConn=0) {
    	
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