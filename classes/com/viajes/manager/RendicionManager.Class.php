<?php

/**
 * Manager para Rendicion
 *
 * @author Marcos
 * @since 29-09-2021
 */
class RendicionManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getRendicionDAO();
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
		$dir .= PATH_RENDICIONES.'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$handle=opendir($dir);
		while ($archivo = readdir($handle)){
			if ((is_file($dir.$archivo))&&(strchr($archivo,'TMP_'.CYT_LBL_RENDICION_RENDICION_SIGLA))){
				rename ($dir.$archivo,$dir.str_replace('TMP_'.CYT_LBL_RENDICION_RENDICION_SIGLA, $entity->getOid(), $archivo));
				CdtReflectionUtils::doSetter( $entity, 'ds_rendicion', str_replace('TMP_'.CYT_LBL_RENDICION_RENDICION_SIGLA, $entity->getOid(), $archivo) );
				//unlink($dir.$archivo);
			}
			if ((is_file($dir.$archivo))&&(strchr($archivo,'TMP_'.CYT_LBL_RENDICION_INFORME_SIGLA))){
				rename ($dir.$archivo,$dir.str_replace('TMP_'.CYT_LBL_RENDICION_INFORME_SIGLA, $entity->getOid(), $archivo));
				CdtReflectionUtils::doSetter( $entity, 'ds_informe', str_replace('TMP_'.CYT_LBL_RENDICION_INFORME_SIGLA, $entity->getOid(), $archivo) );
				//unlink($dir.$archivo);
			}
			if ((is_file($dir.$archivo))&&(strchr($archivo,'TMP_'.CYT_LBL_RENDICION_CONSTANCIA_SIGLA))){
				rename ($dir.$archivo,$dir.str_replace('TMP_'.CYT_LBL_RENDICION_CONSTANCIA_SIGLA, $entity->getOid(), $archivo));
				CdtReflectionUtils::doSetter( $entity, 'ds_certificado', str_replace('TMP_'.CYT_LBL_CERTIFICADO_CONSTANCIA_SIGLA, $entity->getOid(), $archivo) );
				//unlink($dir.$archivo);
			}
		}
		closedir($handle);
		parent::update($entity);
		$managerEstado = CYTSecureManagerFactory::getEstadoManager();
		$oEstado = $managerEstado->getObjectByCode(CYT_ESTADO_SOLICITUD_CREADA);
		$oRendicionEstado = new RendicionEstado();
		$oRendicionEstado->setRendicion($entity);
		$oRendicionEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
		$oRendicionEstado->setEstado($oEstado);
		$oUser = CdtSecureUtils::getUserLogged();
		$oRendicionEstado->setUser($oUser);
		$oRendicionEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
		$managerRendicionEstado = ManagerFactory::getRendicionEstadoManager();
		$managerRendicionEstado->add($oRendicionEstado);










	}


	/**
	 * se modifica la entity
	 * @param (Entity $entity) entity a modificar.
	 */
	public function update(Entity $entity) {
		parent::update($entity);
		/*if ($entity->getLugarTrabajo()->getOid()) {
            $managerLugarTrabajo =  CYTSecureManagerFactory::getLugarTrabajoManager();
            $oLugarTrabajo = $managerLugarTrabajo->getObjectByCode($entity->getLugarTrabajo()->getOid());
            if (!empty($oLugarTrabajo)) {
                    $oLugarTrabajo->setDs_direccion($entity->getDs_direccion());
                    $oLugarTrabajo->setDs_telefono($entity->getDs_telefono());
                    $managerLugarTrabajo->update($oLugarTrabajo);
            }
        }*/




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
		$oCriteria->addFilter('rendicion_oid', $id, '=');
		$oCriteria->addNull('fechaHasta');
		$managerRendicionEstadoManager =  ManagerFactory::getRendicionEstadoManager();
		$oRendicionEstado = $managerRendicionEstadoManager->getEntity($oCriteria);
		if (($oRendicionEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_CREADA)) {

			throw new GenericException( CYT_MSG_CAMBIO_ELIMINAR_PROHIBIDO);
		}
		else{

			$oRendicionManager =  ManagerFactory::getRendicionManager();
			$oRendicion = $oRendicionManager->getObjectByCode($id);

			$oSolicitudManager =  ManagerFactory::getSolicitudManager();
			$oSolicitud = $oSolicitudManager->getObjectByCode($oRendicion->getSolicitud()->getOid());

			$oRendicionEstadoDAO =  DAOFactory::getRendicionEstadoDAO();
			$oRendicionEstadoDAO->deleteRendicionEstadoPorRendicion($id);





			$oRendicionManager = ManagerFactory::getRendicionManager();
			$oRendicion = $oRendicionManager->getObjectByCode($id);
			parent::delete( $id );

			$dirApp = CYT_PATH_PDFS.'/'.$oSolicitud->getPeriodo()->getDs_periodo().'/';

			$dir =$dirApp. $oSolicitud->getDocente()->getNu_documento().'/'.PATH_RENDICIONES.'/';

			$handle=opendir($dir);
			while ($archivo = readdir($handle)){
				if ((is_file($dir.$archivo))){
					unlink($dir.$archivo);
				}
			}

			$dir =$dirApp.str_pad($oSolicitud->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);
			$dir .='/'.PATH_RENDICIONES.'/';
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
		$oRendicionManager = ManagerFactory::getRendicionManager();
		$oRendicion = $oRendicionManager->getObjectByCode($oid);

		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oRendicion->getSolicitud()->getOid());


		$this->validateOnSend($entity, $oSolicitud->getMotivo()->getOid(), $oSolicitud->getPeriodo()->getDs_periodo());
		//armamos el pdf con la data necesaria.
		$pdf = new ViewRendicionPDF();

		$oEstado = new Estado();
		$oEstado->setOid(CYT_ESTADO_SOLICITUD_RECIBIDA);
		$this->cambiarEstado($oRendicion, $oEstado, '');

		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('rendicion_oid', $oRendicion->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerRendicionEstado =  ManagerFactory::getRendicionEstadoManager();
		$oRendicionEstado = $managerRendicionEstado->getEntity($oCriteria);
		$pdf->setEstado_oid($oRendicionEstado->getEstado()->getOid());

		$pdf->setPeriodo_oid($oSolicitud->getPeriodo()->getOid());


		$oPeriodoManager =  CYTSecureManagerFactory::getPeriodoManager();
		$oPeriodo = $oPeriodoManager->getObjectByCode($oSolicitud->getPeriodo()->getOid());
		$pdf->setYear($oPeriodo->getDs_periodo());




		$pdf->setDs_investigador($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre());
		$pdf->setNu_cuil($oSolicitud->getDocente()->getNu_precuil().'-'.$oSolicitud->getDocente()->getNu_documento().'-'.$oSolicitud->getDocente()->getNu_postcuil());

		$pdf->setDs_observacion($oRendicion->getDs_observacion());





		$pdf->setFacultadplanilla_oid($oSolicitud->getFacultadplanilla()->getOid());



		($oSolicitud->getFacultadplanilla()->getOid() != CYT_FACULTAD_NO_DECLARADA)?$pdf->setDs_facultadplanilla($oSolicitud->getFacultadplanilla()->getDs_facultad()):$pdf->setDs_facultadplanilla(CYT_MSG_SOLICITUD_UNIVERSIDAD);;

		/*$presupuestosManager = new PresupuestoRendicionManager();
        $pdf->setPresupuestos( $presupuestosManager->getEntities($oCriteria) );*/

		$pdf->title = CYT_MSG_RENDICION_PDF_TITLE;
		$pdf->SetFont('Arial','', 13);

		// establecemos los mÃ¡rgenes
		$pdf->SetMargins(10, 20 , 10);
		$pdf->setMaxWidth($pdf->w - $pdf->lMargin - $pdf->rMargin);
		//$pdf->SetAutoPageBreak(true,90);
		$pdf->AddPage();
		$pdf->AliasNbPages();

		//imprimimos la solicitud.
		$pdf->printRendicion();

		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$dir .= $oSolicitud->getPeriodo()->getDs_periodo().'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$dirDoc = $dir.$oSolicitud->getDocente()->getNu_documento().'/'.PATH_RENDICIONES.'/';;
		if (!file_exists($dirDoc)) mkdir($dirDoc, 0777);



		$fileName = $dirDoc.CYT_MSG_RENDICION_ARCHIVO_NOMBRE.CYTSecureUtils::stripAccents($oSolicitud->getDocente()->getDs_apellido()).'.pdf';;
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

		$msg = CYT_LBL_RENDICION_MAIL_SUBJECT;
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

	protected function validateOnSend(Entity $entity, $motivo='', $periodo=CYT_PERIODO_YEAR){

		$error='';


		/*$presupuestos = $entity->getPresupuestos();
    	$total = 0;
		foreach ($presupuestos as $oPresupuesto) {
			$total +=$oPresupuesto->getNu_montopresupuesto();
		}
		if ($monto!=$total) {
    		$error .= CYT_MSG_SOLICITUD_MONTO_DECLARAR.' '.CYTSecureUtils::formatMontoToView($monto).'<br>';
    	}*/

		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$dir .= $periodo.'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$oUser = CdtSecureUtils::getUserLogged();
		$separarCUIL = explode('-',trim($oUser->getDs_username()));
		$dir .= $separarCUIL[1].'/';
		$dir .= PATH_RENDICIONES.'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$okInforme=0;
		$okRendicion=0;
		$okCertificado=0;

		$handle=opendir($dir);
		while ($archivo = readdir($handle))
		{
			if ((is_file($dir.$archivo))&&(strchr($archivo,'Informe_')))
			{
				$okInforme=1;
			}
			if ((is_file($dir.$archivo))&&(strchr($archivo,'Rendicion_')))
			{
				$okRendicion=1;
			}
			if ((is_file($dir.$archivo))&&(strchr($archivo,'Constancia_')))
			{
				$okCertificado=1;
			}

		}

		if (!$okRendicion){
			$error .=CYT_MSG_RENDICION_RENDICION_PROBLEMA.'<br />';
		}
		if (!$okInforme){
			$error .=CYT_MSG_RENDICION_INFORME_PROBLEMA.'<br />';
		}

		if ($motivo!=CYT_MOTIVO_C) {

			if (!$okCertificado){
				$error .=CYT_MSG_RENDICION_CONSTANCIA_PROBLEMA.'<br />';
			}
		}


		if ($error) {
			throw new GenericException( $error );
		}
	}



	public function cambiarEstado(Rendicion $oRendicion, Estado $oEstado, $motivo){

		$oRendicionEstado = new RendicionEstado();
		$oRendicionEstado->setRendicion($oRendicion);
		$oRendicionEstado->setFechaDesde(date(DB_DEFAULT_DATETIME_FORMAT));
		$oRendicionEstado->setEstado($oEstado);
		$oRendicionEstado->setMotivo($motivo);
		$oUser = CdtSecureUtils::getUserLogged();
		$oRendicionEstado->setUser($oUser);
		$oRendicionEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));

		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('rendicion_oid', $oRendicion->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerRendicionEstado =  ManagerFactory::getRendicionEstadoManager();
		$rendicionEstado = $managerRendicionEstado->getEntity($oCriteria);
		if (!empty($rendicionEstado)) {
			if ($rendicionEstado->getEstado()->getOid()!=$oEstado->getOid()) {// si el estado anterior es el mismo que el nuevo no hago nada
				$rendicionEstado->setFechaHasta(date(DB_DEFAULT_DATETIME_FORMAT));
				//$rendicionEstado->setUser($oUser);
				$rendicionEstado->setFechaUltModificacion(date(DB_DEFAULT_DATETIME_FORMAT));
				$rendicionEstado->setRendicion($oRendicion);
				$managerRendicionEstado->update($rendicionEstado);
				$managerRendicionEstado->add($oRendicionEstado);
			}
		}
		else
			$managerRendicionEstado->add($oRendicionEstado);
	}

	public function confirm(Entity $entity, $estado_oid, $motivo='') {

		$oid = $entity->getOid();


		$oRendicionManager = ManagerFactory::getRendicionManager();
		$oRendicion = $oRendicionManager->getObjectByCode($oid);
		$oEstado = new Estado();
		$oEstado->setOid($estado_oid);
		$this->cambiarEstado($oRendicion, $oEstado, $motivo);

		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oRendicion->getSolicitud()->getOid());

		switch ($estado_oid) {
			case CYT_ESTADO_SOLICITUD_ADMITIDA:
				$ds_subjet = CYT_LBL_RENDICION_ADMISION;
				$ds_comment = CYT_LBL_RENDICION_ADMISION_COMMENT;
				$oEstado = new Estado();
				$oEstado->setOid(CYT_ESTADO_SOLICITUD_RENDIDA);
				$oSolicitudManager->cambiarEstado($oSolicitud, $oEstado, $motivo);
				break;
			case CYT_ESTADO_SOLICITUD_CREADA:
				$ds_subjet = CYT_LBL_RENDICION_NO_ADMISION;
				$ds_comment = '<strong>'.htmlspecialchars(CYT_LBL_RENDICION_NO_ADMISION_COMMENT).'</strong>: '.htmlspecialchars($motivo);
				break;

		}


		$msg = $ds_subjet.CYT_LBL_RENDICION_MAIL_SUBJECT;

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

}
?>
