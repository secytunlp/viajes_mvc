<?php

/**
 * Acción para exportar a pdf una solicitud.
 *
 * @author Marcos
 * @since 19-11-203
 *
 */
class ViewSolicitudPDFAction extends CdtAction{

	
	/**
	 * (non-PHPdoc)
	 * @see CdtAction::execute()
	 */
	public function execute(){

		//armamos el pdf con la data necesaria.
		$pdf = new ViewSolicitudPDF();
		
		
		
		$oid = CdtUtils::getParam('id');
		
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oid);
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $oSolicitud->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerSolicitudEstado =  CYTSecureManagerFactory::getSolicitudEstadoManager();
		$oSolicitudEstado = $managerSolicitudEstado->getEntity($oCriteria);
		$pdf->setEstado_oid($oSolicitudEstado->getEstado()->getOid());
		$pdf->setPeriodo_oid($oSolicitud->getPeriodo()->getOid());
		$pdf->setMotivo_oid($oSolicitud->getMotivo()->getOid());
		$pdf->setCategoria_oid($oSolicitud->getCategoria()->getOid());
		
		$oPeriodoManager =  CYTSecureManagerFactory::getPeriodoManager();
		$oPeriodo = $oPeriodoManager->getObjectByCode($oSolicitud->getPeriodo()->getOid());
		$pdf->setYear($oPeriodo->getDs_periodo());
		
		$oPeriodoActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
		
		$oUser = CdtSecureUtils::getUserLogged();
		/*if ((!CdtSecureUtils::hasPermission ( $oUser, CYT_FUNCTION_VER_ANTERIORES ))&&($oPeriodo->getOid()!=$oPeriodoActual->getOid())) {
			throw new GenericException( CYT_MSG_SOLICITUD_ANTERIORES_PROHIBIDO );
		}*/
		
		
		$pdf->setDs_investigador($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre());
		$pdf->setNu_cuil($oSolicitud->getDocente()->getNu_precuil().'-'.$oSolicitud->getDocente()->getNu_documento().'-'.$oSolicitud->getDocente()->getNu_postcuil());
		
		$pdf->setDs_calle($oSolicitud->getDs_calle());
		$pdf->setNu_nro($oSolicitud->getNu_nro());
		$pdf->setDs_depto($oSolicitud->getDs_depto());
		$pdf->setNu_piso($oSolicitud->getNu_piso());
		$pdf->setNu_cp($oSolicitud->getNu_cp());
		$pdf->setDs_mail($oSolicitud->getDs_mail());
		$pdf->setDs_googleScholar($oSolicitud->getDs_googleScholar());
		$pdf->setNu_telefono($oSolicitud->getNu_telefono());
		$pdf->setBl_notificacion($oSolicitud->getBl_notificacion());
		$pdf->setDs_titulogrado($oSolicitud->getDs_titulogrado());
		$ds_sigla = ($oSolicitud->getLugarTrabajo()->getDs_sigla())?" (".$oSolicitud->getLugarTrabajo()->getDs_sigla().")":"";
		$pdf->setDs_lugarTrabajo($oSolicitud->getLugarTrabajo()->getDs_unidad().$ds_sigla);
		
		$oLugarTrabajoManager =  CYTSecureManagerFactory::getLugarTrabajoManager();
		$oLugarTrabajo = $oLugarTrabajoManager->getObjectByCode($oSolicitud->getLugarTrabajo()->getOid());
		if (!empty($oLugarTrabajo)) {
			$pdf->setDs_lugarTrabajoDireccion($oLugarTrabajo->getDs_direccion());
			$pdf->setDs_lugarTrabajoTelefono($oLugarTrabajo->getDs_telefono());
		}
		
		
		$pdf->setDs_cargo($oSolicitud->getCargo()->getDs_cargo());
		$pdf->setDs_deddoc($oSolicitud->getDeddoc()->getDs_deddoc());
		$pdf->setDs_facultad($oSolicitud->getFacultad()->getDs_facultad());
		
		$pdf->setBl_becario($oSolicitud->getBl_becario());
		$pdf->setDs_orgbeca($oSolicitud->getDs_orgbeca());
		$pdf->setDs_tipobeca($oSolicitud->getDs_tipobeca());
		$pdf->setDs_periodobeca($oSolicitud->getDs_periodobeca());
		$ds_sigla = ($oSolicitud->getLugarTrabajoBeca()->getDs_sigla())?" (".$oSolicitud->getLugarTrabajoBeca()->getDs_sigla().")":"";
		$pdf->setDs_lugarTrabajoBeca($oSolicitud->getLugarTrabajoBeca()->getDs_unidad().$ds_sigla);
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_docente', $oSolicitud->getDocente()->getOid(), '=');
		$oCriteria->addFilter('dt_hasta', CYT_FECHA_CIERRE, '>', new CdtCriteriaFormatStringValue());
		$oBecaManager =  CYTSecureManagerFactory::getBecaManager();
		$oBeca = $oBecaManager->getEntity($oCriteria);
		if (!empty($oBeca)) {
			$pdf->setDs_resumenbeca($oBeca->getDs_resumen());
		}
		
		$pdf->setBl_carrera($oSolicitud->getBl_carrera());
		$pdf->setDs_organismo($oSolicitud->getOrganismo()->getDs_organismo());
		$pdf->setDs_carrerainv($oSolicitud->getCarrerainv()->getDs_carrerainv());
		$pdf->setDt_ingreso(CYTSecureUtils::formatDateToView($oSolicitud->getDt_ingreso()));
		$ds_sigla = ($oSolicitud->getLugarTrabajoCarrera()->getDs_sigla())?" (".$oSolicitud->getLugarTrabajoCarrera()->getDs_sigla().")":"";
		$pdf->setDs_lugarTrabajoCarrera($oSolicitud->getLugarTrabajoCarrera()->getDs_unidad().$ds_sigla);
		
		$pdf->setDs_categoria($oSolicitud->getCategoria()->getDs_categoria());
		$pdf->setDs_tipoInvestigador($oSolicitud->getTipoInvestigador()->getDs_tipoinvestigador());
		
		//proyectos.
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $oSolicitud->getOid(), '=');
		$oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
		$oCriteria->addFilter('bl_seleccionado', 1, '=');
		$proyectosManager = new SolicitudProyectoManager();
		$pdf->setProyectos( $proyectosManager->getEntities($oCriteria) );
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $oSolicitud->getOid(), '=');
		$oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
		$oCriteria->addFilter('bl_seleccionado', 1, '<>');
		$proyectosManager = new SolicitudProyectoManager();
		$pdf->setProyectosNoSeleccionados( $proyectosManager->getEntities($oCriteria) );
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
		
		$ambitosManager = new AmbitoManager();
		$pdf->setAmbitos( $ambitosManager->getEntities($oCriteria) );
		
		$pdf->setDs_objetivo($oSolicitud->getDs_objetivo());
		
		$pdf->setNu_monto($oSolicitud->getNu_monto());
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
		
		$montosManager = new MontoManager();
		$pdf->setMontosOrganismos( $montosManager->getEntities($oCriteria) );
		
		$pdf->setDs_motivo($oSolicitud->getMotivo()->getDs_motivo());
		
		$pdf->setBl_congreso($oSolicitud->getBl_congreso());
		$pdf->setDs_titulotrabajo($oSolicitud->getDs_titulotrabajo());
		$pdf->setDs_autorestrabajo($oSolicitud->getDs_autorestrabajo());
		$pdf->setDs_congreso($oSolicitud->getDs_congreso());
        $pdf->setDs_linkreunion($oSolicitud->getDs_linkreunion());
		$pdf->setDs_lugardeltrabajo($oSolicitud->getDs_lugartrabajo());
		$pdf->setDt_fechatrabajo($oSolicitud->getDt_fechatrabajo());
		$pdf->setDt_fechatrabajohasta($oSolicitud->getDt_fechatrabajohasta());
		$pdf->setDs_resumentrabajo($oSolicitud->getDs_resumentrabajo());
		$pdf->setDs_relevanciatrabajo($oSolicitud->getDs_relevanciatrabajo());
		$pdf->setDs_modalidadtrabajo($oSolicitud->getDs_modalidadtrabajo());
		$pdf->setBl_nacional($oSolicitud->getBl_nacional());
		$pdf->setDs_profesor($oSolicitud->getDs_profesor());
		$pdf->setDs_lugarprofesor($oSolicitud->getDs_lugarprofesor());
		
		$pdf->setDs_libros($oSolicitud->getDs_libros());
		  $pdf->setDs_compilados($oSolicitud->getDs_compilados());
		  $pdf->setDs_capitulos($oSolicitud->getDs_capitulos());
		  $pdf->setDs_articulos($oSolicitud->getDs_articulos());
		  $pdf->setDs_congresos($oSolicitud->getDs_congresos());
		  $pdf->setDs_patentes($oSolicitud->getDs_patentes());
		  $pdf->setDs_intelectuales($oSolicitud->getDs_intelectuales());
		  $pdf->setDs_informes($oSolicitud->getDs_informes());
		  
		  $pdf->setDs_tesis($oSolicitud->getDs_tesis());
		  $pdf->setDs_tesinas($oSolicitud->getDs_tesinas());
		  $pdf->setDs_becas($oSolicitud->getDs_becas());
		  
		  $pdf->setDs_objetivoC($oSolicitud->getDs_objetivoC());
	  		$pdf->setDs_planC($oSolicitud->getDs_planC());
	  		$pdf->setDs_relacionProyectoC($oSolicitud->getDs_relacionProyectoC());
			$pdf->setDs_aportesC($oSolicitud->getDs_aportesC());
			$pdf->setDs_actividadesC($oSolicitud->getDs_actividadesC());
			$pdf->setDs_generalB($oSolicitud->getDs_generalB());
			$pdf->setDs_especificoB($oSolicitud->getDs_especificoB());
			$pdf->setDs_actividadesB($oSolicitud->getDs_actividadesB());
			$pdf->setDs_cronogramaB($oSolicitud->getDs_cronogramaB());
			$pdf->setDs_justificacionB($oSolicitud->getDs_justificacionB());
			$pdf->setDs_aportesB($oSolicitud->getDs_aportesB());
			$pdf->setDs_relevanciaB($oSolicitud->getDs_relevanciaB());
			$pdf->setDs_relevanciaA($oSolicitud->getDs_relevanciaA());
		
		
		$pdf->setFacultadplanilla_oid($oSolicitud->getFacultadplanilla()->getOid());
		
		
	
    	($oSolicitud->getFacultadplanilla()->getOid() != CYT_FACULTAD_NO_DECLARADA)?$pdf->setDs_facultadplanilla($oSolicitud->getFacultadplanilla()->getDs_facultad()):$pdf->setDs_facultadplanilla(CYT_MSG_SOLICITUD_UNIVERSIDAD);;
		
    	$presupuestosManager = new PresupuestoManager();
		$pdf->setPresupuestos( $presupuestosManager->getEntities($oCriteria) );
    	
		$pdf->title = CYT_MSG_SOLICITUD_PDF_TITLE;
		$pdf->SetFont('Arial','', 13);
		
		// establecemos los márgenes
		$pdf->SetMargins(10, 20 , 10);
		$pdf->setMaxWidth($pdf->w - $pdf->lMargin - $pdf->rMargin);
		//$pdf->SetAutoPageBreak(true,90);
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		//imprimimos la solicitud.
		$pdf->printSolicitud();
		
		$pdf->Output();

		//para que no haga el forward.
		$forward = null;

		return $forward;
	}


}