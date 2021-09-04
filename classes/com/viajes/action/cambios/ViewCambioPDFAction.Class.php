<?php

/**
 * Acción para exportar a pdf un cambio.
 *
 * @author Marcos
 * @since 10-06-205
 *
 */
class ViewCambioPDFAction extends CdtAction{

	
	/**
	 * (non-PHPdoc)
	 * @see CdtAction::execute()
	 */
	public function execute(){

		//armamos el pdf con la data necesaria.
		$pdf = new ViewCambioPDF();
		
		
		
		$oid = CdtUtils::getParam('id');
		
		$oCambioManager = ManagerFactory::getCambioManager();
		$oCambio = $oCambioManager->getObjectByCode($oid);
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cambio_oid', $oCambio->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerCambioEstado =  ManagerFactory::getCambioEstadoManager();
		$oCambioEstado = $managerCambioEstado->getEntity($oCriteria);
		$pdf->setEstado_oid($oCambioEstado->getEstado()->getOid());
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oCambio->getSolicitud()->getOid());
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
		
		$pdf->Output();

		//para que no haga el forward.
		$forward = null;

		return $forward;
	}


}