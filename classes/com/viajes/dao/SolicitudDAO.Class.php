<?php

/**
 * DAO para Solicitud
 *  
 * @author Marcos
 * @since 12-11-2013
 */
class SolicitudDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_SOLICITUD;
	}
	
	public function getEntityFactory(){
		return new SolicitudFactory();
	}
	
	public function getFieldsToAdd($entity){
		$fieldsValues = array();
		
		$fieldsValues["cd_docente"] = $this->formatIfNull( $entity->getDocente()->getOid(), 'null' );
		$fieldsValues["cd_periodo"] = $this->formatIfNull( $entity->getPeriodo()->getOid(), 'null' );
		$fieldsValues["ds_mail"] = $this->formatString( $entity->getDs_mail() );
		$fieldsValues["ds_googleScholar"] = $this->formatString( $entity->getDs_googleScholar() );
		$fieldsValues["nu_telefono"] = $this->formatString( $entity->getNu_telefono() );
		$fieldsValues["dt_fecha"] = $this->formatDate( $entity->getDt_fecha() );
		$fieldsValues["ds_calle"] = $this->formatString( $entity->getDs_calle() );
		$fieldsValues["nu_nro"] = $this->formatString( $entity->getNu_nro() );
		$fieldsValues["nu_piso"] = $this->formatString( $entity->getNu_piso() );
		$fieldsValues["ds_depto"] = $this->formatString( $entity->getDs_depto() );
		$fieldsValues["nu_cp"] = $this->formatString( $entity->getNu_cp() );
		$fieldsValues["ds_titulogrado"] = $this->formatString( $entity->getDs_titulogrado() );
		$fieldsValues["cd_titulogrado"] = $this->formatIfNull( $entity->getTitulo()->getOid(), '0' );
		$fieldsValues["cd_unidad"] = $this->formatIfNull( $entity->getLugarTrabajo()->getOid(), '0' );
		$fieldsValues["cd_cargo"] = $this->formatIfNull( $entity->getCargo()->getOid(), '0' );
		$fieldsValues["cd_deddoc"] = $this->formatIfNull( $entity->getDeddoc()->getOid(), '0' );
		$fieldsValues["cd_facultad"] = $this->formatIfNull( $entity->getFacultad()->getOid(), '0' );
		$fieldsValues["cd_facultadplanilla"] = $this->formatIfNull( $entity->getFacultadplanilla()->getOid(), '0' );
		$fieldsValues["bl_becario"] = $this->formatIfNull( $entity->getBl_becario(), '0' );
		$fieldsValues["bl_unlp"] = $this->formatIfNull( $entity->getBl_unlp(), '0' );
		$fieldsValues["ds_tipobeca"] = $this->formatString( $entity->getDs_tipobeca() );
		$fieldsValues["ds_orgbeca"] = $this->formatString( $entity->getDs_orgbeca() );
		$fieldsValues["ds_periodobeca"] = $this->formatString( $entity->getDs_periodobeca() );
		$fieldsValues["cd_unidadbeca"] = $this->formatIfNull( $entity->getLugarTrabajoBeca()->getOid(), '0' );
		$fieldsValues["bl_carrera"] = $this->formatIfNull( $entity->getBl_carrera(), '0' );
		$fieldsValues["cd_carrerainv"] = $this->formatIfNull( $entity->getCarrerainv()->getOid(), '0' );
		$fieldsValues["cd_organismo"] = $this->formatIfNull( $entity->getOrganismo()->getOid(), '0' );
		$fieldsValues["cd_unidadcarrera"] = $this->formatIfNull( $entity->getLugarTrabajoCarrera()->getOid(), '0' );
		$fieldsValues["dt_ingreso"] = $this->formatDate( $entity->getDt_ingreso() );
		$fieldsValues["cd_categoria"] = $this->formatIfNull( $entity->getCategoria()->getOid(), '0' );
		$fieldsValues["cd_tipoinvestigador"] = $this->formatIfNull( $entity->getTipoinvestigador()->getOid(), '0' );
		$fieldsValues["cd_motivo"] = $this->formatIfNull( $entity->getMotivo()->getOid(), '0' );
		$fieldsValues["ds_objetivo"] = $this->formatString( $entity->getDs_objetivo() );
		$fieldsValues["nu_monto"] = $this->formatString( $entity->getNu_monto() );
		$fieldsValues["ds_curriculum"] = $this->formatString( $entity->getDs_curriculum() );
		$fieldsValues["ds_trabajo"] = $this->formatString( $entity->getDs_trabajo() );
		$fieldsValues["ds_aceptacion"] = $this->formatString( $entity->getDs_aceptacion() );
		$fieldsValues["ds_titulotrabajo"] = $this->formatString( $entity->getDs_titulotrabajo() );
		$fieldsValues["ds_autorestrabajo"] = $this->formatString( $entity->getDs_autorestrabajo() );
		$fieldsValues["ds_congreso"] = $this->formatString( $entity->getDs_congreso() );
		$fieldsValues["ds_lugartrabajo"] = $this->formatString( $entity->getDs_lugartrabajo() );
		$fieldsValues["dt_fechatrabajo"] = $this->formatDate( $entity->getDt_fechatrabajo() );
		$fieldsValues["dt_fechatrabajohasta"] = $this->formatDate( $entity->getDt_fechatrabajohasta() );
		$fieldsValues["ds_resumentrabajo"] = $this->formatString( $entity->getDs_resumentrabajo() );
		$fieldsValues["ds_relevanciatrabajo"] = $this->formatString( $entity->getDs_relevanciatrabajo() );
		$fieldsValues["ds_modalidadtrabajo"] = $this->formatString( $entity->getDs_modalidadtrabajo() );
		$fieldsValues["ds_invitaciongrupo"] = $this->formatString( $entity->getDs_invitaciongrupo() );
		$fieldsValues["ds_aval"] = $this->formatString( $entity->getDs_aval() );
		$fieldsValues["ds_actividades"] = $this->formatString( $entity->getDs_actividades() );
		$fieldsValues["ds_convenio"] = $this->formatString( $entity->getDs_convenio() );
		$fieldsValues["ds_cvprofesor"] = $this->formatString( $entity->getDs_cvprofesor() );
		$fieldsValues["ds_profesor"] = $this->formatString( $entity->getDs_profesor() );
		$fieldsValues["ds_lugarprofesor"] = $this->formatString( $entity->getDs_lugarprofesor() );
		$fieldsValues["nu_puntaje"] = $this->formatString( $entity->getNu_puntaje() );
		$fieldsValues["nu_diferencia"] = $this->formatString( $entity->getNu_diferencia() );
		$fieldsValues["ds_libros"] = $this->formatString( $entity->getDs_libros() );
		$fieldsValues["ds_compilados"] = $this->formatString( $entity->getDs_compilados() );
		$fieldsValues["ds_capitulos"] = $this->formatString( $entity->getDs_capitulos() );
		$fieldsValues["ds_articulos"] = $this->formatString( $entity->getDs_articulos() );
		$fieldsValues["ds_congresos"] = $this->formatString( $entity->getDs_congresos() );
		$fieldsValues["ds_patentes"] = $this->formatString( $entity->getDs_patentes() );
		$fieldsValues["ds_intelectuales"] = $this->formatString( $entity->getDs_intelectuales() );
		$fieldsValues["ds_informes"] = $this->formatString( $entity->getDs_informes() );
		$fieldsValues["bl_congreso"] = $this->formatIfNull( $entity->getBl_congreso(), '0' );
		$fieldsValues["ds_tesis"] = $this->formatString( $entity->getDs_tesis() );
		$fieldsValues["ds_tesinas"] = $this->formatString( $entity->getDs_tesinas() );
		$fieldsValues["bl_nacional"] = $this->formatIfNull( $entity->getBl_nacional(), '0' );
		$fieldsValues["ds_becas"] = $this->formatString( $entity->getDs_becas() );
		$fieldsValues["ds_observaciones"] = $this->formatString( $entity->getDs_observaciones() );
		$fieldsValues["bl_notificacion"] = $this->formatIfNull( $entity->getBl_notificacion(), '0' );
		$fieldsValues["ds_objetivoC"] = $this->formatString( $entity->getDs_objetivoC() );
		$fieldsValues["ds_planC"] = $this->formatString( $entity->getDs_planC() );
		$fieldsValues["ds_relacionProyectoC"] = $this->formatString( $entity->getDs_relacionProyectoC() );
		$fieldsValues["ds_aportesC"] = $this->formatString( $entity->getDs_aportesC() );
		$fieldsValues["ds_actividadesC"] = $this->formatString( $entity->getDs_actividadesC() );
		$fieldsValues["ds_generalB"] = $this->formatString( $entity->getDs_generalB() );
		$fieldsValues["ds_especificoB"] = $this->formatString( $entity->getDs_especificoB() );
		$fieldsValues["ds_actividadesB"] = $this->formatString( $entity->getDs_actividadesB() );
		$fieldsValues["ds_cronogramaB"] = $this->formatString( $entity->getDs_cronogramaB() );
		$fieldsValues["ds_aportesB"] = $this->formatString( $entity->getDs_aportesB() );
		$fieldsValues["ds_justificacionB"] = $this->formatString( $entity->getDs_justificacionB() );
		$fieldsValues["ds_relevanciaB"] = $this->formatString( $entity->getDs_relevanciaB() );
		$fieldsValues["ds_relevanciaA"] = $this->formatString( $entity->getDs_relevanciaA() );
		$fieldsValues["ds_disciplina"] = $this->formatString( $entity->getDs_disciplina() );
        $fieldsValues["ds_linkreunion"] = $this->formatString( $entity->getDs_linkreunion() );
		return $fieldsValues;
		
	}
	
public function getFieldsToUpdate($entity){

		$fieldsValues = array();

		$fieldsValues["cd_docente"] = $this->formatIfNull( $entity->getDocente()->getOid(), 'null' );
		//$fieldsValues["cd_periodo"] = $this->formatIfNull( $entity->getPeriodo()->getOid(), 'null' );
		$fieldsValues["ds_mail"] = $this->formatString( $entity->getDs_mail() );
		$fieldsValues["ds_googleScholar"] = $this->formatString( $entity->getDs_googleScholar() );
		$fieldsValues["nu_telefono"] = $this->formatString( $entity->getNu_telefono() );
		$fieldsValues["dt_fecha"] = $this->formatDate( $entity->getDt_fecha() );
		$fieldsValues["ds_calle"] = $this->formatString( $entity->getDs_calle() );
		$fieldsValues["nu_nro"] = $this->formatString( $entity->getNu_nro() );
		$fieldsValues["nu_piso"] = $this->formatString( $entity->getNu_piso() );
		$fieldsValues["ds_depto"] = $this->formatString( $entity->getDs_depto() );
		$fieldsValues["nu_cp"] = $this->formatString( $entity->getNu_cp() );
		$fieldsValues["ds_titulogrado"] = $this->formatString( $entity->getDs_titulogrado() );
		$fieldsValues["cd_titulogrado"] = $this->formatIfNull( $entity->getTitulo()->getOid(), '0' );
		$fieldsValues["cd_unidad"] = $this->formatIfNull( $entity->getLugarTrabajo()->getOid(), '0' );
		$fieldsValues["cd_cargo"] = $this->formatIfNull( $entity->getCargo()->getOid(), '0' );
		$fieldsValues["cd_deddoc"] = $this->formatIfNull( $entity->getDeddoc()->getOid(), '0' );
		$fieldsValues["cd_facultad"] = $this->formatIfNull( $entity->getFacultad()->getOid(), '0' );
		$fieldsValues["cd_facultadplanilla"] = $this->formatIfNull( $entity->getFacultadplanilla()->getOid(), '0' );
		$fieldsValues["bl_becario"] = $this->formatIfNull( $entity->getBl_becario(), '0' );
		$fieldsValues["bl_unlp"] = $this->formatIfNull( $entity->getBl_unlp(), '0' );
		$fieldsValues["ds_tipobeca"] = $this->formatString( $entity->getDs_tipobeca() );
		$fieldsValues["ds_orgbeca"] = $this->formatString( $entity->getDs_orgbeca() );
		$fieldsValues["ds_periodobeca"] = $this->formatString( $entity->getDs_periodobeca() );
		$fieldsValues["cd_unidadbeca"] = $this->formatIfNull( $entity->getLugarTrabajoBeca()->getOid(), '0' );
		$fieldsValues["bl_carrera"] = $this->formatIfNull( $entity->getBl_carrera(), '0' );
		$fieldsValues["cd_carrerainv"] = $this->formatIfNull( $entity->getCarrerainv()->getOid(), '0' );
		$fieldsValues["cd_organismo"] = $this->formatIfNull( $entity->getOrganismo()->getOid(), '0' );
		$fieldsValues["cd_unidadcarrera"] = $this->formatIfNull( $entity->getLugarTrabajoCarrera()->getOid(), '0' );
		$fieldsValues["dt_ingreso"] = $this->formatDate( $entity->getDt_ingreso() );
		$fieldsValues["cd_categoria"] = $this->formatIfNull( $entity->getCategoria()->getOid(), '0' );
		$fieldsValues["cd_tipoinvestigador"] = $this->formatIfNull( $entity->getTipoinvestigador()->getOid(), '0' );
		$fieldsValues["cd_motivo"] = $this->formatIfNull( $entity->getMotivo()->getOid(), '0' );
		$fieldsValues["ds_objetivo"] = $this->formatString( $entity->getDs_objetivo() );
		$fieldsValues["nu_monto"] = $this->formatString( $entity->getNu_monto() );
		$fieldsValues["ds_curriculum"] = $this->formatString( $entity->getDs_curriculum() );
		$fieldsValues["ds_trabajo"] = $this->formatString( $entity->getDs_trabajo() );
		$fieldsValues["ds_aceptacion"] = $this->formatString( $entity->getDs_aceptacion() );
		$fieldsValues["ds_titulotrabajo"] = $this->formatString( $entity->getDs_titulotrabajo() );
		$fieldsValues["ds_autorestrabajo"] = $this->formatString( $entity->getDs_autorestrabajo() );
		$fieldsValues["ds_congreso"] = $this->formatString( $entity->getDs_congreso() );
		$fieldsValues["ds_lugartrabajo"] = $this->formatString( $entity->getDs_lugartrabajo() );
		$fieldsValues["dt_fechatrabajo"] = $this->formatDate( $entity->getDt_fechatrabajo() );
		$fieldsValues["dt_fechatrabajohasta"] = $this->formatDate( $entity->getDt_fechatrabajohasta() );
		$fieldsValues["ds_resumentrabajo"] = $this->formatString( $entity->getDs_resumentrabajo() );
		$fieldsValues["ds_relevanciatrabajo"] = $this->formatString( $entity->getDs_relevanciatrabajo() );
		$fieldsValues["ds_modalidadtrabajo"] = $this->formatString( $entity->getDs_modalidadtrabajo() );
		$fieldsValues["ds_invitaciongrupo"] = $this->formatString( $entity->getDs_invitaciongrupo() );
		$fieldsValues["ds_aval"] = $this->formatString( $entity->getDs_aval() );
		$fieldsValues["ds_actividades"] = $this->formatString( $entity->getDs_actividades() );
		$fieldsValues["ds_convenio"] = $this->formatString( $entity->getDs_convenio() );
		$fieldsValues["ds_cvprofesor"] = $this->formatString( $entity->getDs_cvprofesor() );
		$fieldsValues["ds_profesor"] = $this->formatString( $entity->getDs_profesor() );
		$fieldsValues["ds_lugarprofesor"] = $this->formatString( $entity->getDs_lugarprofesor() );
		$fieldsValues["nu_puntaje"] = $this->formatString( $entity->getNu_puntaje() );
		$fieldsValues["nu_diferencia"] = $this->formatString( $entity->getNu_diferencia() );
		$fieldsValues["ds_libros"] = $this->formatString( $entity->getDs_libros() );
		$fieldsValues["ds_compilados"] = $this->formatString( $entity->getDs_compilados() );
		$fieldsValues["ds_capitulos"] = $this->formatString( $entity->getDs_capitulos() );
		$fieldsValues["ds_articulos"] = $this->formatString( $entity->getDs_articulos() );
		$fieldsValues["ds_congresos"] = $this->formatString( $entity->getDs_congresos() );
		$fieldsValues["ds_patentes"] = $this->formatString( $entity->getDs_patentes() );
		$fieldsValues["ds_intelectuales"] = $this->formatString( $entity->getDs_intelectuales() );
		$fieldsValues["ds_informes"] = $this->formatString( $entity->getDs_informes() );
		$fieldsValues["bl_congreso"] = $this->formatIfNull( $entity->getBl_congreso(), '0' );
		$fieldsValues["ds_tesis"] = $this->formatString( $entity->getDs_tesis() );
		$fieldsValues["ds_tesinas"] = $this->formatString( $entity->getDs_tesinas() );
		$fieldsValues["bl_nacional"] = $this->formatIfNull( $entity->getBl_nacional(), '0' );
		$fieldsValues["ds_becas"] = $this->formatString( $entity->getDs_becas() );
		$fieldsValues["ds_observaciones"] = $this->formatString( $entity->getDs_observaciones() );
		$fieldsValues["bl_notificacion"] = $this->formatIfNull( $entity->getBl_notificacion(), '0' );
		$fieldsValues["ds_objetivoC"] = $this->formatString( $entity->getDs_objetivoC() );
		$fieldsValues["ds_planC"] = $this->formatString( $entity->getDs_planC() );
		$fieldsValues["ds_relacionProyectoC"] = $this->formatString( $entity->getDs_relacionProyectoC() );
		$fieldsValues["ds_aportesC"] = $this->formatString( $entity->getDs_aportesC() );
		$fieldsValues["ds_actividadesC"] = $this->formatString( $entity->getDs_actividadesC() );
		$fieldsValues["ds_generalB"] = $this->formatString( $entity->getDs_generalB() );
		$fieldsValues["ds_especificoB"] = $this->formatString( $entity->getDs_especificoB() );
		$fieldsValues["ds_actividadesB"] = $this->formatString( $entity->getDs_actividadesB() );
		$fieldsValues["ds_cronogramaB"] = $this->formatString( $entity->getDs_cronogramaB() );
		$fieldsValues["ds_aportesB"] = $this->formatString( $entity->getDs_aportesB() );
		$fieldsValues["ds_justificacionB"] = $this->formatString( $entity->getDs_justificacionB() );
		$fieldsValues["ds_relevanciaB"] = $this->formatString( $entity->getDs_relevanciaB() );
		$fieldsValues["ds_relevanciaA"] = $this->formatString( $entity->getDs_relevanciaA() );
		$fieldsValues["ds_disciplina"] = $this->formatString( $entity->getDs_disciplina() );
        $fieldsValues["ds_linkreunion"] = $this->formatString( $entity->getDs_linkreunion() );

		return $fieldsValues;
	}
	
	
	public function getIdFieldName(){
		return "cd_solicitud";
	}
	
	
	public function getFromToSelect(){
		
		$tSolicitud = $this->getTableName();
		
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		$tPeriodo = CYTSecureDAOFactory::getPeriodoDAO()->getTableName();
		$tMotivo = DAOFactory::getMotivoDAO()->getTableName();
		$tCat = CYTSecureDAOFactory::getCatDAO()->getTableName();
		$tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		$tSolicitudEstado = CYTSecureDAOFactory::getSolicitudEstadoDAO()->getTableName();
		$tLugarTrabajo = CYTSecureDAOFactory::getLugarTrabajoDAO()->getTableName();
		$tCargo = CYTSecureDAOFactory::getCargoDAO()->getTableName();
		$tDeddoc = CYTSecureDAOFactory::getDeddocDAO()->getTableName();
		$tCarrerainv = CYTSecureDAOFactory::getCarrerainvDAO()->getTableName();
		$tOrganismo = CYTSecureDAOFactory::getOrganismoDAO()->getTableName();
		$tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
		$tTipoinvestigador = CYTSecureDAOFactory::getTipoinvestigadorDAO()->getTableName();
		$tTitulo = CYTSecureDAOFactory::getTituloDAO()->getTableName();
		
        $sql  = parent::getFromToSelect();
       
        $sql .= " LEFT JOIN " . $tFacultad . " FacultadPlanilla ON($tSolicitud.cd_facultadplanilla = FacultadPlanilla.cd_facultad)";
        $sql .= " LEFT JOIN " . $tDocente . " ON($tSolicitud.cd_docente = $tDocente.cd_docente)";
        $sql .= " LEFT JOIN " . $tPeriodo . " ON($tSolicitud.cd_periodo = $tPeriodo.cd_periodo)";
        $sql .= " LEFT JOIN " . $tMotivo . " ON($tSolicitud.cd_motivo = $tMotivo.cd_motivo)";
        $sql .= " LEFT JOIN " . $tCat . " ON(FacultadPlanilla.cd_cat = $tCat.cd_cat)";
        $sql .= " LEFT JOIN " . $tSolicitudEstado . " ON($tSolicitudEstado.solicitud_oid = $tSolicitud.cd_solicitud)";
        $sql .= " LEFT JOIN " . $tEstado . " ON($tSolicitudEstado.estado_oid = $tEstado.cd_estado)";
        $sql .= " LEFT JOIN " . $tLugarTrabajo . " ON($tSolicitud.cd_unidad = $tLugarTrabajo.cd_unidad)";
        $sql .= " LEFT JOIN " . $tCargo . " ON($tSolicitud.cd_cargo = $tCargo.cd_cargo)";
        $sql .= " LEFT JOIN " . $tDeddoc . " ON($tSolicitud.cd_deddoc = $tDeddoc.cd_deddoc)";
        $sql .= " LEFT JOIN " . $tFacultad . " ON($tSolicitud.cd_facultad = $tFacultad.cd_facultad)";
        $sql .= " LEFT JOIN " . $tLugarTrabajo . " LugarTrabajoBeca ON($tSolicitud.cd_unidadbeca = LugarTrabajoBeca.cd_unidad)";
       	$sql .= " LEFT JOIN " . $tLugarTrabajo . " LugarTrabajoCarrera ON($tSolicitud.cd_unidadcarrera = LugarTrabajoCarrera.cd_unidad)";
       	$sql .= " LEFT JOIN " . $tOrganismo . " ON($tSolicitud.cd_organismo = $tOrganismo.cd_organismo)";
       	$sql .= " LEFT JOIN " . $tCarrerainv . " ON($tSolicitud.cd_carrerainv = $tCarrerainv.cd_carrerainv)";
       	$sql .= " LEFT JOIN " . $tCategoria . " ON($tSolicitud.cd_categoria = $tCategoria.cd_categoria)";
        $sql .= " LEFT JOIN " . $tTipoinvestigador . " ON($tSolicitud.cd_tipoinvestigador = $tTipoinvestigador.cd_tipoinvestigador)";
        $sql .= " LEFT JOIN " . $tTitulo . " ON($tSolicitud.cd_titulogrado = $tTitulo.cd_titulo)";
        
        return $sql;
	}
	
	public function getFieldsToSelect(){
		
		
		$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
		$tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
		$tFacultadPlanilla = 'FacultadPlanilla';
		$tPeriodo = CYTSecureDAOFactory::getPeriodoDAO()->getTableName();
		$tMotivo = DAOFactory::getMotivoDAO()->getTableName();
		$tCat = CYTSecureDAOFactory::getCatDAO()->getTableName();
		
		
		$fields = parent::getFieldsToSelect();
        
        $fields[] = "$tDocente.cd_docente as " . $tDocente . "_oid ";
        $fields[] = "$tDocente.ds_nombre as " . $tDocente . "_ds_nombre ";
        $fields[] = "$tDocente.ds_apellido as " . $tDocente . "_ds_apellido ";
        $fields[] = "$tDocente.nu_documento as " . $tDocente . "_nu_documento ";
        $fields[] = "$tDocente.nu_precuil as " . $tDocente . "_nu_precuil ";
        $fields[] = "$tDocente.nu_postcuil as " . $tDocente . "_nu_postcuil ";
                
        $fields[] = "$tFacultad.cd_facultad as " . $tFacultad . "_oid ";
        $fields[] = "$tFacultad.ds_facultad as " . $tFacultad . "_ds_facultad ";
        
        $fields[] = "$tFacultadPlanilla.cd_facultad as " . $tFacultadPlanilla . "_oid ";
        $fields[] = "$tFacultadPlanilla.ds_facultad as " . $tFacultadPlanilla . "_ds_facultad ";
        
        $fields[] = "$tPeriodo.cd_periodo as " . $tPeriodo . "_oid ";
        $fields[] = "$tPeriodo.ds_periodo as " . $tPeriodo . "_ds_periodo ";
        
        $fields[] = "$tMotivo.cd_motivo as " . $tMotivo . "_oid ";
        $fields[] = "$tMotivo.ds_motivo as " . $tMotivo . "_ds_motivo ";
        $fields[] = "$tMotivo.ds_letra as " . $tMotivo . "_ds_letra ";
        
        $fields[] = "$tCat.cd_cat as " . $tCat . "_oid ";
        $fields[] = "$tCat.ds_cat as " . $tCat . "_ds_cat ";
        
        $tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
		$fields[] = "$tEstado.cd_estado as " . $tEstado . "_oid ";
        $fields[] = "$tEstado.ds_estado as " . $tEstado . "_ds_estado ";
        
        $tSolicitudEstado = CYTSecureDAOFactory::getSolicitudEstadoDAO()->getTableName();
		$fields[] = "$tSolicitudEstado.oid as " . $tSolicitudEstado . "_oid ";
        $fields[] = "$tSolicitudEstado.fechaDesde as " . $tSolicitudEstado . "_fechaDesde ";
        $fields[] = "$tSolicitudEstado.fechaHasta as " . $tSolicitudEstado . "_fechaHasta ";
        
        $tLugarTrabajo = CYTSecureDAOFactory::getLugarTrabajoDAO()->getTableName();
        $fields[] = "$tLugarTrabajo.cd_unidad as " . $tLugarTrabajo . "_oid ";
        $fields[] = "$tLugarTrabajo.ds_unidad as " . $tLugarTrabajo . "_ds_unidad ";
        $fields[] = "$tLugarTrabajo.ds_sigla as " . $tLugarTrabajo . "_ds_sigla ";
        
        $tCargo = CYTSecureDAOFactory::getCargoDAO()->getTableName();
        $fields[] = "$tCargo.cd_cargo as " . $tCargo . "_oid ";
        $fields[] = "$tCargo.ds_cargo as " . $tCargo . "_ds_cargo ";
        
        $tDeddoc = CYTSecureDAOFactory::getDeddocDAO()->getTableName();
        $fields[] = "$tDeddoc.cd_deddoc as " . $tDeddoc . "_oid ";
        $fields[] = "$tDeddoc.ds_deddoc as " . $tDeddoc . "_ds_deddoc ";
        
        $tFacultad = CYTSecureDAOFactory::getFacultadDAO()->getTableName();
        $fields[] = "$tFacultad.cd_facultad as " . $tFacultad . "_oid ";
        $fields[] = "$tFacultad.ds_facultad as " . $tFacultad . "_ds_facultad ";
        
        
        $fields[] = "LugarTrabajoBeca.cd_unidad as " . LugarTrabajoBeca . "_oid ";
        $fields[] = "LugarTrabajoBeca.ds_unidad as " . LugarTrabajoBeca . "_ds_unidad ";
        $fields[] = "LugarTrabajoBeca.ds_sigla as " . LugarTrabajoBeca . "_ds_sigla ";
        
        $fields[] = "LugarTrabajoCarrera.cd_unidad as " . LugarTrabajoCarrera . "_oid ";
        $fields[] = "LugarTrabajoCarrera.ds_unidad as " . LugarTrabajoCarrera . "_ds_unidad ";
        $fields[] = "LugarTrabajoCarrera.ds_sigla as " . LugarTrabajoCarrera . "_ds_sigla ";
        
        $tCarrerainv = CYTSecureDAOFactory::getCarrerainvDAO()->getTableName();
        $fields[] = "$tCarrerainv.cd_carrerainv as " . $tCarrerainv . "_oid ";
        $fields[] = "$tCarrerainv.ds_carrerainv as " . $tCarrerainv . "_ds_carrerainv ";
        
        $tOrganismo = CYTSecureDAOFactory::getOrganismoDAO()->getTableName();
        $fields[] = "$tOrganismo.cd_organismo as " . $tOrganismo . "_oid ";
        $fields[] = "$tOrganismo.ds_organismo as " . $tOrganismo . "_ds_organismo ";
        
        $tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
        $fields[] = "$tCategoria.cd_categoria as " . $tCategoria . "_oid ";
        $fields[] = "$tCategoria.ds_categoria as " . $tCategoria . "_ds_categoria ";
        
        $tTipoinvestigador = CYTSecureDAOFactory::getTipoinvestigadorDAO()->getTableName();
        $fields[] = "$tTipoinvestigador.cd_tipoinvestigador as " . $tTipoinvestigador . "_oid ";
        $fields[] = "$tTipoinvestigador.ds_tipoinvestigador as " . $tTipoinvestigador . "_ds_tipoinvestigador ";
        
        $tTitulo = CYTSecureDAOFactory::getTituloDAO()->getTableName();
        $fields[] = "$tTitulo.cd_titulo as " . $tTitulo . "_oid ";
        $fields[] = "$tTitulo.ds_titulo as " . $tTitulo . "_ds_titulo ";
        
        return $fields;
	}
	
	

	
	
}
?>