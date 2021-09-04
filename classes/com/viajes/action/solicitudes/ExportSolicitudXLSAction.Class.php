<?php

/**
 * Acción para exportar solicitudes a xls
 *
 * @author Marcos
 * @since 10-06-2014
 *
 */
class ExportSolicitudXLSAction extends CdtAction{


     public function execute(){
          //CdtDbManager::begin_tran();

         $layout =  new CdtLayoutXls();
         $nombre = date(CYT_DATETIME_FORMAT_STRING).'_'.CYT_LBL_SOLICITUD_XLS_NOMBRE;
         $layout->setFilename($nombre);

         try{
			$html .= "<table border=1'><tr><th>".CYT_LBL_SOLICITUD_PERIODO."</th><th>".CYT_LBL_SOLICITUD_SOLICITANTE."</th><th>".CYT_LBL_SOLICITUD_CUIL."</th><th>".CYT_LBL_SOLICITUD_MAIL."</th><th>".CYT_LBL_SOLICITUD_FECHA."</th><th>".CYT_LBL_SOLICITUD_ESTADO."</th><th>".CYT_LBL_CAT."</th><th>".CYT_LBL_SOLICITUD_FACULTAD."</th><th>".CYT_LBL_SOLICITUD_DISCIPLINA."</th><th>".CYT_LBL_SOLICITUD_MOTIVO."</th><th>".CYT_LBL_SOLICITUD_CARGO."</th><th>".CYT_LBL_SOLICITUD_CATEGORIA."</th><th>".CYT_LBL_SOLICITUD_TIPO_INVESTIGADOR."</th><th>".CYT_LBL_SOLICITUD_MONTO."</th><th>".CYT_LBL_SOLICITUD_LUGAR."</th><th>".CYT_LBL_SOLICITUD_CARGO."</th><th>".CYT_LBL_SOLICITUD_DEDICACION."</th><th>".CYT_LBL_SOLICITUD_LUGAR_TRABAJO."</th><th>".CYT_MSG_SOLICITUD_BECARIO."</th><th>".CYT_LBL_SOLICITUD_BECA_PERIODO."</th><th>".CYT_LBL_SOLICITUD_BECA_LUGAR_TRABAJO."</th><th>".CYT_MSG_SOLICITUD_INVESTIGADOR_CARRERA."</th><th>".CYT_LBL_SOLICITUD_CARRERA_LUGAR_TRABAJO."</th><th>".CYT_LBL_SOLICITUD_CARRERA_INGRESO."</th><th>".CYT_MSG_SOLICITUD_TAB_PROYECTOS."</th><th>".CYT_MSG_SOLICITUD_TAB_DOMICILIO."</th><th>".CYT_LBL_SOLICITUD_EVALUADORES."</th><th>".CYT_LBL_SOLICITUD_DIFERENCIA."</th><th>".CYT_LBL_SOLICITUD_PUNTAJE."</th></tr>";
			
		$filtro = new CMPSolicitudFilter();
		$filtro->fillSavedProperties();			
	
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addOrder($filtro->getOrderBy(),$filtro->getOrderType());
		$oCriteria->setPage(1);
		$oCriteria->setRowPerPage(3000);
			
         $solicitante = $filtro->getSolicitante();

		if(!empty($solicitante)){
			$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
			$filter = new CdtSimpleExpression( "(($tDocente.ds_nombre like '$solicitante%') OR ($tDocente.ds_apellido like '$solicitante%'))");

			$oCriteria->setExpresion($filter);
		}
		
		
		$facultad = $filtro->getFacultad();
		if($facultad!=null && $facultad->getOid()!=null){
			$oCriteria->addFilter("cd_facultadplanilla", $facultad->getOid(), "=" );
		}
		
		$estado = $filtro->getEstado();
		if($estado!=null && $estado->getOid()!=null){
			$tSolicitudEstado = CYTSecureDAOFactory::getSolicitudEstadoDAO()->getTableName();
			$oCriteria->addFilter("$tSolicitudEstado.estado_oid", $estado->getOid(), "=" );
		}
		
		$cat = $filtro->getCat();
		if($cat!=null && $cat->getOid()!=null){
			$oCriteria->addFilter("FacultadPlanilla.cd_cat", $cat->getOid(), "=" );
		}
		
		$periodo = $filtro->getPeriodo();
		if($periodo!=null && $periodo->getOid()!=null){
			$oCriteria->addFilter("cd_periodo", $filtro->getPeriodo()->getOid(), "=" );
			
		}
		
		
		
		$motivo = $filtro->getMotivo();
		if($motivo!=null && $motivo->getOid()!=null){
			$oCriteria->addFilter("cd_motivo", $motivo->getOid(), "=" );
		}	

		$oUser = CdtSecureUtils::getUserLogged();
		
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_SOLICITANTE) {
            $separarCUIL = explode('-',trim($oUser->getDs_username()));
            $oCriteriaDocente = new CdtSearchCriteria();
			$oCriteriaDocente->addFilter('nu_documento', $separarCUIL[1], '=');
			
			$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
			$oDocente = $oDocenteManager->getEntity($oCriteriaDocente);
            $oCriteria->addFilter("cd_docente", $oDocente->getOid(), "=");
        }
        
        
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_EVALUADOR) {
        	$oCriteriaEvaluacion = new CdtSearchCriteria();
			$oCriteriaEvaluacion->addFilter('cd_usuario',$oUser->getCd_user(), '=');
			$oCriteriaEvaluacion->addNull('fechaHasta');
			$tEvaluacionEstado = CYTSecureDAOFactory::getEvaluacionEstadoDAO()->getTableName();
			$filter = new CdtSimpleExpression( "(".$tEvaluacionEstado.".estado_oid =".CYT_ESTADO_SOLICITUD_RECIBIDA." OR ".$tEvaluacionEstado.".estado_oid =".CYT_ESTADO_SOLICITUD_EN_EVALUACION." OR ".$tEvaluacionEstado.".estado_oid =".CYT_ESTADO_SOLICITUD_EVALUADA.")");

			$oCriteria->setExpresion($filter);
			
			$oEvaluacionManager =  ManagerFactory::getEvaluacionManager();
			$oEvaluaciones = $oEvaluacionManager->getEntities($oCriteria);
			$evaluaciones = '';
			foreach ($oEvaluaciones as $oEvaluacion) {
				$evaluaciones .= $oEvaluacion->getSolicitud()->getOid().',';
			}
			
			if (($evaluaciones!='')) {
				
				$evaluaciones = substr( $evaluaciones, 0, strlen($evaluaciones)-1); //se le quita la última , (coma)
			}
			else{
				$evaluaciones = 0;
			}
			
			$tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
			$filter = new CdtSimpleExpression( "$tSolicitud.cd_solicitud IN (".$evaluaciones.")");

			$oCriteria->setExpresion($filter);
        	
        }
		
		
		$oCriteria->addNull('fechaHasta');
			
			$managerSolicitud =  ManagerFactory::getSolicitudManager();
			$solicitudes = $managerSolicitud->getEntities($oCriteria);
			$cant=0;
			
			foreach ($solicitudes as $oSolicitud) {
				$fecha = CYTSecureUtils::formatDateTimeToView($oSolicitud->getDt_fecha());
				
				$oCriteria = new CdtSearchCriteria();
				$oCriteria->addFilter('solicitud_oid', $oSolicitud->getOid(), '=');
				$oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
				$proyectosManager = new SolicitudProyectoManager();
				$oProyectos = $proyectosManager->getEntities($oCriteria);
				$proyectos = '';
				foreach ($oProyectos as $oProyecto) {
					$oCriteriaIntegrante = new CdtSearchCriteria();
					$oCriteriaIntegrante->addFilter("cd_tipoinvestigador", CYT_INTEGRANTE_CODIRECTOR, '=');
					$oCriteriaIntegrante->addFilter("cd_proyecto", $oProyecto->getProyecto()->getOid(), '=');
					$integrantesManager = CYTSecureManagerFactory::getIntegranteManager();
					$oCoDirector = $integrantesManager->getEntity($oCriteriaIntegrante);
					
					$cordir = ($oCoDirector)?' CODIR: '.$oCoDirector->getDocente()->getDs_apellido().', '.$oCoDirector->getDocente()->getDs_nombre():'';
					
					$proyectos .= $oProyecto->getProyecto()->getDs_codigo().' DIR: '.$oProyecto->getDirector()->getDs_apellido().', '.$oProyecto->getDirector()->getDs_nombre().$cordir.' ('.CYTSecureUtils::formatDateToView($oProyecto->getDt_alta()).'-'.CYTSecureUtils::formatDateToView($oProyecto->getDt_baja()).') '.$oProyecto->getEstado()->getDs_estado().' '.CYT_LBL_SOLICITUD_PROYECTOS_ESPECIALIDAD.': '.$oProyecto->getProyecto()->getDisciplina()->getDs_disciplina().'/'.$oProyecto->getProyecto()->getEspecialidad()->getDs_especialidad().'---';
				}
				
				$oCriteria = new CdtSearchCriteria();
				$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
				$presupuestoManager = ManagerFactory::getPresupuestoManager();
				$oPresupuestos = $presupuestoManager->getEntities($oCriteria);
				$monto = 0;
				foreach ($oPresupuestos as $oPresupuesto) {
					$monto += $oPresupuesto->getNu_montopresupuesto();
				}
				$monto = CYTSecureUtils::formatMontoToView($monto);
				
				
				$oCriteria = new CdtSearchCriteria();
				$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
		
				$ambitosManager = new AmbitoManager();
				$oAmbitos = $ambitosManager->getEntities($oCriteria);
				$lugar = '';
				foreach ($oAmbitos as $oAmbito) {
					$ds_lugar = ($oSolicitud->getMotivo()->getOid()==CYT_MOTIVO_C)?$oSolicitud->getDs_lugarprofesor():$oAmbito->getDs_ciudad().'/'.$oAmbito->getDs_pais();
					$lugar .=$ds_lugar.' ('.CYTSecureUtils::formatDateToView($oAmbito->getDt_desde()).'-'.CYTSecureUtils::formatDateToView($oAmbito->getDt_hasta()).') ---';
				}
				
				/*$oCriteria = new CdtSearchCriteria();
				$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
				$oCriteria->addNull('fechaHasta');
				
				$interno = '';
				
				$oCriteria->addFilter('bl_interno', 1, '=');*/
				$managerEvaluacion = ManagerFactory::getEvaluacionManager();
				/*$oEvaluacion = $managerEvaluacion->getEntity($oCriteria);
				if (!empty($oEvaluacion)) {
					$interno = $oEvaluacion->getUser()->getDs_username().' / '.$oEvaluacion->getEstado()->getDs_estado().' / P. '.number_format ( $oEvaluacion->getNu_puntaje() , CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES );
				}*/
				
				$oCriteria = new CdtSearchCriteria();
				$oCriteria->addFilter('cd_solicitud', $oSolicitud->getOid(), '=');
				$oCriteria->addNull('fechaHasta');
				
				/*$externo = '';
				$tercero = '';
				$oTercero = '';
				$oExterno = '';
				$oCriteria->addFilter('bl_interno', 0, '=');*/
				$oEvaluaciones = $managerEvaluacion->getEntities($oCriteria);
				$count=1;
				$evals = '';
				foreach ($oEvaluaciones as $oEval) {
					/*if ($count == 1) {
						$oExterno=$oEval;
					}
					else $oTercero=$oEval;
					$count++;*/
					$strInterno = ($oEval->getBl_interno())?'Interno':'Externo';
					$evals .= $oEval->getUser()->getDs_username().' / '.$strInterno.' / '.$oEval->getEstado()->getDs_estado().' / P. '.number_format ( $oEval->getNu_puntaje() , CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES ).'---';
				}
				
				/*if (!empty($oExterno)) {
					$externo = $oExterno->getUser()->getDs_username().' / '.$oExterno->getEstado()->getDs_estado().' / P. '.number_format ( $oExterno->getNu_puntaje() , CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES );
				}
				
				if (!empty($oTercero)) {
					$tercero = $oTercero->getUser()->getDs_username().' / '.$oTercero->getEstado()->getDs_estado().' / P. '.number_format ( $oTercero->getNu_puntaje() , CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES );
				}*/
				$ds_sigla = ($oSolicitud->getLugarTrabajo()->getDs_sigla())?" (".$oSolicitud->getLugarTrabajo()->getDs_sigla().")":"";
		
				$beca=($oSolicitud->getDs_orgbeca())?(($oSolicitud->getDs_tipobeca())?$oSolicitud->getDs_orgbeca().' - '.$oSolicitud->getDs_tipobeca():$oSolicitud->getDs_orgbeca()):'';
				
				$ds_siglabeca = ($oSolicitud->getLugarTrabajoBeca()->getDs_sigla())?" (".$oSolicitud->getLugarTrabajoBeca()->getDs_sigla().")":"";
		
				$carrera =($oSolicitud->getOrganismo()->getDs_organismo())?(($oSolicitud->getCarrerainv()->getDs_carrerainv())?$oSolicitud->getOrganismo()->getDs_organismo().' - '.$oSolicitud->getCarrerainv()->getDs_carrerainv():$oSolicitud->getOrganismo()->getDs_organismo()):'';
				
				$ds_siglacarrera = ($oSolicitud->getLugarTrabajoCarrera()->getDs_sigla())?" (".$oSolicitud->getLugarTrabajoCarrera()->getDs_sigla().")":"";
		
				$domicilio =$oSolicitud->getDs_calle().' '.CYT_LBL_DOCENTE_NRO.' '.$oSolicitud->getNu_nro().' ('.$oSolicitud->getNu_piso().' '.$oSolicitud->getDs_depto().') '.CYT_LBL_DOCENTE_CP.' '.$oSolicitud->getNu_cp();
				
				$html .= "<tr><td>".$oSolicitud->getPeriodo()->getDs_periodo()."</td><td>".$oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre()."</td><td>".$oSolicitud->getDocente()->getNu_precuil().'-'.$oSolicitud->getDocente()->getNu_documento().'-'.$oSolicitud->getDocente()->getNu_postcuil()."</td><td>".$oSolicitud->getDs_mail()."</td><td>".$fecha."</td><td>".$oSolicitud->getEstado()->getDs_estado()."</td><td>".$oSolicitud->getCat()->getDs_cat()."</td><td>".$oSolicitud->getFacultadplanilla()->getDs_facultad()."</td><td>".$oSolicitud->getDs_disciplina()."</td><td>".$oSolicitud->getMotivo()->getDs_letra()."</td></td><td>".$oSolicitud->getDocente()->getCargo()->getDs_cargo()."</td><td>".$oSolicitud->getDocente()->getCategoria()->getDs_categoria()."</td><td>".$oSolicitud->getTipoInvestigador()->getDs_tipoinvestigador()."</td><td>".$monto."</td><td>".$lugar."</td><td>".$oSolicitud->getCargo()->getDs_cargo()."</td><td>".$oSolicitud->getDeddoc()->getDs_deddoc()."</td><td>".$oSolicitud->getLugarTrabajo()->getDs_unidad().$ds_sigla."</td><td>".$beca."</td><td>".$oSolicitud->getDs_periodobeca()."</td><td>".$oSolicitud->getLugarTrabajoBeca()->getDs_unidad().$ds_siglabeca."</td><td>".$carrera."</td><td>".$oSolicitud->getLugarTrabajoCarrera()->getDs_unidad().$ds_siglacarrera."</td><td>".CYTSecureUtils::formatDateToView($oSolicitud->getDt_ingreso())."</td><td>".$proyectos."</td><td>".$domicilio."</td><td>".$evals."</td><td>".number_format ( $oSolicitud->getNu_diferencia() , CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES )."</td><td>".number_format ( $oSolicitud->getNu_puntaje() , CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES )."</td></tr>";
				
				
				$cant++;

				
			}
            $html .= "<tr><td colspan='5'></td></tr><tr><td colspan='5'>".CYT_LBL_PRESUPUESTO_TOTAL.": ".$cant."</td></tr></table>"; 
             

             //armamos el layout.

             $layout->setContent(CdtUIUtils::encodeCharactersXls($html));
             $layout->setTitle(CYT_LBL_SOLICITUD_XLS_NOMBRE);

             CdtDbManager::save();

         }catch(GenericException $ex){
             //capturamos la excepción y la parseamos en el layout.
             $layout->setException( $ex );
             CdtDbManager::undo();
         }

         //mostramos la salida formada por el layout.
         echo $layout->show();

         //no hay forward.
         $forward = null;

         return $forward;
     }

}
