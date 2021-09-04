<?php

/**
 * Acción para dar de alta una solicitud
 *
 * @author Marcos
 * @since 02-01-2014
 *
 */
class AddSolicitudAction extends AddEntityAction{

	
	protected function getEntity() {
		if (date('Y-m-d')>CYT_FECHA_CIERRE) {
			throw new GenericException( CYT_MSG_FIN_PERIODO );
		}
		$entity =  parent::getEntity();
		/*$oTipoInvestigador = new Tipoinvestigador();
		if (in_array($entity->getCategoria()->getOid(), explode(",",CYT_CATEGORIA_FORMADOS))) {
			$oTipoInvestigador->setOid(CYT_INTEGRANTE_FORMADO);
			$entity->setTipoInvestigador($oTipoInvestigador);
		}
		elseif (in_array($entity->getCategoria()->getOid(), explode(",",CYT_CATEGORIA_NO_FORMADOS))) {
			$oTipoInvestigador->setOid(CYT_INTEGRANTE_NO_FORMADO);
			$entity->setTipoInvestigador($oTipoInvestigador);
		}*/
		
		$oTipoInvestigador = new Tipoinvestigador();
		if (in_array($entity->getCategoria()->getOid(), explode(",",CYT_CATEGORIA_FORMADOS))) {
			$oTipoInvestigador->setOid(CYT_INTEGRANTE_FORMADO);
			$entity->setTipoInvestigador($oTipoInvestigador);
		}
		
			
		if ($entity->getTitulo()->getOid()) {
			$managerTitulo = CYTSecureManagerFactory::getTituloManager();
			$oTitulo = $managerTitulo->getObjectByCode($entity->getTitulo()->getOid());
			$entity->setDs_titulogrado($oTitulo->getDs_titulo());
		}	
		
		$error = '';
		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= CYT_PERIODO_YEAR.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$oUser = CdtSecureUtils::getUserLogged();
        $separarCUIL = explode('-',trim($oUser->getDs_username()));
		$dir .= $separarCUIL[1].'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('nu_documento', $separarCUIL[1], '=');
		
		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getEntity($oCriteria);
		$entity->setDocente($oDocente);
		$oPeriodoManager = CYTSecureManagerFactory::getPeriodoManager();
		$oPerioActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
		$entity->setPeriodo($oPerioActual);
		$entity->setBl_becario(($entity->getDs_orgbeca()||($entity->getLugarTrabajoBeca()->getOid())||($entity->getDs_tipobeca())||($entity->getDs_periodobeca()))?1:0);
		$entity->setBl_carrera((($entity->getDt_ingreso())||($entity->getLugarTrabajoCarrera()->getOid())||($entity->getOrganismo()->getOid())||($entity->getCarrerainv()->getOid()))?1:0);
		
		$entity->setDt_fecha(date(DB_DEFAULT_DATETIME_FORMAT));
		if(isset($_SESSION['archivos'])){
			$archivos = unserialize( $_SESSION['archivos'] );
			
			foreach ($archivos as $key => $archivo) {
				//CdtUtils::log("FILE: "   . $key.' - '.$archivo['name']);
				switch ($key) {
            		case 'ds_curriculum':
            		$nombre = CYT_LBL_SOLICITUD_A_CURRICULUM;
            		$sigla = CYT_LBL_SOLICITUD_A_CURRICULUM_SIGLA;
            		
            		break;
            		case 'ds_cvprofesor':
            		$nombre = CYT_LBL_SOLICITUD_C_CURRICULUM_VISITANTE;
            		$sigla = CYT_LBL_SOLICITUD_C_CURRICULUM_VISITANTE_SIGLA;
            		
            		break;
            		case 'ds_trabajo':
            		$nombre = CYT_LBL_SOLICITUD_A_COPIA_TRABAJO;
            		$sigla = CYT_LBL_SOLICITUD_A_COPIA_TRABAJO_SIGLA;
            		
				break;
        			case 'ds_aceptacion':
            		$nombre = CYT_LBL_SOLICITUD_A_ACEPTACION;
            		$sigla = CYT_LBL_SOLICITUD_A_ACEPTACION_SIGLA;
            		
            		break;
            		case 'ds_invitaciongrupo':
            		$nombre = CYT_LBL_SOLICITUD_B_INVITACION;
            		$sigla = CYT_LBL_SOLICITUD_A_INVITACION_SIGLA;
            		
            		break;
            		case 'ds_aval':
            		$nombre = CYT_LBL_SOLICITUD_B_AVAL;
            		$sigla = CYT_LBL_SOLICITUD_B_AVAL_SIGLA;
            		
            		break;
            		case 'ds_convenio':
            		$nombre = CYT_LBL_SOLICITUD_B_CONVENIO;
            		$sigla = CYT_LBL_SOLICITUD_B_CONVENIO;
            		
            		break;
        
            	}
				$explode_name = explode('.', $archivo['name']);
	            //Se valida así y no con el mime type porque este no funciona par algunos programas
	            $pos_ext = count($explode_name) - 1;
	            if (in_array(strtolower($explode_name[$pos_ext]), explode(",",CYT_EXTENSIONES_PERMITIDAS))) {
	            	CdtUtils::log("FILE: "   . $key.' - '.$archivo['name']);
	            	$siglaRemp = (($key=='ds_aceptacion')&&($entity->getBl_congreso()==CYT_CD_CONFERENCIA))?CYT_LBL_SOLICITUD_A_INVITACION_SIGLA:$sigla;
	            	if (is_file($dir.$archivo['nuevo'])){

	            		rename ($dir.$archivo['nuevo'],$dir.str_replace('TMP_'.$sigla, $siglaRemp, $archivo['nuevo'])); 
	            		
	            	}
	            	CdtReflectionUtils::doSetter( $entity, $key, str_replace('TMP_'.$sigla, $siglaRemp, $archivo['nuevo']) );
	            }
	            else {
	            	
	            	$error .=CYT_MSG_FORMATO_INVALIDO.$nombre.'<br />';
	            }
			}
		}
		unset($_SESSION['archivos']);
		$handle=opendir($dir);
		while ($archivo = readdir($handle)){
	        if ((is_file($dir.$archivo))&&(strchr($archivo,'TMP_'))){
	         	unlink($dir.$archivo);
			}
		}
		closedir($handle);
		if ($error) {
			throw new GenericException( $error );
		}
		//agregamos los ambitos relacionados a la solicitud.
		
		//ambitos.
		$ambitosManager = new AmbitoSessionManager();
		$entity->setAmbitos( $ambitosManager->getEntities(new CdtSearchCriteria()) );
		
		//montos.
		$montosManager = new MontoSessionManager();
		$entity->setMontos( $montosManager->getEntities(new CdtSearchCriteria()) );
		
		//presupuestos.
		$presupuestosManager = new PresupuestoSessionManager();
		$entity->setPresupuestos( $presupuestosManager->getEntities(new CdtSearchCriteria()) );
		
		$solicitudProyectosManager = new SolicitudProyectoSessionManager();
		$entity->setProyectos( $solicitudProyectosManager->getEntities(new CdtSearchCriteria()) );
	
		return $entity;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		$form = new CMPSolicitudForm();
		return $form;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$oSolicitud = new Solicitud();
		
		return $oSolicitud;
	}

	protected function getEntityManager(){
		return ManagerFactory::getSolicitudManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getForwardSuccess();
	 */
	protected function getForwardSuccess(){
		return 'add_solicitud_success';
	
	}
	


}
