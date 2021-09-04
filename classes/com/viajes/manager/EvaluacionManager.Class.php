<?php

/**
 * Manager para Evaluacion
 *  
 * @author Marcos
 * @since 17-11-2013
 */
class EvaluacionManager extends EntityManager{

	public function getDAO(){
		return CYTSecureDAOFactory::getEvaluacionDAO();
	}

	public function add(Entity $entity) {
    	
		parent::add($entity);
		
    }	
    
     public function update(Entity $entity) {
     	
     	parent::update($entity);
     	
     	$puntajePlanDAO =  DAOFactory::getPuntajePlanDAO();
        $puntajePlanDAO->deletePuntajePlanPorEvaluacion($entity->getOid());
        
     	$oPuntajePlan = new PuntajePlan();
     	$oPuntajePlan->setEvaluacion($entity);
     	
     	$oModeloPlanilla = new ModeloPlanilla();
		$oModeloPlanilla->setOid($entity->getModeloplanilla_oid());
     	$oPuntajePlan->setModeloPlanilla($oModeloPlanilla);
     	
     	$oPuntajePlan->setNu_puntaje($entity->getNu_puntajePlan());
     	$oPuntajePlan->setDs_justificacion($entity->getDs_justificacionplan());
     	
     	//CYTSecureUtils::logObject($oPuntajePlan);
     	
     	$managerPuntajePlan = ManagerFactory::getPuntajePlanManager();
		$managerPuntajePlan->add($oPuntajePlan);	
		
		$puntajeCategoriaDAO =  DAOFactory::getPuntajeCategoriaDAO();
        $puntajeCategoriaDAO->deletePuntajeCategoriaPorEvaluacion($entity->getOid());
		
     	$oPuntajeCategoria = new PuntajeCategoria();
     	$oPuntajeCategoria->setEvaluacion($entity);
		$oPuntajeCategoria->setModeloPlanilla($oModeloPlanilla);
     	
     	$cd_categoria = explode('-',trim($entity->getCategoria_oid()));
     	
     	if ($cd_categoria) {
     		$oCategoriaMaximo = new CategoriaMaximo();
	     	$oCategoriaMaximo->setOid($cd_categoria[0]);
	     	
	     	$oPuntajeCategoria->setCategoriaMaximo($oCategoriaMaximo);
	     	
	     	$managerPuntajeCategoria = ManagerFactory::getPuntajeCategoriaManager();
			$managerPuntajeCategoria->add($oPuntajeCategoria);
     	}
		
     	$puntajeCargoDAO =  DAOFactory::getPuntajeCargoDAO();
        $puntajeCargoDAO->deletePuntajeCargoPorEvaluacion($entity->getOid());
     	
     	$oPuntajeCargo = new PuntajeCargo();
     	$oPuntajeCargo->setEvaluacion($entity);
		$oPuntajeCargo->setModeloPlanilla($oModeloPlanilla);
     	
     	$cd_cargomaximo = explode('-',trim($entity->getCargo_oid()));
     	
     	if ($cd_cargomaximo) {
     		$oCargoMaximo = new CargoMaximo();
	     	$oCargoMaximo->setOid($cd_cargomaximo[0]);
	     	
	     	$oPuntajeCargo->setCargoMaximo($oCargoMaximo);
	     	
	     	$managerPuntajeCargo = ManagerFactory::getPuntajeCargoManager();
			$managerPuntajeCargo->add($oPuntajeCargo);
     	}
     	
     	$puntajeItemDAO =  DAOFactory::getPuntajeItemDAO();
        $puntajeItemDAO->deletePuntajeItemPorEvaluacion($entity->getOid());
     	
    	foreach ($entity->getItems() as $item) {
    		$arrayItem = explode('-',trim($item));
    		$oPuntajeItem = new PuntajeItem();
	     	$oPuntajeItem->setEvaluacion($entity);
			$oPuntajeItem->setModeloPlanilla($oModeloPlanilla);
    		$oItemMaximo = new ItemMaximo();
	     	$oItemMaximo->setOid($arrayItem[0]);
	     	
	     	$oPuntajeItem->setItemMaximo($oItemMaximo);
	     	$oPuntajeItem->setNu_cantidad($arrayItem[1]);
	     	$oPuntajeItem->setNu_puntaje($arrayItem[2]);
	     	
	     	$managerPuntajeItem = ManagerFactory::getPuntajeItemManager();
			$managerPuntajeItem->add($oPuntajeItem);
    	}
    	
     	$puntajeEventoDAO =  DAOFactory::getPuntajeEventoDAO();
        $puntajeEventoDAO->deletePuntajeEventoPorEvaluacion($entity->getOid());
     	
    	foreach ($entity->getEventos() as $evento) {
    		$arrayEvento = explode('#/#',trim($evento));
    		$oPuntajeEvento = new PuntajeEvento();
	     	$oPuntajeEvento->setEvaluacion($entity);
			$oPuntajeEvento->setModeloPlanilla($oModeloPlanilla);
    		$oEventoMaximo = new EventoMaximo();
	     	$oEventoMaximo->setOid($arrayEvento[0]);
	     	
	     	$oPuntajeEvento->setEventoMaximo($oEventoMaximo);
	     	$oPuntajeEvento->setNu_puntaje($arrayEvento[1]);
	     	$oPuntajeEvento->setDs_justificacion($arrayEvento[2]);
	     	
	     	$managerPuntajeEvento = ManagerFactory::getPuntajeEventoManager();
			$managerPuntajeEvento->add($oPuntajeEvento);
    	}
     	
     }

    
    
    
	/**
     * se elimina la entity
     * @param int identificador de la entity a eliminar.
     */
    public function delete($id) {
        
		parent::delete( $id );
		
    	
    }
    
    
	public function sendSolicitud(Entity $entity) {
	//	$this->validateOnSend($entity);
		//armamos el pdf con la data necesaria.
		//$pdf = new ViewSolicitudPDF();
		
		
		
		$oid = $entity->getSolicitud()->getOid();
		
		
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oid);
		
		
		
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_SOLICITUD_EN_EVALUACION);
		
		
		//$this->cambiarEstado($entity, $oEstado, '');
		$oSolicitudManager->cambiarEstado($oSolicitud, $oEstado, '');
		
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_SOLICITUD_RECIBIDA);//Se pasa a evaluacion recibida para que el evaluador la acepte o no
		$this->cambiarEstado($entity, $oEstado, '');
		
		/*$pdf->setEstado_oid(CYT_ESTADO_SOLICITUD_RECIBIDA);
		$pdf->setPeriodo_oid($oSolicitud->getPeriodo()->getOid());
		
		$pdf->setMotivo_oid($oSolicitud->getMotivo()->getOid());
		$pdf->setCategoria_oid($oSolicitud->getCategoria()->getOid());*/
		
		$oPeriodoManager =  CYTSecureManagerFactory::getPeriodoManager();
		$oPeriodo = $oPeriodoManager->getObjectByCode($oSolicitud->getPeriodo()->getOid());
		/*$pdf->setYear($oPeriodo->getDs_periodo());
				
		$pdf->setDs_investigador($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre());
		$pdf->setNu_cuil($oSolicitud->getDocente()->getNu_precuil().'-'.$oSolicitud->getDocente()->getNu_documento().'-'.$oSolicitud->getDocente()->getNu_postcuil());
		
		$pdf->setDs_calle($oSolicitud->getDs_calle());
		$pdf->setNu_nro($oSolicitud->getNu_nro());
		$pdf->setDs_depto($oSolicitud->getDs_depto());
		$pdf->setNu_piso($oSolicitud->getNu_piso());
		$pdf->setNu_cp($oSolicitud->getNu_cp());
		$pdf->setDs_mail($oSolicitud->getDs_mail());
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
			$pdf->setDs_aportesB($oSolicitud->getDs_aportesB());
			$pdf->setDs_relevanciaB($oSolicitud->getDs_relevanciaB());
		
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
		
		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= CYT_PERIODO_YEAR.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dirDoc = $dir.$oSolicitud->getDocente()->getNu_documento().'/';
		if (!file_exists($dirDoc)) mkdir($dirDoc, 0777);
		
		
		
		$fileName = $dirDoc.CYT_MSG_SOLICITUD_ARCHIVO_NOMBRE.CYTSecureUtils::stripAccents($oSolicitud->getDocente()->getDs_apellido()).'.pdf';;
		$pdf->Output($fileName,'F');
        //$pdf->Output(); 	
	        
		$attachs = array();
		$handle=opendir($dirDoc);
		while ($archivo = readdir($handle))
		{
	        if (is_file($dirDoc.$archivo))
	        if ((is_file($dirDoc.$archivo))&&(!strchr($archivo,CYT_MSG_EVALUACION_ARCHIVO_NOMBRE)))
	         {
	         	$attachs[]=$dirDoc.$archivo;
	         }
		}
		
		$dirDoc = $dir.str_pad($oSolicitud->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);
		if (!file_exists($dirDoc)) mkdir($dirDoc, 0777);
		$handle=opendir($dirDoc);
		while ($archivo = readdir($handle))
		{
	        if (is_file($dirDoc.$archivo))
	        if ((is_file($dirDoc.$archivo))&&(!strchr($archivo,CYT_MSG_EVALUACION_ARCHIVO_NOMBRE)))
	         {
	         	$attachs[]=$dirDoc.$archivo;
	         }
		}*/
        
		
		$year = $oPeriodo->getDs_periodo();
		$yearP = $year+1;
    	$params = array ($year,$yearP );		
		
		$subjectMail = htmlspecialchars(CdtFormatUtils::formatMessage( CYT_LBL_EVALUACION_MAIL_SUBJECT, $params ), ENT_QUOTES, "UTF-8");	
		
		$managerUser = CYTSecureManagerFactory::getUserManager();
		$oUsuario = $managerUser->getObjectByCode($entity->getUser()->getOid());
	
		if ($oUsuario->getDs_email() != "") {
				$ds_name = ($oUsuario->getDs_name())?$oUsuario->getDs_name():$oUsuario->getDs_username();
         		
         		
        }
		$tipoEvaluador = ($entity->getBl_interno())?'INTERNO':'EXTERNO';
		$xtpl = new XTemplate( CYT_TEMPLATE_EVALUACION_MAIL_ENVIAR );
		$xtpl->assign ( 'img_logo', WEB_PATH.'css/images/image002.gif' );
		$xtpl->assign('solicitud_titulo', $subjectMail);
		$xtpl->assign('solicitud_descripcion', htmlspecialchars(CdtFormatUtils::formatMessage( CYT_LBL_SOLICITUD_MAIL_SUBJECT, $params ), ENT_QUOTES, "UTF-8"));
		$xtpl->assign('dt_fecha', date('d/m/Y'));
		$xtpl->assign('ds_tipoevaluador', $tipoEvaluador);
		$xtpl->assign('ds_evaluador', $ds_name);
		$xtpl->assign('urlWeb', WEB_PATH);
		$xtpl->assign('ds_postulante', htmlspecialchars($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre(), ENT_QUOTES, "UTF-8"));
		$xtpl->assign('urlInstructivo', 'http://secyt.presi.unlp.edu.ar/varios/Manual_Viajes_Evaluador.pdf');
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('userGroup_oid', CYT_CD_GROUP_COORDINADOR, '=');
				
		$managerUserGroup = CYTSecureManagerFactory::getUserUserGroupManager();
		$oCoordinadores = $managerUserGroup->getEntities($oCriteria);
		$ds_coordinadores='';
		foreach ($oCoordinadores as $oCoordinador) {
			$oUsuarioCoordinador = $managerUser->getObjectByCode($oCoordinador->getUser()->getOid());
		
			$ds_name1 = ($oUsuarioCoordinador->getDs_name())?$oUsuarioCoordinador->getDs_name():$oUsuarioCoordinador->getDs_username();
	         		
			if ($oUsuarioCoordinador->getFacultad()->getOid() != "") {
	        	$managerFacultad = CYTSecureManagerFactory::getFacultadManager();
				$oFacultad = $managerFacultad->getObjectByCode($oUsuarioCoordinador->getFacultad()->getOid());
				if ($oFacultad->getCat()->getOid()==$oSolicitud->getCat()->getOid()) {
					$ds_coordinadores .=$ds_name1. ' ('.$oFacultad->getDs_facultad().') '.$oUsuarioCoordinador->getDs_email().'<br><br>';
				}
	        } 		
	        //$ds_coordinadores .=$ds_name1. ' ('.$oFacultad->getDs_facultad().') '.$oUsuarioCoordinador->getDs_email().'<br><br>';
		}
		
		$xtpl->assign('ds_coordinadores', $ds_coordinadores);
		
		$xtpl->parse('main');		
		$bodyMail = $xtpl->text('main');
		
		
		/*$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('oid', $entity->getUser()->getOid(), '=');
				
		$managerUser = CYTSecureManagerFactory::getUserManager();
		$oUsuario = $managerUser->getEntity($oCriteria);*/
		
		 
       if ($oUsuario->getDs_email() != "") {
				//$ds_name = ($oUsuario->getDs_name())?$oUsuario->getDs_name():$oUsuario->getDs_username();
         		CYTSecureUtils::sendMail($ds_name, $oUsuario->getDs_email(), $subjectMail, $bodyMail, $attachs);
         		
        }
       // CYTSecureUtils::sendMail(CDT_POP_MAIL_FROM_NAME, CDT_POP_MAIL_FROM, $subjectMail, $bodyMail, $attachs);
	}
	
	public function send(Entity $entity) {
		//CdtUtils::log('entra');
		$this->validateOnSend($entity);
		//armamos el pdf con la data necesaria.
		$pdf = new ViewEvaluacionPDF();
		
		$oUser = CdtSecureUtils::getUserLogged();
		
		//$pdf->setSolicitud_oid($entity->getSolicitud()->getOid());
		
		$pdf->setEvaluacion_oid($entity->getOid());
		
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_SOLICITUD_EVALUADA);
		$this->cambiarEstado($entity, $oEstado, '');
		
		$pdf->setEstado_oid(CYT_ESTADO_SOLICITUD_EVALUADA);
		
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($entity->getSolicitud()->getOid());
		
		$pdf->setPeriodo_oid($oSolicitud->getPeriodo()->getOid());
		$oPeriodoManager =  CYTSecureManagerFactory::getPeriodoManager();
		$oPeriodo = $oPeriodoManager->getObjectByCode($oSolicitud->getPeriodo()->getOid());
		$pdf->setYear($oPeriodo->getDs_periodo());
		
		$oPeriodoActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
		
		$oUser = CdtSecureUtils::getUserLogged();
		if ((!CdtSecureUtils::hasPermission ( $oUser, CYT_FUNCTION_VER_ANTERIORES ))&&($oPeriodo->getOid()!=$oPeriodoActual->getOid())) {
			throw new GenericException( CYT_MSG_EVALUACION_ANTERIORES_PROHIBIDO );
		}
		
		$pdf->setMotivo_oid($oSolicitud->getMotivo()->getOid());
		$oModeloPlanillaManager =  ManagerFactory::getModeloPlanillaManager();
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_motivo', $oSolicitud->getMotivo()->getOid(), '=');
		$oCriteria->addFilter('cd_periodo', $oSolicitud->getPeriodo()->getOid(), '=');
		$oCriteria->addFilter('cd_tipoinvestigador', $oSolicitud->getTipoInvestigador()->getOid(), '=');
		$oModeloPlanilla = $oModeloPlanillaManager->getEntity($oCriteria);
		$pdf->setModeloPlanilla($oModeloPlanilla);
		
		
		$pdf->setDs_motivo($oModeloPlanilla->getDs_motivo());
		
		
		
		$pdf->setDs_investigador($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre());
		
		
		
		$pdf->setFacultadplanilla_oid($oSolicitud->getFacultadplanilla()->getOid());
		
		
	
    	($oSolicitud->getFacultadplanilla()->getOid() != CYT_FACULTAD_NO_DECLARADA)?$pdf->setDs_facultadplanilla($oSolicitud->getFacultadplanilla()->getDs_facultad()):$pdf->setDs_facultadplanilla(CYT_MSG_SOLICITUD_UNIVERSIDAD);;
		
    	$pdf->setObservacion($entity->getDs_observacion());
    	
    	$pdf->setDs_evaluador($entity->getUser()->getDs_username());
    	
    	
		$pdf->title = CYT_MSG_EVALUACION_PDF_TITLE;
		$pdf->SetFont('Arial','', 13);
		
		// establecemos los márgenes
		$pdf->SetMargins(10, 20 , 10);
		$pdf->setMaxWidth($pdf->w - $pdf->lMargin - $pdf->rMargin);
		//$pdf->SetAutoPageBreak(true,90);
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		//imprimimos la solicitud.
		$pdf->printEvaluacion();
		
		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= CYT_PERIODO_YEAR.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oSolicitud->getDocente()->getNu_documento().'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		
		$ds_apellido = stripslashes(str_replace("'","_",$oSolicitud->getDocente()->getDs_apellido()));
		$ds_apellido = stripslashes(str_replace(" ","_",$ds_apellido));
		$ds_evaluador = stripslashes(str_replace("'","_",str_replace(',','',$oUser->getDs_name())));
		$ds_evaluador = stripslashes(str_replace(" ","_",str_replace(',','',$ds_evaluador)));

		
		$fileName = $dir.CYT_MSG_EVALUACION_ARCHIVO_NOMBRE.CYTSecureUtils::stripAccents($ds_evaluador).'_'.CYTSecureUtils::stripAccents($ds_apellido).'.pdf';;
		$pdf->Output($fileName,'F');
        //$pdf->Output(); 	
	        
		
        
		
		$year = $oPeriodo->getDs_periodo();
		$yearP = $year+1;
    	$params = array ($year,$yearP );		
		
		$subjectMail = htmlspecialchars(CdtFormatUtils::formatMessage( CYT_LBL_EVALUACION_MAIL_SUBJECT, $params ), ENT_QUOTES, "UTF-8");	
			
		$xtpl = new XTemplate( CYT_TEMPLATE_SOLICITUD_MAIL_ENVIAR );
		$xtpl->assign ( 'img_logo', WEB_PATH.'css/images/image002.gif' );
		$xtpl->assign('solicitud_titulo', $subjectMail);
		$xtpl->assign('year_label', CYT_LBL_SOLICITUD_MAIL_YEAR);
		$xtpl->assign('year', $oPeriodo->getDs_periodo());
		$xtpl->assign('investigador_label', CYT_LBL_SOLICITUD_MAIL_INVESTIGADOR);
		$xtpl->assign('investigador', htmlspecialchars($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre(), ENT_QUOTES, "UTF-8"));
		$xtpl->assign('motivo_label', CYT_LBL_SOLICITUD_ESTADO_MOTIVO);
		$xtpl->assign('motivo', htmlspecialchars($oSolicitud->getMotivo()->getDs_motivo(), ENT_QUOTES, "UTF-8"));
		//$xtpl->assign('comment', CYT_LBL_EVALUACION_MAIL_COMMENT);
		$xtpl->parse('main');		
		$bodyMail = $xtpl->text('main');
		
		$attachs = array();
		$attachs[]=$fileName;

		$managerUser = CYTSecureManagerFactory::getUserManager();
		$oUsuario = $managerUser->getObjectByCode($oUser->getCd_user());
		$ds_name = ($oUsuario->getDs_name())?$oUsuario->getDs_name():$oUsuario->getDs_username();
		CYTSecureUtils::sendMail(CDT_POP_MAIL_FROM_NAME, CDT_POP_MAIL_FROM, $subjectMail, $bodyMail, $attachs,$ds_name,$oUsuario->getDs_email());

		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
		$tEvaluacionEstado = CYTSecureDAOFactory::getEvaluacionEstadoDAO()->getTableName();
		$oCriteria->addFilter($tEvaluacionEstado.'.estado_oid', CYT_ESTADO_SOLICITUD_EVALUADA, '!=');
		$oCriteria->addNull('fechaHasta');
		$managerEvaluacion =  ManagerFactory::getEvaluacionManager();
		$noEvaluadas = $managerEvaluacion->getEntities($oCriteria);
		if ($noEvaluadas->size()==0) {
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
			$oCriteria->addNull('fechaHasta');
			$managerEvaluacion =  ManagerFactory::getEvaluacionManager();
			$oEvaluaciones = $managerEvaluacion->getEntities($oCriteria);
			if ($oEvaluaciones->size()==1) {
				$oSolicitud->setNu_diferencia(0);
				$oSolicitud->setNu_puntaje($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje());
			}
			else{
				$oSolicitud->setNu_diferencia(abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()));
				$oSolicitud->setNu_puntaje(($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()+$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje())/2);
			}
			/*if ($oSolicitud->getNu_diferencia()<CYT_DIFERENCIA){
				$oEstado = new Estado();
				$oEstado->setOid(CYT_ESTADO_SOLICITUD_EVALUADA);
				$oSolicitudManager = ManagerFactory::getSolicitudManager();
				$oSolicitudManager->cambiarEstado($oSolicitud, $oEstado, '');
			}*/
			if ($oEvaluaciones->size()>2) {
				if ($oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()){
					$puntajes = array(abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()),abs($oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()),abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()));
					CYTSecureUtils::logObject($puntajes);
					$minimo = 100;
					$item=0;
					for ($i=0; $i<3; $i++){
						if($puntajes[$i]<=$minimo){
							$minimo = $puntajes[$i];
							$item=$i;	
						}
						
					}
					switch ( $item) {
						case '0' :
							$oSolicitud->setNu_puntaje(($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()+$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje())/2);
							$oSolicitud->setNu_diferencia(abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()));
							break;
						case '1' :
							$oSolicitud->setNu_puntaje(($oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()+$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje())/2);
							$oSolicitud->setNu_diferencia(abs($oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()));
							break;
						case '2' :
							$oSolicitud->setNu_puntaje(($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()+$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje())/2);
							$oSolicitud->setNu_diferencia(abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()));
							break;
					}
					$oEstado = new Estado();
					$oEstado->setOid(CYT_ESTADO_SOLICITUD_EVALUADA);
					$oSolicitudManager = ManagerFactory::getSolicitudManager();
					$oSolicitudManager->cambiarEstado($oSolicitud, $oEstado, '');
					
				}
			}
			else{
				$oEstado = new Estado();
				$oEstado->setOid(CYT_ESTADO_SOLICITUD_EVALUADA);
				$oSolicitudManager = ManagerFactory::getSolicitudManager();
				$oSolicitudManager->cambiarEstado($oSolicitud, $oEstado, '');
			}
			$oSolicitudManager = ManagerFactory::getSolicitudManager();
			$oSolicitudManager->updateWithoutRelations($oSolicitud);
		}
	}
    
	public function cambiarEstado(Evaluacion $oEvaluacion, Estado $oEstado, $motivo){
	 	$oEvaluacionEstado = new EvaluacionEstado();
		$oEvaluacionEstado->setEvaluacion($oEvaluacion);
		$oEvaluacionEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
		$oEvaluacionEstado->setEstado($oEstado);
		$oEvaluacionEstado->setMotivo($motivo);
		$oUser = CdtSecureUtils::getUserLogged();
		$oEvaluacionEstado->setUser($oUser);
		$oEvaluacionEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
	 	$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('evaluacion_oid', $oEvaluacion->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerEvaluacionEstado =  CYTSecureManagerFactory::getEvaluacionEstadoManager();
		$evaluacionEstado = $managerEvaluacionEstado->getEntity($oCriteria);
		if (!empty($evaluacionEstado)) {
			if ($evaluacionEstado->getEstado()->getOid()!=$oEstado->getOid()) {// si el estado anterior es el mismo que el nuevo no hago nada
				$evaluacionEstado->setFechaHasta(date(DB_DEFAULT_DATETIME_FORMAT));
				//$evaluacionEstado->setUser($oUser);
				$evaluacionEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
				$evaluacionEstado->setEvaluacion($oEvaluacion);
				$managerEvaluacionEstado->update($evaluacionEstado);
				$managerEvaluacionEstado->add($oEvaluacionEstado);
			}
		}
		else
			$managerEvaluacionEstado->add($oEvaluacionEstado);
	 }
	
	protected function validateOnSend(Entity $entity){
	
		$error='';
		
		if ((!$entity->getNu_puntaje())||($entity->getNu_puntaje()==0)) {
			$error .= CYT_MSG_EVALUACION_PUNTAJE_CERO.'<br>';
		}
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_evaluacion', $entity->getOid(), '=');
		$oPuntajePlanManager =  ManagerFactory::getPuntajePlanManager();
		$oPuntajeplan = $oPuntajePlanManager->getEntity($oCriteria);
		$nu_puntaje = ($oPuntajeplan && $oPuntajeplan->getNu_puntaje())?$oPuntajeplan->getNu_puntaje():'';
		$ds_justificacionplan = ($oPuntajeplan && $oPuntajeplan->getDs_justificacion())?$oPuntajeplan->getDs_justificacion():'';
		
		if (($nu_puntaje)&&(!$ds_justificacionplan)) {
			$error .= CYT_MSG_EVALUACION_PLAN_TRABAJO_JUSTIFICACION_REQUERIDA.'<br>';
		}
		
		foreach ($entity->getEventos() as $evento) {
			
			
			$oEventoMaximoManager =  ManagerFactory::getEventoMaximoManager();
			$oEvento = $oEventoMaximoManager->getObjectByCode($evento->getEventomaximo()->getOid());
			
			if ((!$oEvento->getNu_min())&&(!$evento->getDs_justificacion())) {
				
				$error .= CYT_MSG_EVALUACION_JUSTIFICACION_REQUERIDA.'<br>';
				break;
			}
			       
		}
    	
    	
		if ($error) {
    		throw new GenericException( $error );
    	}
	}
	
	public function eliminarEvaluacion($evaluacion_oid){
		$puntajePlanDAO =  DAOFactory::getPuntajePlanDAO();
		$puntajePlanDAO->deletePuntajePlanPorEvaluacion($evaluacion_oid);
		$puntajeCategoriaDAO =  DAOFactory::getPuntajeCategoriaDAO();
		$puntajeCategoriaDAO->deletePuntajeCategoriaPorEvaluacion($evaluacion_oid);
		$puntajeCargoDAO =  DAOFactory::getPuntajeCargoDAO();
		$puntajeCargoDAO->deletePuntajeCargoPorEvaluacion($evaluacion_oid);
		$puntajeItemDAO =  DAOFactory::getPuntajeItemDAO();
		$puntajeItemDAO->deletePuntajeItemPorEvaluacion($evaluacion_oid);
		$puntajeEventoDAO =  DAOFactory::getPuntajeEventoDAO();
		$puntajeEventoDAO->deletePuntajeEventoPorEvaluacion($evaluacion_oid);
		$oEvaluacionEstadoDAO =  CYTSecureDAOFactory::getEvaluacionEstadoDAO();
		$oEvaluacionEstadoDAO->deleteEvaluacionEstadoPorEvaluacion($evaluacion_oid);
		$this->delete($evaluacion_oid);
	}
	
	public function confirm(Entity $entity, $estado_oid, $motivo='') {
		
		$oid = $entity->getOid();
		
		
		$oEvaluacionManager = ManagerFactory::getEvaluacionManager();
		$oEvaluacion = $oEvaluacionManager->getObjectByCode($oid);
		$oEstado = new Estado();
		$oEstado->setOid($estado_oid);
		$this->cambiarEstado($oEvaluacion, $oEstado, $motivo);
		
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($entity->getSolicitud()->getOid());
		
		switch ($estado_oid) {
			case CYT_ESTADO_SOLICITUD_EN_EVALUACION:
				$ds_subjet = CYT_LBL_EVALUACION_ADMISION;
				$ds_comment = CYT_LBL_SOLICITUD_ADMISION_COMMENT;
			break;
			
			case CYT_ESTADO_SOLICITUD_NO_ADMITIDA:
				$ds_subjet = CYT_LBL_EVALUACION_NO_ADMISION;
				$ds_comment = '<strong>'.htmlspecialchars(CYT_LBL_EVALUACION_NO_ADMISION_COMMENT).'</strong>: '.htmlspecialchars($motivo);
			break;
			
		}
		
        
		$msg = $ds_subjet.CYT_LBL_EVALUACION_MAIL_SUBJECT;
		
		$oPeriodoManager =  CYTSecureManagerFactory::getPeriodoManager();
		$oPeriodo = $oPeriodoManager->getObjectByCode($oSolicitud->getPeriodo()->getOid());
		
		$year = $oPeriodo->getDs_periodo();
		$yearP = $year+1;
    	$params = array ($year,$yearP );		
		
		$subjectMail = htmlspecialchars(CdtFormatUtils::formatMessage( $msg, $params ), ENT_QUOTES, "UTF-8");
		
		
		$xtpl = new XTemplate( CYT_TEMPLATE_SOLICITUD_MAIL_ENVIAR );
		$xtpl->assign ( 'img_logo', WEB_PATH.'css/images/image002.gif' );
		$xtpl->assign('solicitud_titulo', $subjectMail);
		$xtpl->assign('year_label', CYT_LBL_SOLICITUD_MAIL_YEAR);
		$xtpl->assign('year', $oPeriodo->getDs_periodo());
		$xtpl->assign('investigador_label', CYT_LBL_SOLICITUD_MAIL_INVESTIGADOR);
		$xtpl->assign('investigador', htmlspecialchars($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre(), ENT_QUOTES, "UTF-8"));
		$xtpl->assign('motivo_label', CYT_LBL_SOLICITUD_ESTADO_MOTIVO);
		$xtpl->assign('motivo', htmlspecialchars($oSolicitud->getMotivo()->getDs_motivo(), ENT_QUOTES, "UTF-8"));
		$xtpl->assign('comment', $ds_comment);
		$xtpl->parse('main');		
		$bodyMail = $xtpl->text('main');
		
		
		$oUser = CdtSecureUtils::getUserLogged();
		
		$managerUser = CYTSecureManagerFactory::getUserManager();
		$oUsuario = $managerUser->getObjectByCode($oUser->getCd_user());
		$ds_name = ($oUsuario->getDs_name())?$oUsuario->getDs_name():$oUsuario->getDs_username();
		CYTSecureUtils::sendMail(CDT_POP_MAIL_FROM_NAME, CDT_POP_MAIL_FROM, $subjectMail, $bodyMail, $attachs,$ds_name,$oUsuario->getDs_email());
		
		
        
				
       
        
        
	}
	
	public function actualizarPuntaje(Entity $entity) {
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($entity->getSolicitud()->getOid());
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
		$tEvaluacionEstado = CYTSecureDAOFactory::getEvaluacionEstadoDAO()->getTableName();
		$oCriteria->addFilter($tEvaluacionEstado.'.estado_oid', CYT_ESTADO_SOLICITUD_EVALUADA, '=');
		$oCriteria->addNull('fechaHasta');
		$managerEvaluacion =  ManagerFactory::getEvaluacionManager();
		$oEvaluaciones = $managerEvaluacion->getEntities($oCriteria);
		if ($oEvaluaciones->size()==1) {
			$oSolicitud->setNu_diferencia(0);
			$oSolicitud->setNu_puntaje($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje());
		}
		else{
			$oSolicitud->setNu_diferencia(abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()));
			$oSolicitud->setNu_puntaje(($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()+$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje())/2);
		}
		if ($oEvaluaciones->size()>2) {
			if ($oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()){
				$puntajes = array(abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()),abs($oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()),abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()));
				CYTSecureUtils::logObject($puntajes);
				$minimo = 100;
				$item=0;
				for ($i=0; $i<3; $i++){
					if($puntajes[$i]<=$minimo){
						$minimo = $puntajes[$i];
						$item=$i;	
					}
					
				}
				switch ( $item) {
					case '0' :
						$oSolicitud->setNu_puntaje(($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()+$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje())/2);
						$oSolicitud->setNu_diferencia(abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()));
						break;
					case '1' :
						$oSolicitud->setNu_puntaje(($oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()+$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje())/2);
						$oSolicitud->setNu_diferencia(abs($oEvaluaciones->getObjectByIndex(1)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()));
						break;
					case '2' :
						$oSolicitud->setNu_puntaje(($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()+$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje())/2);
						$oSolicitud->setNu_diferencia(abs($oEvaluaciones->getObjectByIndex(0)->getNu_puntaje()-$oEvaluaciones->getObjectByIndex(2)->getNu_puntaje()));
						break;
				}
				$oEstado = new Estado();
				$oEstado->setOid(CYT_ESTADO_SOLICITUD_EVALUADA);
				$oSolicitudManager = ManagerFactory::getSolicitudManager();
				$oSolicitudManager->cambiarEstado($oSolicitud, $oEstado, '');
				
			}
		}
		else{
			$oEstado = new Estado();
			$oEstado->setOid(CYT_ESTADO_SOLICITUD_EVALUADA);
			$oSolicitudManager = ManagerFactory::getSolicitudManager();
			$oSolicitudManager->cambiarEstado($oSolicitud, $oEstado, '');
		}
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitudManager->updateWithoutRelations($oSolicitud);
	}
}
?>
