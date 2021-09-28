<?php

/**
 * Acción para exportar a pdf un rendicion.
 *
 * @author Marcos
 * @since 28-09-2021
 *
 */
class ViewRendicionPDFAction extends CdtAction{

	
	/**
	 * (non-PHPdoc)
	 * @see CdtAction::execute()
	 */
	public function execute(){

		//armamos el pdf con la data necesaria.
		$pdf = new ViewRendicionPDF();
		
		
		
		$oid = CdtUtils::getParam('id');
		
		$oRendicionManager = ManagerFactory::getRendicionManager();
		$oRendicion = $oRendicionManager->getObjectByCode($oid);
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('rendicion_oid', $oRendicion->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerRendicionEstado =  ManagerFactory::getRendicionEstadoManager();
		$oRendicionEstado = $managerRendicionEstado->getEntity($oCriteria);
		$pdf->setEstado_oid($oRendicionEstado->getEstado()->getOid());
		$oSolicitudManager = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($oRendicion->getSolicitud()->getOid());
		$pdf->setPeriodo_oid($oSolicitud->getPeriodo()->getOid());
		
		
		$oPeriodoManager =  CYTSecureManagerFactory::getPeriodoManager();
		$oPeriodo = $oPeriodoManager->getObjectByCode($oSolicitud->getPeriodo()->getOid());
		$pdf->setYear($oPeriodo->getDs_periodo());
		
		
		
		
		$pdf->setDs_investigador($oSolicitud->getDocente()->getDs_apellido().', '.$oSolicitud->getDocente()->getDs_nombre());
		$pdf->setNu_cuil($oSolicitud->getDocente()->getNu_precuil().'-'.$oSolicitud->getDocente()->getNu_documento().'-'.$oSolicitud->getDocente()->getNu_postcuil());
		
		$pdf->setDs_observacion($oRendicion->getDs_observacion());
		
		

		
			
		$pdf->setFacultadplanilla_oid($oSolicitud->getFacultadplanilla()->getOid());
		
		
	
    	($oSolicitud->getFacultadplanilla()->getOid() != CYT_FACULTAD_NO_DECLARADA)?$pdf->setDs_facultadplanilla($oSolicitud->getFacultadplanilla()->getDs_facultad()):$pdf->setDs_facultadplanilla(CYT_MSG_SOLICITUD_UNIVERSIDAD);;
		

    	
		$pdf->title = CYT_MSG_RENDICION_PDF_TITLE;
		$pdf->SetFont('Arial','', 13);
		
		// establecemos los márgenes
		$pdf->SetMargins(10, 20 , 10);
		$pdf->setMaxWidth($pdf->w - $pdf->lMargin - $pdf->rMargin);
		//$pdf->SetAutoPageBreak(true,90);
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		//imprimimos la solicitud.
		$pdf->printRendicion();
		
		$pdf->Output();

		//para que no haga el forward.
		$forward = null;

		return $forward;
	}


}