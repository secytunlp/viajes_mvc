<?php

/**
 * Manager para Solicitud
 *  
 * @author Marcos
 * @since 13-11-2013
 */
class SolicitudManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getSolicitudDAO();
	}

	public function add(Entity $entity) {
		
		parent::add($entity);
		$managerEstado = CYTSecureManagerFactory::getEstadoManager();
		$oEstado = $managerEstado->getObjectByCode(CYT_ESTADO_SOLICITUD_CREADA);
		$oSolicitudEstado = new SolicitudEstado();
		$oSolicitudEstado->setSolicitud($entity);
		$oSolicitudEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
		$oSolicitudEstado->setEstado($oEstado);
		$oUser = CdtSecureUtils::getUserLogged();
		$oSolicitudEstado->setUser($oUser);
		$oSolicitudEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
		$managerSolicitudEstado = CYTSecureManagerFactory::getSolicitudEstadoManager();
		$managerSolicitudEstado->add($oSolicitudEstado);
		
		
		$managerLugarTrabajo =  CYTSecureManagerFactory::getLugarTrabajoManager();
		if ($entity->getLugarTrabajo()->getOid()) {
    		$managerLugarTrabajo =  CYTSecureManagerFactory::getLugarTrabajoManager();
	    	$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($entity->getLugarTrabajo()->getOid());
			if (!empty($oLugarTrabajo)) {
					$oLugarTrabajo->setDs_direccion($entity->getDs_direccion());
					$oLugarTrabajo->setDs_telefono($entity->getDs_telefono());
					$managerLugarTrabajo->update($oLugarTrabajo);	
			}
    	}
		
		//agregamos las entidades relacionadas.
		
		//ambitos
		$ambitos = $entity->getAmbitos();
		foreach ($ambitos as $oAmbito) {
			
			$oAmbito->setSolicitud( $entity );
			
			$managerAmbito = ManagerFactory::getAmbitoManager();
			$managerAmbito->add($oAmbito);
			
		}
		
		//montos
		$montos = $entity->getMontos();
		foreach ($montos as $oMonto) {
			$oMonto->setSolicitud( $entity );
			
			$managerMonto = ManagerFactory::getMontoManager();
			$managerMonto->add($oMonto);
			
		}
		
		//presupuestos
		$presupuestos = $entity->getPresupuestos();
		foreach ($presupuestos as $oPresupuesto) {
			$oPresupuesto->setSolicitud( $entity );
			
			$managerPresupuesto = ManagerFactory::getPresupuestoManager();
			$managerPresupuesto->add($oPresupuesto);
			
		}
		
		//proyectos
		$proyectos = $entity->getProyectos();
		
		
		foreach ($proyectos as $oProyecto) {
			$oProyecto->setSolicitud( $entity );
			
			$managerProyecto = ManagerFactory::getSolicitudProyectoManager();
			$managerProyecto->add($oProyecto);
			
		}
		
		
		
    }	
	
    
/**
     * se modifica la entity
     * @param (Entity $entity) entity a modificar.
     */
    public function update(Entity $entity) {
    	parent::update($entity);
    	if ($entity->getLugarTrabajo()->getOid()) {
    		$managerLugarTrabajo =  CYTSecureManagerFactory::getLugarTrabajoManager();
	    	$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($entity->getLugarTrabajo()->getOid());
			if (!empty($oLugarTrabajo)) {
					$oLugarTrabajo->setDs_direccion($entity->getDs_direccion());
					$oLugarTrabajo->setDs_telefono($entity->getDs_telefono());
					$managerLugarTrabajo->update($oLugarTrabajo);	
			}
    	}
		
    	$proyectoDAO =  DAOFactory::getSolicitudProyectoDAO();
        $proyectoDAO->deleteSolicitudProyectoPorSolicitud($entity->getOid());
		$proyectos = $entity->getProyectos();
		foreach ($proyectos as $proyecto) {
			$proyecto->setSolicitud( $entity );
			$managerSolicitudProyecto = ManagerFactory::getSolicitudProyectoManager();
			$managerSolicitudProyecto->add($proyecto);	
		}
    	
    	//ambitos
    	$ambitoDAO =  DAOFactory::getAmbitoDAO();
        $ambitoDAO->deleteAmbitoPorSolicitud($entity->getOid());
        
    	
		$ambitos = $entity->getAmbitos();
		foreach ($ambitos as $ambito) {
			$ambito->setSolicitud( $entity );
			
			$managerAmbito = ManagerFactory::getAmbitoManager();
			$managerAmbito->add($ambito);
			
		}
		
    	//montos
    	$montoDAO =  DAOFactory::getMontoDAO();
        $montoDAO->deleteMontoPorSolicitud($entity->getOid());
		$montos = $entity->getMontos();
		foreach ($montos as $monto) {
			$monto->setSolicitud( $entity );
			
			$managerMonto = ManagerFactory::getMontoManager();
			$managerMonto->add($monto);
			
		}
		
    	//presupuestos
    	$presupuestoDAO =  DAOFactory::getPresupuestoDAO();
        $presupuestoDAO->deletePresupuestoPorSolicitud($entity->getOid());
		$presupuestos = $entity->getPresupuestos();
		foreach ($presupuestos as $presupuesto) {
			$presupuesto->setSolicitud( $entity );
			
			$managerPresupuesto = ManagerFactory::getPresupuestoManager();
			$managerPresupuesto->add($presupuesto);
			
		}
        
    }
    
    
/**
     * se modifica la entity
     * @param (Entity $entity) entity a modificar.
     */
    public function updateWithoutRelations(Entity $entity) {
    	parent::update($entity);
        
    }
    
	/**
     * se elimina la entity
     * @param int identificador de la entity a eliminar.
     */
    public function delete($id) {
    	$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $id, '=');
		$oCriteria->addNull('fechaHasta');
		$managerSolicitudEstadoManager =  CYTSecureManagerFactory::getSolicitudEstadoManager();
		$oSolicitudEstado = $managerSolicitudEstadoManager->getEntity($oCriteria);
    	if (($oSolicitudEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_CREADA)) {
			
			throw new GenericException( CYT_MSG_SOLICITUD_ELIMINAR_PROHIBIDO);
		}
		else{
		
	    	$oSolicitudEstadoDAO =  CYTSecureDAOFactory::getSolicitudEstadoDAO();
	        $oSolicitudEstadoDAO->deleteSolicitudEstadoPorSolicitud($id);
	        
	        $oAmbito =  DAOFactory::getAmbitoDAO();
	        $oAmbito->deleteAmbitoPorSolicitud($id);
	        
	        $oMonto =  DAOFactory::getMontoDAO();
	        $oMonto->deleteMontoPorSolicitud($id);
	        
	        $oPresupuesto =  DAOFactory::getPresupuestoDAO();
	        $oPresupuesto->deletePresupuestoPorSolicitud($id);
	        
	        $oSolicitudProyecto =  DAOFactory::getSolicitudProyectoDAO();
	        $oSolicitudProyecto->deleteSolicitudProyectoPorSolicitud($id);
	        
	        $oSolicitudManager = ManagerFactory::getSolicitudManager();
			$oSolicitud = $oSolicitudManager->getObjectByCode($id);
	    	parent::delete( $id );
	    	
	    	$dirApp = CYT_PATH_PDFS.'/'.CYT_PERIODO_YEAR.'/';

			$dir =$dirApp. $oSolicitud->getDocente()->getNu_documento().'/';
	    	
	    	$handle=opendir($dir);
			while ($archivo = readdir($handle)){
		        if ((is_file($dir.$archivo))){
		         	unlink($dir.$archivo);
				}
			}
			
			$dir =$dirApp.str_pad($oSolicitud->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);
	    	
	    	$handle=opendir($dir);
			while ($archivo = readdir($handle)){
		        if ((is_file($dir.$archivo))){
		         	unlink($dir.$archivo);
				}
			}
			
			closedir($handle);
		}
		
    }
    
	/**
	 * (non-PHPdoc)
	 * @see classes/com/entities/manager/EntityManager::validateOnAdd()
	 */
    protected function validateOnAdd(Entity $entity){
    	
    	parent::validateOnAdd($entity);
    $error='';
	    
		if (in_array($entity->getDeddoc()->getOid(),explode(",",CYT_DEDICACIONES_SIMPLES))){	
			if ($entity->getLugarTrabajoBeca()->getOid()) {
				if ($entity->getBl_becario()) {
					$managerLugarTrabajo = CYTSecureManagerFactory::getLugarTrabajoManager();
					$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($entity->getLugarTrabajoBeca()->getOid());
					$encontre = 0;
					while((!$encontre)&&($oLugarTrabajo->getPadre()->getOid()!=0)){
						if ((!$encontre)&&(($oLugarTrabajo->getPadre()->getOid()==CYT_CD_LUGAR_TRABAJO_UNLP_CONICET)||($oLugarTrabajo->getPadre()->getOid()==CYT_CD_LUGAR_TRABAJO_UNLP))){
							
							$encontre = 1;
						}
						$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($oLugarTrabajo->getPadre()->getOid());
					}
					if (!$encontre) {
						$error .= CYT_MSG_SOLICITUD_LUGAR_TRABAJO_BECA_NO_UNLP.'<br>';
					}
				}
				
			}
			if ($entity->getLugarTrabajoCarrera()->getOid()) {
				if ($entity->getBl_carrera()) {
					$managerLugarTrabajo = CYTSecureManagerFactory::getLugarTrabajoManager();
					$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($entity->getLugarTrabajoCarrera()->getOid());
					$encontre = 0;
					while((!$encontre)&&($oLugarTrabajo->getPadre()->getOid()!=0)){
						if ((!$encontre)&&(($oLugarTrabajo->getPadre()->getOid()==CYT_CD_LUGAR_TRABAJO_UNLP_CONICET)||($oLugarTrabajo->getPadre()->getOid()==CYT_CD_LUGAR_TRABAJO_UNLP))){
							
							$encontre = 1;
						}
						$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($oLugarTrabajo->getPadre()->getOid());
					}
					if (!$encontre) {
						$error .= CYT_MSG_SOLICITUD_LUGAR_TRABAJO_CARRERA_NO_UNLP.'<br>';
					}
				}
				
			}
	    	
		}
    	if (($entity->getTipoInvestigador()->getOid()==CYT_INTEGRANTE_NO_FORMADO)&&($entity->getBl_congreso()==CYT_CD_CONFERENCIA)) {
    		$error .= CYT_MSG_SOLICITUD_CONFERENCISTA_NO_FORMADO.'<br>';
    	}
    	
    	if ($entity->getNu_monto()!=0) {
	    	if ($entity->getNu_monto()>CYT_MONTO_MAXIMO) {
	    		$error .= CYT_MSG_SOLICITUD_MONTO_MAXIMO.' '.CYTSecureUtils::formatMontoToView(CYT_MONTO_MAXIMO).'<br>';
	    	}
	    	else {
	    		$presupuestos = $entity->getPresupuestos();
	    		$total = 0;
				foreach ($presupuestos as $oPresupuesto) {
					$total +=$oPresupuesto->getNu_montopresupuesto();
				}
				if ($total!=0) {
					if ($entity->getNu_monto()!=$total) {
		    			$error .= CYT_MSG_SOLICITUD_MONTO_DECLARAR.' '.CYTSecureUtils::formatMontoToView(CYT_MONTO_MAXIMO).'<br>';
		    		}
				}
	    		
	    	}
    	}
    	
    	if ($error) {
    		throw new GenericException( $error );
    	}
    }
    
    /**
     * (non-PHPdoc)
     * @see classes/com/entities/manager/EntityManager::validateOnUpdate()
     */
	protected function validateOnUpdate(Entity $entity){
	
		parent::validateOnUpdate($entity);

		$error='';
	    
		if (in_array($entity->getDeddoc()->getOid(),explode(",",CYT_DEDICACIONES_SIMPLES))){	
			if ($entity->getLugarTrabajoBeca()->getOid()) {
				if ($entity->getBl_becario()) {
					$managerLugarTrabajo = CYTSecureManagerFactory::getLugarTrabajoManager();
					$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($entity->getLugarTrabajoBeca()->getOid());
					$encontre = 0;
					while((!$encontre)&&($oLugarTrabajo->getPadre()->getOid()!=0)){
						if ((!$encontre)&&(($oLugarTrabajo->getPadre()->getOid()==CYT_CD_LUGAR_TRABAJO_UNLP_CONICET)||($oLugarTrabajo->getPadre()->getOid()==CYT_CD_LUGAR_TRABAJO_UNLP))){
							
							$encontre = 1;
						}
						$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($oLugarTrabajo->getPadre()->getOid());
					}
					if (!$encontre) {
						$error .= CYT_MSG_SOLICITUD_LUGAR_TRABAJO_BECA_NO_UNLP.'<br>';
					}
				}
				
			}
			if ($entity->getLugarTrabajoCarrera()->getOid()) {
				if ($entity->getBl_carrera()) {
					$managerLugarTrabajo = CYTSecureManagerFactory::getLugarTrabajoManager();
					$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($entity->getLugarTrabajoCarrera()->getOid());
					$encontre = 0;
					while((!$encontre)&&($oLugarTrabajo->getPadre()->getOid()!=0)){
						if ((!$encontre)&&(($oLugarTrabajo->getPadre()->getOid()==CYT_CD_LUGAR_TRABAJO_UNLP_CONICET)||($oLugarTrabajo->getPadre()->getOid()==CYT_CD_LUGAR_TRABAJO_UNLP))){
							
							$encontre = 1;
						}
						$oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($oLugarTrabajo->getPadre()->getOid());
					}
					if (!$encontre) {
						$error .= CYT_MSG_SOLICITUD_LUGAR_TRABAJO_CARRERA_NO_UNLP.'<br>';
					}
				}
				
			}
	    	
		}
    	if (($entity->getTipoInvestigador()->getOid()==CYT_INTEGRANTE_NO_FORMADO)&&($entity->getBl_congreso()==CYT_CD_CONFERENCIA)) {
    		$error .= CYT_MSG_SOLICITUD_CONFERENCISTA_NO_FORMADO.'<br>';
    	}
    	
    	if ($entity->getNu_monto()!=0) {
	    	if ($entity->getNu_monto()>CYT_MONTO_MAXIMO) {
	    		$error .= CYT_MSG_SOLICITUD_MONTO_MAXIMO.' '.CYTSecureUtils::formatMontoToView(CYT_MONTO_MAXIMO).'<br>';
	    	}
	    	else {
	    		$presupuestos = $entity->getPresupuestos();
	    		$total = 0;
				foreach ($presupuestos as $oPresupuesto) {
					$total +=$oPresupuesto->getNu_montopresupuesto();
				}
				if ($total!=0) {
					if ($entity->getNu_monto()!=$total) {
		    			$error .= CYT_MSG_SOLICITUD_MONTO_DECLARAR.' '.CYTSecureUtils::formatMontoToView($entity->getNu_monto()).'<br>';
		    		}
				}
	    		
	    	}
    	}
    	
    	if ($error) {
    		throw new GenericException( $error );
    	}
		
	}

	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/entities/manager/EntityManager::validateOnDelete()
	 */
	protected function validateOnDelete($id){

		parent::validateOnDelete($id);

		
	}	
	
	
	public function send(Entity $entity) {
		$this->validateOnSend($entity);
		//armamos el pdf con la data necesaria.
		$pdf = new ViewSolicitudPDF();
		
		
		
		$oid = $entity->getOid();
		
		
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oid);
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_SOLICITUD_RECIBIDA);
		$this->cambiarEstado($oSolicitud, $oEstado, '');
		
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
			$pdf->setDs_justificacionB($oSolicitud->getDs_justificacionB());
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
		
		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= CYT_PERIODO_YEAR.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dirDoc = $dir.$oSolicitud->getDocente()->getNu_documento().'/';
		if (!file_exists($dirDoc)) mkdir($dirDoc, 0777);
		
		
		
		$fileName = $dirDoc.CYT_MSG_SOLICITUD_ARCHIVO_NOMBRE.CYTSecureUtils::stripAccents($oSolicitud->getDocente()->getDs_apellido()).'.pdf';;
		$pdf->Output($fileName,'F');
        $pdf->Output(); 	
	        
		$attachs = array();
		$handle=opendir($dirDoc);
		while ($archivo = readdir($handle))
		{
	        if (is_file($dirDoc.$archivo))
	         {
	         	$attachs[]=$dirDoc.$archivo;
	         }
		}
		$dirDoc = $dir.str_pad($oSolicitud->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);
		$handle=opendir($dirDoc);
		while ($archivo = readdir($handle))
		{
	        if (is_file($dirDoc.$archivo))
	         {
	         	$attachs[]=$dirDoc.$archivo;
	         }
		}
        
		$msg = CYT_LBL_SOLICITUD_MAIL_SUBJECT;
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
		$xtpl->parse('main');		
		$bodyMail = $xtpl->text('main');
		
		
		
		
		
		
        if ($oSolicitud->getDs_mail() != "") {
				
         		CYTSecureUtils::sendMail($oSolicitud->getDocente()->getDs_nombre().' '.$oSolicitud->getDocente()->getDs_apellido(), $oSolicitud->getDs_mail(), $subjectMail, $bodyMail, $attachs);
        
         		
        }
        CYTSecureUtils::sendMail(CDT_POP_MAIL_FROM_NAME, CDT_POP_MAIL_FROM, $subjectMail, $bodyMail, $attachs,$oSolicitud->getDocente()->getDs_nombre().' '.$oSolicitud->getDocente()->getDs_apellido(),$oSolicitud->getDs_mail());
	
	}
	
	protected function validateOnSend(Entity $entity){
	
		$error='';
		$becaUNLP=0;
		if ((!$entity->getDs_calle())||(!$entity->getNu_nro())||(!$entity->getNu_cp())||(!$entity->getDs_mail())) {
			$error .= CYT_MSG_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_DOMICILIO.'<br>';
		}
		if ((!$entity->getDs_titulogrado())||(!$entity->getLugarTrabajo()->getOid())||(!$entity->getFacultad()->getOid())||(!$entity->getCargo()->getOid())||($entity->getCargo()->getOid()==CYT_CD_CARGO_NO_DECLARADO)||(!$entity->getDeddoc()->getOid())||(!$entity->getDs_disciplina())||($entity->getDeddoc()->getOid()==CYT_CD_SIN_DEDICACION)) {
			$error .= CYT_MSG_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_UNIVERSIDAD.'<br>';
		}
		
		if (($entity->getBl_becario())&&($entity->getBl_carrera())){	
			$error .= CYT_MSG_BECARIO_CARRERA_PROHIBIDO.'<br>';
		}
		
		if ($entity->getBl_becario()) {
			if ((!$entity->getDs_orgbeca())||(!$entity->getLugarTrabajoBeca()->getOid())||(!$entity->getDs_tipobeca())||(!$entity->getDs_periodobeca())) {
				$error .= CYT_MSG_SOLICITUD_TAB_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_BECARIO.'<br>';
			}
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_docente', $entity->getDocente()->getOid(), '=');
			$oCriteria->addFilter('dt_hasta', CYT_FECHA_CIERRE, '>', new CdtCriteriaFormatStringValue());
			$oBecaManager =  CYTSecureManagerFactory::getBecaManager();
			$oBeca = $oBecaManager->getEntity($oCriteria);
			if (!empty($oBeca)) {
				$becaUNLP=$oBeca->getBl_unlp()?1:0;
			}
		}
		if ($entity->getBl_carrera()) {
			if ((!$entity->getDt_ingreso())||(!$entity->getLugarTrabajoCarrera()->getOid())||(!$entity->getOrganismo()->getOid())||(!$entity->getCarrerainv()->getOid())) {
				$error .= CYT_MSG_SOLICITUD_TAB_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_CARRERAINV.'<br>';
			}
		}
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $entity->getOid(), '=');
		$oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
		$oCriteria->addFilter('bl_seleccionado', 1, '=');
		$proyectosManager = new SolicitudProyectoManager();
		$elegidoPropio = $proyectosManager->getEntities($oCriteria);
		if (($elegidoPropio->size()!=1)&&!$becaUNLP) {
			$error .= CYT_MSG_SOLICITUD_SIN_PROYECTO_ELEGIDO.' '.CYT_MSG_SOLICITUD_TAB_PROYECTOS.'<br>';
		}
		
		
		if ((!$entity->getFacultadplanilla()->getOid())||(!$entity->getTipoInvestigador()->getOid())) {
			$error .= CYT_MSG_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_TIPO_INVESTIGADOR.'<br>';
		}
		if (!$entity->getMotivo()->getOid()) {
			$error .= CYT_MSG_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_MOTIVO.'<br>';
		}
		
		$ambitos = $entity->getAmbitos();
		/*if ($ambitos->isEmpty()) {
    		$error .=CYT_MSG_AMBITO_REQUIRED.'<br />';
    	}*/
		if ($ambitos->size()!=1) {
    			$error .=CYT_MSG_AMBITO_REQUIRED1.'<br />';
    	}
    	$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= CYT_PERIODO_YEAR.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$oUser = CdtSecureUtils::getUserLogged();
        $separarCUIL = explode('-',trim($oUser->getDs_username()));
		$dir .= $separarCUIL[1].'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$okCv=0;
		$okCVProfesor=0;
		$okTrabajo=0;
		$okAceptacion=0;
		$okInvitacion=0;
		$okAval=0;
		$okConvenio=0;
		$handle=opendir($dir);
		while ($archivo = readdir($handle))
		{
	        if ((is_file($dir.$archivo))&&(strchr($archivo,'CV_')))
	         {
	         	$okCv=1;
	         }
			if ((is_file($dir.$archivo))&&(strchr($archivo,'CVProfesor_')))
	         {
	         	$okCVProfesor=1;
	         }
			if ((is_file($dir.$archivo))&&(strchr($archivo,'Trabajo_')))
	         {
	         	$okTrabajo=1;
	         }
			if ((is_file($dir.$archivo))&&(strchr($archivo,'Aceptacion_')))
	         {
	         	$okAceptacion=1;
	         }
			if ((is_file($dir.$archivo))&&(strchr($archivo,'Invitacion_')))
	         {
	         	$okInvitacion=1;
	         }
			if ((is_file($dir.$archivo))&&(strchr($archivo,'Aval_')))
	         {
	         	$okAval=1;
	         }
			if ((is_file($dir.$archivo))&&(strchr($archivo,'Convenio_')))
	         {
	         	$okConvenio=1;
	         } 
		}
		
		
		if ($entity->getMotivo()->getOid()==CYT_MOTIVO_A) {
			if ((!$entity->getNu_monto())||(!$entity->getDs_curriculum())||(!$entity->getDs_relevanciatrabajo())||(!$entity->getDs_modalidadtrabajo())||(!$entity->getDs_objetivo())||($entity->getBl_congreso()==0)||(!$entity->getDs_titulotrabajo())||(!$entity->getDs_congreso())||(!$entity->getBl_nacional())||(!$entity->getDs_lugartrabajo())||(!$entity->getDt_fechatrabajo())||(!$entity->getDt_fechatrabajohasta())||(!$entity->getDs_relevanciaA())||(($entity->getBl_congreso()==2)&&(!$entity->getDs_aceptacion())&&(!$entity->getDs_linkreunion()))) {
				$error .= CYT_MSG_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_MOTIVO.'<br>';
			}
			if (!$okCv){
				$error .=CYT_MSG_INTEGRANTE_CV_PROBLEMA.'<br />';
			}
			/*if (!$okAceptacion){
				$error .=CYT_MSG_INTEGRANTE_ACEPTACION_PROBLEMA.'<br />';
			}*/
			
			if(CYTSecureUtils::formatDateToPersist($entity->getDt_fechatrabajo())>CYTSecureUtils::formatDateToPersist($entity->getDt_fechatrabajohasta())){
	    		$error .= CYT_MSG_SOLICITUD_FECHA_HASTA_MAYOR.'<br>';
	    			
	    	}
			
	    	foreach ($ambitos as $ambito) {
	    		if ((CYTSecureUtils::formatDateToPersist($entity->getDt_fechatrabajo())<CYTSecureUtils::formatDateToPersist($ambito->getDt_desde()))||(CYTSecureUtils::formatDateToPersist($entity->getDt_fechatrabajohasta())>CYTSecureUtils::formatDateToPersist($ambito->getDt_hasta()))) {
	    			$error .=CYT_MSG_AMBITO_FUERA_RANGO.'<br />';
	    			break;
	    		}
	    	}
			
			if (str_word_count($entity->getDs_resumentrabajo(),0)<CYT_RESUMEN_PALABRAS_MAXIMO) {
				$error .= CYT_MSG_SOLICITUD_RESUMEN_PALABRAS_REQUIRED.' '.CYT_RESUMEN_PALABRAS_MAXIMO.' '.CYT_MSG_SOLICITUD_RESUMEN_PALABRAS.'<br>';
			}
		}
		if ($entity->getMotivo()->getOid()==CYT_MOTIVO_B) {
			if ((!$entity->getNu_monto())||(!$entity->getDs_curriculum())||(!$entity->getDs_invitaciongrupo())||(!$entity->getDs_generalB())||(!$entity->getDs_especificoB())||(!$entity->getDs_actividadesB())||(!$entity->getDs_cronogramaB())||(!$entity->getDs_aportesB())||(!$entity->getDs_justificacionB())||(!$entity->getDs_relevanciaB())) {
				$error .= CYT_MSG_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_MOTIVO.'<br>';
			}
			if (!$okInvitacion){
				$error .=CYT_MSG_INTEGRANTE_INVITACIONGRUPO_PROBLEMA.'<br />';
			}
		}
		if ($entity->getMotivo()->getOid()==CYT_MOTIVO_C) {
			if ((!$entity->getNu_monto())||(!$entity->getDs_curriculum())||(!$entity->getDs_cvprofesor())||(!$entity->getDs_profesor())||(!$entity->getDs_lugarprofesor())||(!$entity->getDs_objetivoC())||(!$entity->getDs_planC())||(!$entity->getDs_relacionProyectoC())||(!$entity->getDs_aportesC())||(!$entity->getDs_actividadesC())) {
				$error .= CYT_MSG_CAMPOS_REQUERIDOS.' '.CYT_MSG_SOLICITUD_TAB_MOTIVO.'<br>';
			}
			if (!$okCVProfesor){
				$error .=CYT_MSG_INTEGRANTE_CVPROFESOR_PROBLEMA.'<br />';
			}
		}
		if (($entity->getTipoInvestigador()->getOid()==CYT_INTEGRANTE_NO_FORMADO)&&($entity->getMotivo()->getOid()==CYT_MOTIVO_C)){
			$error .= CYT_MSG_SOLICITUD_TIPO_C_FORMADOS.'<br>';
		}
	
		$presupuestos = $entity->getPresupuestos();
    	$total = 0;
		foreach ($presupuestos as $oPresupuesto) {
			$total +=$oPresupuesto->getNu_montopresupuesto();
		}
		if ($entity->getNu_monto()!=$total) {
    		$error .= CYT_MSG_SOLICITUD_MONTO_DECLARAR.' '.CYT_MSG_SOLICITUD_TAB_MOTIVO.'<br>';
    	}
		if ($error) {
    		throw new GenericException( $error );
    	}
	}
	
	public function confirm(Entity $entity, $estado_oid, $motivo='') {
		
		$oid = $entity->getOid();
		
		
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oid);
		$oEstado = new Estado();
		$oEstado->setOid($estado_oid);
		$this->cambiarEstado($oSolicitud, $oEstado, $motivo);
		
		switch ($estado_oid) {
			case CYT_ESTADO_SOLICITUD_ADMITIDA:
				$ds_subjet = CYT_LBL_SOLICITUD_ADMISION;
				$ds_comment = CYT_LBL_SOLICITUD_ADMISION_COMMENT;
			break;
			case CYT_ESTADO_SOLICITUD_OTORGADA:
				$ds_subjet = CYT_LBL_SOLICITUD_OTORGAMIENTO;
				$ds_comment = '';
			break;
			case CYT_ESTADO_SOLICITUD_NO_ADMITIDA:
				$ds_subjet = '';
				$ds_comment = '<strong>'.htmlspecialchars(CYT_LBL_SOLICITUD_NO_ADMISION_COMMENT).'</strong>: '.htmlspecialchars($motivo);
			break;
			
		}
		
        
		$msg = $ds_subjet.CYT_LBL_SOLICITUD_MAIL_SUBJECT;
		
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
		
		
		
		
		
		
        if ($oSolicitud->getDs_mail() != "") {
				
         		CYTSecureUtils::sendMail($oSolicitud->getDocente()->getDs_nombre().' '.$oSolicitud->getDocente()->getDs_apellido(), $oSolicitud->getDs_mail(), $subjectMail, $bodyMail, $attachs);
        }
        
	}

	public function cambiarEstado(Solicitud $oSolicitud, Estado $oEstado, $motivo){
		
	 	$oSolicitudEstado = new SolicitudEstado();
		$oSolicitudEstado->setSolicitud($oSolicitud);
		$oSolicitudEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
		$oSolicitudEstado->setEstado($oEstado);
		$oSolicitudEstado->setMotivo($motivo);
		$oUser = CdtSecureUtils::getUserLogged();
		$oSolicitudEstado->setUser($oUser);
		$oSolicitudEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
	 	
	 	$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('solicitud_oid', $oSolicitud->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerSolicitudEstado =  CYTSecureManagerFactory::getSolicitudEstadoManager();
		$solicitudEstado = $managerSolicitudEstado->getEntity($oCriteria);
		if (!empty($solicitudEstado)) {
			if ($solicitudEstado->getEstado()->getOid()!=$oEstado->getOid()) {// si el estado anterior es el mismo que el nuevo no hago nada
				$solicitudEstado->setFechaHasta(date(DB_DEFAULT_DATETIME_FORMAT));
				//$solicitudEstado->setUser($oUser);
				$solicitudEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
				$solicitudEstado->setSolicitud($oSolicitud);
				$managerSolicitudEstado->update($solicitudEstado);
				$managerSolicitudEstado->add($oSolicitudEstado);
			}
		}
		else
			$managerSolicitudEstado->add($oSolicitudEstado);
	 }
	
}
?>
