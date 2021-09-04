<?php

/**
 * Manager para Cambio
 *  
 * @author Marcos
 * @since 13-11-2013
 */
class CambioManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getCambioDAO();
	}

	public function add(Entity $entity) {
		
		parent::add($entity);
		$oSolicitudManager =  ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($entity->getSolicitud()->getOid());
		
		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getObjectByCode($oSolicitud->getDocente()->getOid());
		
		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oSolicitud->getPeriodo()->getDs_periodo().'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oDocente->getNu_documento().'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$dir .= PATH_CAMBIOS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$handle=opendir($dir);
		while ($archivo = readdir($handle)){
	        if ((is_file($dir.$archivo))&&(strchr($archivo,'TMP_'))){
	        	rename ($dir.$archivo,$dir.str_replace('TMP_'.CYT_LBL_CAMBIO_A_CURRICULUM_SIGLA, $entity->getOid(), $archivo)); 
	        	CdtReflectionUtils::doSetter( $entity, 'ds_archivo', str_replace('TMP_'.CYT_LBL_CAMBIO_A_CURRICULUM_SIGLA, $entity->getOid(), $archivo) );
	         	//unlink($dir.$archivo);
			}
		}
		closedir($handle);
		parent::update($entity);
		$managerEstado = CYTSecureManagerFactory::getEstadoManager();
		$oEstado = $managerEstado->getObjectByCode(CYT_ESTADO_SOLICITUD_CREADA);
		$oCambioEstado = new CambioEstado();
		$oCambioEstado->setCambio($entity);
		$oCambioEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
		$oCambioEstado->setEstado($oEstado);
		$oUser = CdtSecureUtils::getUserLogged();
		$oCambioEstado->setUser($oUser);
		$oCambioEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
		$managerCambioEstado = ManagerFactory::getCambioEstadoManager();
		$managerCambioEstado->add($oCambioEstado);
		
		
		
		
		//agregamos las entidades relacionadas.
		
		//ambitos
		$ambitos = $entity->getAmbitos();
		foreach ($ambitos as $oAmbito) {
			$oAmbitoCambio = new AmbitoCambio();
			$oAmbitoCambio->setCambio( $entity );
			$oAmbitoCambio->setDs_ciudad($oAmbito->getDs_ciudad());
			$oAmbitoCambio->setDs_institucion($oAmbito->getDs_institucion());
			$oAmbitoCambio->setDs_pais($oAmbito->getDs_pais());
			$oAmbitoCambio->setDt_desde($oAmbito->getDt_desde());
			$oAmbitoCambio->setDt_hasta($oAmbito->getDt_hasta());
			$managerAmbito = ManagerFactory::getAmbitoCambioManager();
			$managerAmbito->add($oAmbitoCambio);
			
		}
		
		
		
		//presupuestos
		$presupuestos = $entity->getPresupuestos();
		foreach ($presupuestos as $oPresupuesto) {
			$oPresupuestoCambio = new PresupuestoCambio();
			$oPresupuestoCambio->setCambio( $entity );
			$oPresupuestoCambio->setDs_destino($oPresupuesto->getDs_destino());
			$oPresupuestoCambio->setDs_dias($oPresupuesto->getDs_dias());
			$oPresupuestoCambio->setDs_inscripcion($oPresupuesto->getDs_inscripcion());
			$oPresupuestoCambio->setDs_lugar($oPresupuesto->getDs_lugar());
			$oPresupuestoCambio->setDs_pasajes($oPresupuesto->getDs_pasajes());
			$oPresupuestoCambio->setDs_presupuesto($oPresupuesto->getDs_presupuesto());
			$oPresupuestoCambio->setDt_fecha($oPresupuesto->getDt_fecha());
			$oPresupuestoCambio->setNu_montopresupuesto($oPresupuesto->getNu_montopresupuesto());
			$oPresupuestoCambio->setTipoPresupuesto($oPresupuesto->getTipoPresupuesto());
			$managerPresupuesto = ManagerFactory::getPresupuestoCambioManager();
			$managerPresupuesto->add($oPresupuestoCambio);
			
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
		
    	
    	//ambitos
    	$ambitoDAO =  DAOFactory::getAmbitoDAO();
        $ambitoDAO->deleteAmbitoPorCambio($entity->getOid());
        
    	
		$ambitos = $entity->getAmbitos();
		foreach ($ambitos as $ambito) {
			$ambito->setCambio( $entity );
			
			$managerAmbito = ManagerFactory::getAmbitoCambioManager();
			$managerAmbito->add($ambito);
			
		}
		
    	
		
    	//presupuestos
    	$presupuestoDAO =  DAOFactory::getPresupuestoDAO();
        $presupuestoDAO->deletePresupuestoPorCambio($entity->getOid());
		$presupuestos = $entity->getPresupuestos();
		foreach ($presupuestos as $presupuesto) {
			$presupuesto->setCambio( $entity );
			
			$managerPresupuesto = ManagerFactory::getPresupuestoCambioManager();
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
		$oCriteria->addFilter('cambio_oid', $id, '=');
		$oCriteria->addNull('fechaHasta');
		$managerCambioEstadoManager =  ManagerFactory::getCambioEstadoManager();
		$oCambioEstado = $managerCambioEstadoManager->getEntity($oCriteria);
    	if (($oCambioEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_CREADA)) {
			
			throw new GenericException( CYT_MSG_CAMBIO_ELIMINAR_PROHIBIDO);
		}
		else{
		
			$oCambioManager =  ManagerFactory::getCambioManager();
			$oCambio = $oCambioManager->getObjectByCode($id);
		
			$oSolicitudManager =  ManagerFactory::getSolicitudManager();
			$oSolicitud = $oSolicitudManager->getObjectByCode($oCambio->getSolicitud()->getOid());
			
	    	$oCambioEstadoDAO =  DAOFactory::getCambioEstadoDAO();
	        $oCambioEstadoDAO->deleteCambioEstadoPorCambio($id);
	        
	        $oAmbito =  DAOFactory::getAmbitoCambioDAO();
	        $oAmbito->deleteAmbitoCambioPorCambio($id);
	        
	       
	        
	        $oPresupuesto =  DAOFactory::getPresupuestoCambioDAO();
	        $oPresupuesto->deletePresupuestoCambioPorCambio($id);
	        
	       
	        
	        $oCambioManager = ManagerFactory::getCambioManager();
			$oCambio = $oCambioManager->getObjectByCode($id);
	    	parent::delete( $id );
	    	
	    	$dirApp = CYT_PATH_PDFS.'/'.$oSolicitud->getPeriodo()->getDs_periodo().'/';

			$dir =$dirApp. $oSolicitud->getDocente()->getNu_documento().'/'.PATH_CAMBIOS.'/';
	    	
	    	$handle=opendir($dir);
			while ($archivo = readdir($handle)){
		        if ((is_file($dir.$archivo))){
		         	unlink($dir.$archivo);
				}
			}
			
			$dir =$dirApp.str_pad($oSolicitud->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);
	    	$dir .='/'.PATH_CAMBIOS.'/';
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
		$oid = $entity->getOid();
		$oCambioManager = ManagerFactory::getCambioManager();
		$oCambio = $oCambioManager->getObjectByCode($oid);
		
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oCambio->getSolicitud()->getOid());
		
		
		$this->validateOnSend($entity, $oSolicitud->getNu_monto());
		//armamos el pdf con la data necesaria.
		$pdf = new ViewCambioPDF();
		
		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_SOLICITUD_RECIBIDA);
		$this->cambiarEstado($oCambio, $oEstado, '');
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cambio_oid', $oCambio->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerCambioEstado =  ManagerFactory::getCambioEstadoManager();
		$oCambioEstado = $managerCambioEstado->getEntity($oCriteria);
		$pdf->setEstado_oid($oCambioEstado->getEstado()->getOid());
		
		$pdf->setPeriodo_oid($oSolicitud->getPeriodo()->getOid());
		
		
		$oPeriodoManager =  CYTSecureManagerFactory::getPeriodoManager();
		$oPeriodo = $oPeriodoManager->getObjectByCode($oSolicitud->getPeriodo()->getOid());
		$pdf->setYear($oPeriodo->getDs_periodo());
		
		
		
		
		$pdf->setDs_investigador($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre());
		$pdf->setNu_cuil($oSolicitud->getDocente()->getNu_precuil().'-'.$oSolicitud->getDocente()->getNu_documento().'-'.$oSolicitud->getDocente()->getNu_postcuil());
		
		$pdf->setDs_observacion($oCambio->getDs_observacion());
		
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_cambio', $oCambio->getOid(), '=');
		
		$ambitosManager = new AmbitoCambioManager();
		$pdf->setAmbitos( $ambitosManager->getEntities($oCriteria) );
		
			
		$pdf->setFacultadplanilla_oid($oSolicitud->getFacultadplanilla()->getOid());
		
		
	
    	($oSolicitud->getFacultadplanilla()->getOid() != CYT_FACULTAD_NO_DECLARADA)?$pdf->setDs_facultadplanilla($oSolicitud->getFacultadplanilla()->getDs_facultad()):$pdf->setDs_facultadplanilla(CYT_MSG_SOLICITUD_UNIVERSIDAD);;
		
    	$presupuestosManager = new PresupuestoCambioManager();
		$pdf->setPresupuestos( $presupuestosManager->getEntities($oCriteria) );
    	
		$pdf->title = CYT_MSG_CAMBIO_PDF_TITLE;
		$pdf->SetFont('Arial','', 13);
		
		// establecemos los márgenes
		$pdf->SetMargins(10, 20 , 10);
		$pdf->setMaxWidth($pdf->w - $pdf->lMargin - $pdf->rMargin);
		//$pdf->SetAutoPageBreak(true,90);
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		//imprimimos la solicitud.
		$pdf->printCambio();
		
		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oSolicitud->getPeriodo()->getDs_periodo().'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dirDoc = $dir.$oSolicitud->getDocente()->getNu_documento().'/'.PATH_CAMBIOS.'/';;
		if (!file_exists($dirDoc)) mkdir($dirDoc, 0777);
		
		
		
		$fileName = $dirDoc.CYT_MSG_CAMBIO_ARCHIVO_NOMBRE.CYTSecureUtils::stripAccents($oSolicitud->getDocente()->getDs_apellido()).'.pdf';;
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
        
		$msg = CYT_LBL_CAMBIO_MAIL_SUBJECT;
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
	
	protected function validateOnSend(Entity $entity, $monto=0){
	
		$error='';
		
		
		$presupuestos = $entity->getPresupuestos();
    	$total = 0;
		foreach ($presupuestos as $oPresupuesto) {
			$total +=$oPresupuesto->getNu_montopresupuesto();
		}
		if ($monto!=$total) {
    		$error .= CYT_MSG_SOLICITUD_MONTO_DECLARAR.' '.CYTSecureUtils::formatMontoToView($monto).'<br>';
    	}
		if ($error) {
    		throw new GenericException( $error );
    	}
	}
	
	

	public function cambiarEstado(Cambio $oCambio, Estado $oEstado, $motivo){
		
	 	$oCambioEstado = new CambioEstado();
		$oCambioEstado->setCambio($oCambio);
		$oCambioEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
		$oCambioEstado->setEstado($oEstado);
		$oCambioEstado->setMotivo($motivo);
		$oUser = CdtSecureUtils::getUserLogged();
		$oCambioEstado->setUser($oUser);
		$oCambioEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
	 	
	 	$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cambio_oid', $oCambio->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerCambioEstado =  ManagerFactory::getCambioEstadoManager();
		$cambioEstado = $managerCambioEstado->getEntity($oCriteria);
		if (!empty($cambioEstado)) {
			if ($cambioEstado->getEstado()->getOid()!=$oEstado->getOid()) {// si el estado anterior es el mismo que el nuevo no hago nada
				$cambioEstado->setFechaHasta(date(DB_DEFAULT_DATETIME_FORMAT));
				//$cambioEstado->setUser($oUser);
				$cambioEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
				$cambioEstado->setCambio($oCambio);
				$managerCambioEstado->update($cambioEstado);
				$managerCambioEstado->add($oCambioEstado);
			}
		}
		else
			$managerCambioEstado->add($oCambioEstado);
	 }
	
}
?>
