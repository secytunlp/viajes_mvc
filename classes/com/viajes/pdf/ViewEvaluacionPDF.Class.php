<?php

/**
 * PDF de EvaluaciÃƒÂ³n
 * 
 * @author Marcos
 * @since 04/12/2103
 */
class ViewEvaluacionPDF extends CdtPDFPrint{
	
	private $maxWidth = "";	

	private $evaluacion_oid = "";
	private $categoria_oid = "";
	private $periodo_oid = "";
	private $motivo_oid = "";
	private $estado_oid = "";
	private $facultadplanilla_oid = "";
	private $year = "";
	private $ds_investigador = "";
	
	private $ds_motivo = "";
	private $ds_facultadplanilla = "";	
		
	private $modeloPlanilla;	
	private $observacion = "";
		
	private $ds_evaluador = "";	
	
		
		
	  
	public function __construct(){
		
		parent::__construct();
		
	}
	
/**
	 * (non-PHPdoc)
	 * @see CdtPDFPrint#Header()
	 */
	function Header(){
		
		$this->SetTextColor(100, 100, 100);
		/*$this->SetDrawColor(1,1,1);
		$this->SetLineWidth(.1);*/
		$this->SetFont('Arial','B',36);
		if ($this->getEstado_oid()!=CYT_ESTADO_SOLICITUD_EVALUADA) {
			$this->RotatedText($this->lMargin, $this->h - 10, $this->encodeCharacters('      '.CYT_MSG_EVALUACION_PDF_PRELIMINAR_TEXT.'       '.CYT_MSG_EVALUACION_PDF_PRELIMINAR_TEXT), 60);
		}
			
		
		$this->SetY(3);
		
		$this->SetTextColor(0, 0, 0);
		$this->Image(APP_PATH . 'css/images/unlp.jpg',12,12,15,15);
	
		$this->SetFont ( 'Arial', '', 11 );
		
		$this->ln(7);
		$this->Cell ( $this->getMaxWidth()-170, 10, "", '',0,'L');
		$this->Cell ( $this->getMaxWidth()-70, 10, $this->encodeCharacters(CYT_MSG_SOLICITUD_PDF_HEADER_TITLE)." ".$this->getYear()."-".($this->getYear()+1), '',0,'L');
		
		$this->Cell ( $this->getMaxWidth()-150, 10, CYT_MSG_EVALUACION_PDF_MOTIVO, '',0,'C');
		$this->ln(4);
		$this->Cell ( $this->getMaxWidth()-170, 10, "", '',0,'L');
		$this->Cell ( $this->getMaxWidth()-70, 10, $this->encodeCharacters(CYT_MSG_SOLICITUD_PDF_HEADER_TITLE_2), '',0,'L');
		$this->Cell ( $this->getMaxWidth()-150, 10, "", '',0,'C');
		$this->ln(4);
		
		
		
		$this->Cell ( $this->getMaxWidth()-170, 10, "", '',0,'L');
		$this->Cell ( $this->getMaxWidth()-70, 10, CYT_MSG_EVALUACION_PDF_HEADER_TITLE, '',0,'L');
		$this->SetFont ( 'Arial', '', 15 );
		$this->Cell ( $this->getMaxWidth()-150, 10, $this->encodeCharacters($this->getDs_motivo()), 'LRTB',0,'C');
		$this->SetFont ( 'Arial', '', 11 );
		
		$this->ln(13);
		$this->NyAp();
		$this->ln(10);
		
		//Line break
		//$this->Ln(15);
	}
	
	
	function NyAp() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-95, 8, CYT_LBL_DOCENTE_APELLIDO_NOMBRE.": ".$this->encodeCharacters($this->getDs_investigador()), 'LTBR',0,'L',1);
		
		$this->Cell ( $this->getMaxWidth()-99, 8, CYT_LBL_DOCENTE_FACULTAD.": ".$this->encodeCharacters($this->getDs_facultadplanilla()), 'LTBR',0,'L',1);
		
	}
	
	function printEvaluacion(  ){
		$total = 0;
		$this->separadorNegro(CYT_MSG_EVALUACION_SEPARADOR_NEGRO_1_1,CYT_MSG_EVALUACION_SEPARADOR_NEGRO_1_2,CYT_MSG_EVALUACION_SEPARADOR_NEGRO_1_3);
		
		
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $this->getModeloPlanilla()->getOid(), '=');
		$oCategoriaMaximoManager =  ManagerFactory::getCategoriaMaximoManager();
		$categorias = $oCategoriaMaximoManager->getEntities($oCriteria);
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_evaluacion', $this->getEvaluacion_oid(), '=');
		$oPuntajeCategoriaManager =  ManagerFactory::getPuntajeCategoriaManager();
		$oPuntajecategoria = $oPuntajeCategoriaManager->getEntity($oCriteria);
		
		
		$nu_puntaje='0,00';
		$nu_puntaje1=0;
		$ds_categoria = array();
		
		foreach ($categorias as $oCategoriaMaximo) {
			IF (($oPuntajecategoria)&&($oPuntajecategoria->getCategoriaMaximo()->getOid())==$oCategoriaMaximo->getOid()){
				$nu_puntaje=number_format($oCategoriaMaximo->getNu_max(), CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES);
				$nu_puntaje1=$oCategoriaMaximo->getNu_max();
				$seleccionado=1;
			}
			else $seleccionado=0;
			
			$ds_categoria[] =array('descripcion'=>' '.$oCategoriaMaximo->getCategoria()->getDs_categoria().' ('.$oCategoriaMaximo->getNu_max().CYT_MSG_EVALUACION_PT.')','seleccionado'=>$seleccionado);
		
		}	
		$total+=$nu_puntaje1;
		$this->categoria(CYT_MSG_EVALUACION_CATEGORIA,$ds_categoria , CYT_MSG_EVALUACION_MAX.' '.$categorias->getObjectByIndex(1)->getNu_max().CYT_MSG_EVALUACION_PT.' ', $nu_puntaje);
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $this->getModeloPlanilla()->getOid(), '=');
		$oCargoMaximoManager =  ManagerFactory::getCargoMaximoManager();
		$cargos = $oCargoMaximoManager->getEntities($oCriteria);
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_evaluacion', $this->getEvaluacion_oid(), '=');
		$oPuntajeCargoManager =  ManagerFactory::getPuntajeCargoManager();
		$oPuntajecargo = $oPuntajeCargoManager->getEntity($oCriteria);
		
		
		 $ds_cargo = array();
		 $nu_puntaje='0,00';
		 $nu_puntaje1=0;
		 foreach ($cargos as $oCargoMaximo) {
		 	IF (($oPuntajecargo)&&($oPuntajecargo->getCargomaximo()->getOid()==$oCargoMaximo->getOid())){
					$nu_puntaje=number_format($oCargoMaximo->getNu_max(), CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES);
					$nu_puntaje1=$oCargoMaximo->getNu_max();
		 	}
		 }
		for($i = 0; $i < $cargos->size(); $i ++) {
			
			for($j = 0; $j < 2; $j ++) {	
				IF (($oPuntajecargo)&&($oPuntajecargo->getCargomaximo()->getOid()==$cargos->getObjectByIndex($i+$j)->getOid())){
					//$nu_puntaje=FuncionesComunes::Format_toDecimal($cargos[$i+$j]['nu_max']);
					$seleccionado=1;
				}
				else $seleccionado=0;
				$ds_cargo[] =array('descripcion'=>$cargos->getObjectByIndex($i+$j)->getCargoPlanilla()->getDs_cargoplanilla().' ('.$cargos->getObjectByIndex($i+$j)->getNu_max().CYT_MSG_EVALUACION_PT.')','seleccionado'=>$seleccionado);
			}
			$i++;
			switch ( $i) {
				case '1' :
					$cargo = "";
					$negrita='';
					$bordes1='LTR';
					
					$punt='';
				break;
				case '3' :
					$cargo = CYT_MSG_EVALUACION_CARGO;
					$negrita='';
					$bordes1='LR';
					
					$punt='';
				break;
				case '5' :
					$cargo = CYT_MSG_EVALUACION_CARGO_ACTUAL;
					$negrita='';
					$bordes='LR';
					$punt=$nu_puntaje;
				break;
				case '7' :
					$cargo = CYT_MSG_EVALUACION_MAX.' '.$cargos->getObjectByIndex(0)->getNu_max().CYT_MSG_EVALUACION_PT;
					$negrita='B';
					$bordes='LR';
					$punt='';
				break;
				case '9' :
					$cargo = "";
					
					$negrita='';
					$bordes1='LBR';
					
					$punt='';
				break;
				default :
					$cargo = "";
					$negrita='';
					$bordes1='LR';
					
					$punt='';
				break;
			}
			$this->cargo($cargo,$ds_cargo , $punt, $negrita, $bordes1);	
			$ds_cargo = array();
			
		}	
		$total+=$nu_puntaje1;
		$this->separarcant();
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $this->getModeloPlanilla()->getOid(), '=');
		$oCriteria->addOrder('itemplanilla.nu_orden');
		$oCriteria->addOrder('itemplanilla.cd_itemplanilla');
		$oItemMaximoManager =  ManagerFactory::getItemMaximoManager();
		$items = $oItemMaximoManager->getEntities($oCriteria);
		
		
		$ds_titulo=(!in_array($this->getModeloPlanilla()->getOid(),explode(",",CYT_MODELO_PLANILLA_C)))?'':' '.CYT_MSG_EVALUACION_CV_SOLICITANTE;
		
		
		$submax=0;
		$max=0;
		$itemSub=0;
		$subpuntaje=0;
		$iteradores = explode(",",CYT_MODELO_PLANILLA_ITERADORES);
		$arrayIteradores = array();
		foreach ($iteradores as $claveValor) {
			$divisor = explode("=>",$claveValor);
			$arrayIteradores[$divisor[0]]=$divisor[1];
		}
		$itemiterador = $arrayIteradores[$this->getModeloPlanilla()->getOid()];
		
		$iteradores = explode(",",CYT_MODELO_PLANILLA_ITERADORES_2);
		$arrayIteradores = array();
		foreach ($iteradores as $claveValor) {
			$divisor = explode("=>",$claveValor);
			$arrayIteradores[$divisor[0]]=$divisor[1];
		}
		$itemiterador2 = $arrayIteradores[$this->getModeloPlanilla()->getOid()];
		$totalItem =0;
		 for($i = 0; $i < $itemiterador; $i ++) {	
			
			if ($submax!=$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid()){
				$max +=$items->getObjectByIndex($i)->getPuntajeGrupo()->getNu_max();
				if ($i!=0){
					$itemSub++;
					$ds_texto1 = ($itemSub==1)?$this->encodeCharacters(CYT_MSG_EVALUACION_5_YEARS).' '.$ds_titulo:'';
					$subpuntaje += ($oPuntajeitem)?$oPuntajeitem->getNu_puntaje():0;
					$subpuntaje = ($subpuntaje>$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max())?$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max():$subpuntaje;
					$totalItem+=$subpuntaje;
					$this->subtotal($ds_texto1,CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')', number_format($subpuntaje, CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES), '','LR');	
					$subpuntaje=0;	
				}
				
				$submax=$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid();
			}
			else{
				$subpuntaje += ($oPuntajeitem)?$oPuntajeitem->getNu_puntaje():0;
			}
		 	$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_evaluacion', $this->getEvaluacion_oid(), '=');
			$oCriteria->addFilter('cd_itemmaximo', $items->getObjectByIndex($i)->getOid(), '=');
			$oPuntajeItemManager =  ManagerFactory::getPuntajeItemManager();
			$oPuntajeitem = $oPuntajeItemManager->getEntity($oCriteria);
			
			$nu_cant = (($oPuntajeitem)&&($oPuntajeitem->getNu_cantidad()))?$oPuntajeitem->getNu_cantidad():'';
			$nu_puntaje = (($oPuntajeitem)&&($oPuntajeitem->getNu_puntaje()))?number_format($oPuntajeitem->getNu_puntaje(), CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES):'';
			if($items->getObjectByIndex(0)->getPuntajeGrupo()->getCd_grupopadre()){
				$oPuntajeGrupoManager =  ManagerFactory::getPuntajeGrupoManager();
				$oPuntajeGrupo = $oPuntajeGrupoManager->getObjectByCode($items->getObjectByIndex(0)->getPuntajeGrupo()->getCd_grupopadre());
				$maximo = $oPuntajeGrupo->getNu_max();
				
			}
			else{
				$maximo = ($max+$items->getObjectByIndex(7)->getPuntajeGrupo()->getNu_max());
			}
			switch ( $i) {
				case '0' :
					$ds_texto = "";
					$negrita='';
					$bordes='LTR';
				break;
				case $itemiterador-5 :
					$ds_texto = CYT_MSG_EVALUACION_PROD_ULTIMOS;
					$negrita='';
					$bordes='LR';
				break;
				case $itemiterador-4 :
					$ds_texto = CYT_MSG_EVALUACION_MAX.' '.$maximo.CYT_MSG_EVALUACION_PT.' ';
					$negrita='B';
					$bordes='LR';
				break;
				
				case $itemiterador :
					$ds_texto = "";
					$negrita='';
					$bordes='LBR';
				break;
				default:
					$ds_texto = "";
					$negrita='';
					$bordes='LR';
				break;
			}
			
			$hasta = ($items->getObjectByIndex($i)->getNu_min())?$items->getObjectByIndex($i)->getNu_max():CYT_MSG_EVALUACION_HASTA.' '.$items->getObjectByIndex($i)->getNu_max();
			$this->produccion($this->encodeCharacters($ds_texto), $this->encodeCharacters($items->getObjectByIndex($i)->getItemPlanilla()->getDs_itemplanilla()), $hasta.' '.CYT_MSG_EVALUACION_C_U, $nu_cant, $nu_puntaje, $negrita, $bordes);	
			
			
			
		}	
		$subpuntaje += ($oPuntajeitem)?$oPuntajeitem->getNu_puntaje():0; 
	    $subpuntaje = ($subpuntaje>$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max())?$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max():$subpuntaje;
	    $totalItem+=$subpuntaje;
	    $ds_texto1 = '';
	    $this->subtotal($ds_texto1,CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')', number_format($subpuntaje, CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES), '','LBR');	
		if($items->getObjectByIndex(0)->getPuntajeGrupo()->getCd_grupopadre()){
			$totalSub = ($totalItem>$maximo)?$maximo:$totalItem;
			$this->subtotal($ds_texto1,CYT_MSG_EVALUACION_SUBTOTAL.' '.CYT_MSG_EVALUACION_PROD_ULTIMOS.' '.$this->encodeCharacters(CYT_MSG_EVALUACION_5_YEARS).'('.CYT_MSG_EVALUACION_MAX.' '.$maximo.')', number_format($totalSub, CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES), '','LBR');	
		}
		
		$total += $totalSub;
		
	   $this->separarcant();
		$submax=0;
		$max=0;
		$itemSub=0;
		$subpuntaje=0;
		$totalItem =0;
		 for($i = $itemiterador; $i < $itemiterador2; $i ++) {	
			
			if ($submax!=$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid()){
				$max +=$items->getObjectByIndex($i)->getPuntajeGrupo()->getNu_max();
				if ($i!=$itemiterador){
					$itemSub++;
					$ds_texto1 = ($itemSub==1)?CYT_MSG_EVALUACION_FORMACION:'';
					$subpuntaje += ($oPuntajeitem)?$oPuntajeitem->getNu_puntaje():0;
					$subpuntaje = ($subpuntaje>$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max())?$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max():$subpuntaje;
					$total+=$subpuntaje;
					$totalItem+=$subpuntaje;
					$this->subtotal($ds_texto1,CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')', number_format($subpuntaje, CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES), '','LR');	
					$subpuntaje=0;	
				}
				
				$submax=$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid();
			}
			else{
				$subpuntaje += ($oPuntajeitem)?$oPuntajeitem->getNu_puntaje():0;
			}
		 	$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_evaluacion', $this->getEvaluacion_oid(), '=');
			$oCriteria->addFilter('cd_itemmaximo', $items->getObjectByIndex($i)->getOid(), '=');
			$oPuntajeItemManager =  ManagerFactory::getPuntajeItemManager();
			$oPuntajeitem = $oPuntajeItemManager->getEntity($oCriteria);
			$nu_cant = (($oPuntajeitem)&&($oPuntajeitem->getNu_cantidad()))?$oPuntajeitem->getNu_cantidad():'';
			$nu_puntaje = (($oPuntajeitem)&&($oPuntajeitem->getNu_puntaje()))?number_format($oPuntajeitem->getNu_puntaje(), CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES):'';
			switch ( $i) {
				case  $itemiterador:
					$ds_texto = "";
					$negrita='';
					$bordes='LTR';
				break;
				case $itemiterador+1 :
					$ds_texto = CYT_MSG_EVALUACION_RR_HH;
					$negrita='';
					$bordes='LR';
				break;
				case $itemiterador+2 :
					$ds_texto = CYT_MSG_EVALUACION_MAX.' '.($max).CYT_MSG_EVALUACION_PT;
					$negrita='B';
					$bordes='LR';
				break;
				
				case '12' :
					$ds_texto = "";
					$negrita='';
					$bordes='LBR';
				break;
				
			}
			
			
			$hasta = ($items->getObjectByIndex($i)->getNu_min())?$items->getObjectByIndex($i)->getNu_max():CYT_MSG_EVALUACION_HASTA.' '.$items->getObjectByIndex($i)->getNu_max();
				
			$this->produccion($this->encodeCharacters($ds_texto), $this->encodeCharacters($items->getObjectByIndex($i)->getItemPlanilla()->getDs_itemplanilla()), $hasta.' '.CYT_MSG_EVALUACION_C_U, $nu_cant, $nu_puntaje, $negrita, $bordes);	
			
			
		}	
		$subpuntaje += ($oPuntajeitem)?$oPuntajeitem->getNu_puntaje():0; 
	    $subpuntaje = ($subpuntaje>$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max())?$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max():$subpuntaje;
	    $total+=$subpuntaje;
	    $totalItem+=$subpuntaje;
	    $ds_texto1 = '';
	    	
	    $this->subtotal($ds_texto1,CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')', number_format($subpuntaje, CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES), '','LBR');	
		
		$this->subtotal($ds_texto1,CYT_MSG_EVALUACION_SUBTOTAL.' '.CYT_MSG_EVALUACION_FORMACION.' '.$this->encodeCharacters(CYT_MSG_EVALUACION_RR_HH).'('.CYT_MSG_EVALUACION_MAX.' '.$max.')', number_format($totalItem, CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES), '','LBR');
	    $this->Ln(3);
		if (!in_array($this->getModeloPlanilla()->getOid(),explode(",",CYT_MODELO_PLANILLA_A))){
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_modeloplanilla', $this->getModeloPlanilla()->getOid(), '=');
			$oPlanMaximoManager =  ManagerFactory::getPlanMaximoManager();
			$plans = $oPlanMaximoManager->getEntities($oCriteria);
			
			
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_evaluacion', $this->getEvaluacion_oid(), '=');
			$oPuntajePlanManager =  ManagerFactory::getPuntajePlanManager();
			$oPuntajeplan = $oPuntajePlanManager->getEntity($oCriteria);
			
			
			$total+=($oPuntajeplan)?$oPuntajeplan->getNu_puntaje():0;
			$nu_puntaje = (($oPuntajeplan)&&($oPuntajeplan->getNu_puntaje()))?number_format($oPuntajeplan->getNu_puntaje(), CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES ):'';
			$ds_justificacion = (($oPuntajeplan)&&($oPuntajeplan->getDs_justificacion()))?$oPuntajeplan->getDs_justificacion():'';
			
			
			if (!in_array($this->getModeloPlanilla()->getOid(),explode(",",CYT_MODELO_PLANILLA_C))){
				$this->plan(CYT_MSG_EVALUACION_PLAN_TRABAJO,'',CYT_MSG_EVALUACION_MAX.' '.$plans->getObjectByIndex(0)->getNu_max().CYT_MSG_EVALUACION_PT.' ', $nu_puntaje,1);
			}
			else{
				$this->plan(CYT_MSG_EVALUACION_PLAN_TRABAJO,CYT_MSG_EVALUACION_CV_VISITANTE,CYT_MSG_EVALUACION_MAX.' '.$plans->getObjectByIndex(0)->getNu_max().CYT_MSG_EVALUACION_PT.' ', $nu_puntaje);
			}
			
		}
	    $oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $this->getModeloPlanilla()->getOid(), '=');
		$oCriteria->addOrder('eventoplanilla.nu_orden');
		$oCriteria->addOrder('eventoplanilla.cd_eventoplanilla');
		$oEventoMaximoManager =  ManagerFactory::getEventoMaximoManager();
		$eventos = $oEventoMaximoManager->getEntities($oCriteria);
	    
		$submax=0;
		$max=0;
		$subpuntaje=0;
		$justificaciones = array();
		 for($i = 0; $i < $eventos->size(); $i ++) {	
		
			
			if ($submax!=$eventos->getObjectByIndex($i)->getPuntajeGrupo()->getOid() ){
				$max +=$eventos->getObjectByIndex($i)->getPuntajeGrupo()->getNu_max();
				if ($i!=0){
					$subpuntaje += $oPuntajeevento->getNu_puntaje();
					$subpuntaje = ($subpuntaje>$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max())?$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max():$subpuntaje;
					$total+=$subpuntaje;
					//$this->subtotal('','Subtotal (max. '.$eventos[$i-1]['nu_maxgrupo'].')', $subpuntaje, '','LR');	
					$subpuntaje=0;	
				}
				$submax=$eventos->getObjectByIndex($i)->getPuntajeGrupo()->getOid();
			}
			else{
				$subpuntaje += (!empty($oPuntajeevento))?$oPuntajeevento->getNu_puntaje():0;
			}
			
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_evaluacion', $this->getEvaluacion_oid(), '=');
			$oCriteria->addFilter('cd_eventomaximo', $eventos->getObjectByIndex($i)->getOid(), '=');
			$oPuntajeEventoManager =  ManagerFactory::getPuntajeEventoManager();
			$oPuntajeevento = $oPuntajeEventoManager->getEntity($oCriteria);
			
			
			$nu_puntaje = (!empty($oPuntajeevento))?number_format($oPuntajeevento->getNu_puntaje(), CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES):'';
			if (($oPuntajeevento)&&($oPuntajeevento->getDs_justificacion())) {
				
				$titulo_justificacion = $this->encodeCharacters(CYT_MSG_EVALUACION_EVENTO_JUSTIFICACION_PDF).' '.substr($this->encodeCharacters($eventos->getObjectByIndex($i)->getEventoPlanilla()->getDs_eventoplanilla()), 0,57).'...';
				$justificaciones[$titulo_justificacion]=$oPuntajeevento->getDs_justificacion();
			}
			
			$hasta = ($eventos->getObjectByIndex($i)->getNu_min())?$eventos->getObjectByIndex($i)->getNu_max():CYT_MSG_EVALUACION_HASTA.' '.$eventos->getObjectByIndex($i)->getNu_max();
			switch ( $i) {
				case '0' :
					$ds_texto = "";
					$negrita='';
					$bordes='LTR';
				break;
				case '1' :
					$ds_texto = CYT_MSG_EVALUACION_MAX.' '.($max).CYT_MSG_EVALUACION_PT;
					$negrita='B';
					$bordes='LR';
				break;
				
				
				case $count :
					$ds_texto = "";
					$negrita='';
					$bordes='LBR';
				break;
				default :
					$ds_texto = "";
					$negrita='';
					$bordes='LR';
				break;
				
			}
			
		 	$this->evento($this->encodeCharacters($ds_texto), $this->encodeCharacters($eventos->getObjectByIndex($i)->getEventoPlanilla()->getDs_eventoplanilla()), $hasta, $nu_cant, $nu_puntaje, $negrita, $bordes);	
			
		}	
		$subpuntaje += (!empty($oPuntajeevento))?$oPuntajeevento->getNu_puntaje():0; 
	    $subpuntaje = ($subpuntaje>$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max())?$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max():$subpuntaje;
	    $total+=$subpuntaje;
	    $ds_texto1 = '';		
		$this->subtotal($ds_texto1,CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')', number_format($subpuntaje, CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES), '','LBR');
	    $this->Ln(3);
		
		$this->total(CYT_MSG_EVALUACION_TOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$this->getModeloplanilla()->getNu_max().')', number_format($total, CYT_DECIMALES , CYT_SEPARADOR_DECIMAL, CYT_SEPARADOR_MILES), '','LBR');	
		
		if ($ds_justificacion) {
			$this->Ln(3);
			$this->separadorNegro1(CYT_MSG_EVALUACION_PLAN_TRABAJO_JUSTIFICACION_PDF);
			$this->SetFont ( 'Arial', '', 8 );
			$this->MultiCell($this->getMaxWidth()-4,4,$this->encodeCharacters($ds_justificacion),'LTBR');
		}
		
		
		foreach ($justificaciones as $titulo => $justificacion) {
			$this->Ln(3);
			$this->separadorNegro1($titulo);
			$this->SetFont ( 'Arial', '', 8 );
			$this->MultiCell($this->getMaxWidth()-4,4,$this->encodeCharacters($justificacion),'LTBR');
		}
		
		$this->Ln(3);
		$this->separadorNegro(CYT_MSG_EVALUACION_OBSERVACIONES,'','');
		$this->SetFont ( 'Arial', '', 8 );
		$this->MultiCell($this->getMaxWidth()-4,4,$this->encodeCharacters($this->getObservacion()),'LTBR');
		$this->firma2();	
	}
	
	function separadorNegro1($ds_texto1) {
		
		$this->SetTextColor(255,255,255);
		$this->SetFillColor(0,0,0);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-4, 6, $ds_texto1,0,0,'L',1);
		
		$this->ln(6);
		$this->SetTextColor(0,0,0);
	}
	
	function separadorNegro($ds_texto1, $ds_texto2, $ds_texto3) {
		
		$this->SetTextColor(255,255,255);
		$this->SetFillColor(0,0,0);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-150, 6, $ds_texto1,0,0,'C',1);
		$this->Cell ( $this->getMaxWidth()-84, 6, $ds_texto2,0,0,'C',1);
		$this->Cell ( $this->getMaxWidth()-150, 6, $ds_texto3,0,0,'C',1);
		$this->ln(6);
		$this->SetTextColor(0,0,0);
	}
	
	function separarcant() {
		$this->SetFillColor(255,255,255);
		
		
		$this->cell ( $this->getMaxWidth()-34, 2, "", 'TBR',0,'L',1);
		
		$this->SetFont ( 'Arial', '', 8 );
		$this->cell ( $this->getMaxWidth()-180, 2, CYT_MSG_EVALUACION_CANT, 'LTBR',0,'R',1);
		
		
		$this->Cell ( $this->getMaxWidth()-170, 2, '', 'LTBR',0,'C',1);
		$this->ln();
	}
	
	function subtotal($ds_texto1, $ds_texto2, $nu_puntaje, $negrita, $bordes1) {
		$this->SetFillColor(225,225,225);
		
		$this->SetFont ( 'Arial', $negrita, 10 );
		$this->cell ( $this->getMaxWidth()-150, 6, $ds_texto1, $bordes1,0,'C',1);
		
		$this->SetFont ( 'Arial', '', 10 );
		$this->cell ( $this->getMaxWidth()-64, 6, $ds_texto2, 'LTBR',0,'R',1);
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-170, 6, $nu_puntaje, 'LTBR',0,'C',1);
		$this->ln(5);
	}
	
	function total($ds_texto1, $nu_puntaje) {
		$this->SetFillColor(255,255,255);
		
		$this->SetFont ( 'Arial', 'B',  12 );
		$this->cell ( $this->getMaxWidth()-24, 6, $ds_texto1, 'LTBR',0,'R',1);
		
		
		
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-170, 6, $nu_puntaje, 'LTBR',0,'C',1);
		$this->ln(5);
	}
		
	function plan($ds_texto1, $ds_texto2, $nu_max, $nu_puntaje, $bl_anexo=0) {
		$this->SetFillColor(225,225,225);
		$this->SetFont ( 'Arial', '', 10 );
		
		$this->cell ( $this->getMaxWidth()-150, 6, $ds_texto1, 'LTR',0,'C',1);
		$this->SetFillColor(255,255,255);
		$ds_anexo1 = ($bl_anexo)?CYT_MSG_EVALUACION_PLAN_TRABAJO_ANEXO_PDF_1:'';
		$this->SetFont ( 'Arial', '', 9 );
		$this->Cell ( $this->getMaxWidth()-64, 6, $this->encodeCharacters($ds_anexo1), 'LTR',0,'L',1);
		$this->SetFillColor(225,225,225);
		$puntaje=($ds_texto2)?'':$nu_puntaje;
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-170, 6, $puntaje, 'LTR',0,'C',1);
		$this->SetFont ( 'Arial', '', 10 );
		if ($ds_texto2){
			
			$this->ln(5);
			$this->cell ( $this->getMaxWidth()-150, 6, $this->encodeCharacters($ds_texto2), 'LR',0,'C',1);
			$this->SetFillColor(255,255,255);
			$this->Cell ( $this->getMaxWidth()-64, 6, "", 'LR',0,'L',1);
			$this->SetFillColor(225,225,225);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( $this->getMaxWidth()-170, 6, $nu_puntaje, 'LR',0,'C',1);
		}
		$this->ln(5);
		$this->SetFont ( 'Arial', 'B', 10 );
		
		$this->cell ( $this->getMaxWidth()-150, 6, $nu_max, 'LBR',0,'C',1);
		$this->SetFont ( 'Arial', '', 9 );
		$this->SetFillColor(255,255,255);
		$ds_anexo3 = ($bl_anexo)?CYT_MSG_EVALUACION_PLAN_TRABAJO_ANEXO_PDF_3:'';
		$this->Cell ( $this->getMaxWidth()-64, 6, $this->encodeCharacters($ds_anexo3), 'LBR',0,'L',1);
		$this->SetFillColor(225,225,225);
		
		$this->Cell ( $this->getMaxWidth()-170, 6, "", 'LBR',0,'C',1);
		
		
		
			$this->ln(8);
	}
	
	function categoria($ds_texto1, $categorias, $nu_max, $nu_puntaje) {
		$this->SetFillColor(225,225,225);
		$this->SetFont ( 'Arial', '', 10 );
		
		$this->cell ( $this->getMaxWidth()-150, 6, $ds_texto1, 'LTR',0,'C',1);
		$this->SetFillColor(255,255,255);
		$size = ($this->getMaxWidth()-64)/count($categorias);
		$desp=(count($categorias)==2)?9:2;
		foreach ($categorias as $categoria){
			
			$hor=intval($this->GetX()+$desp);
 			$ver=intval($this->GetY()+1);
 			$nombre_imagen=($categoria['seleccionado']==1)?APP_PATH . 'css/images/si.jpg':APP_PATH . 'css/images/no.jpg';
			$this->Image($nombre_imagen,$hor,$ver,5);
			$this->Cell ( $size, 6, $categoria['descripcion'], 'LTR',0,'C');
		}
		$this->SetFillColor(225,225,225);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-170, 6, $nu_puntaje, 'LTR',0,'C',1);
		
		$this->ln(5);
		$this->SetFont ( 'Arial', 'B', 10 );
		
		$this->cell ( $this->getMaxWidth()-150, 6, $nu_max, 'LBR',0,'C',1);
		$this->SetFillColor(255,255,255);
		$size = ($this->getMaxWidth()-64)/count($categorias);
		$this->SetFont ( 'Arial', '', 10 );
		foreach ($categorias as $categoria)
			$this->Cell ( $size, 6, "", 'LBR',0,'C',1);
		$this->SetFillColor(225,225,225);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-170, 6, "", 'LBR',0,'C',1);
		$this->ln(8);
	}
	
	function cargo($ds_texto1, $cargos, $nu_puntaje, $negrita, $bordes1) {
		$this->SetFillColor(225,225,225);
		
		$this->SetFont ( 'Arial', $negrita, 10 );
		$this->cell ( $this->getMaxWidth()-150, 6, $ds_texto1, $bordes1,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		foreach ($cargos as $cargo){
			$hor=intval($this->GetX()+1);
 			$ver=intval($this->GetY()+1);
 			$nombre_imagen=($cargo['seleccionado']==1)?APP_PATH . 'css/images/si.jpg':APP_PATH . 'css/images/no.jpg';
			$this->Image($nombre_imagen,$hor,$ver,5);
			$bordes2 = str_replace('R','',$bordes1);
			$this->Cell ( $this->getMaxWidth()-183, 6, "", $bordes2,0,'L');
			$bordes2 = str_replace('L','',$bordes1);
			$this->Cell ( $this->getMaxWidth()-134, 6, $cargo['descripcion'], $bordes2,0,'L');
		}
		$this->SetFillColor(225,225,225);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-170, 6, $nu_puntaje, $bordes1,0,'C',1);
		$this->ln(5);
	}
	
	function produccion($ds_texto1, $de_texto2, $hasta, $nu_cant, $nu_puntaje, $negrita, $bordes1) {
		$xpri=$this->GetX();
       	$ypri=$this->GetY();
		$this->SetFillColor(225,225,225);
		
		$this->SetFont ( 'Arial', $negrita, 10 );
		$this->cell ( $this->getMaxWidth()-150, 6, $ds_texto1, $bordes1,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 9 );
		$x=$this->GetX();
       	$y=$this->GetY();
		
		$this->MultiCell ( $this->getMaxWidth()-92, 4, $de_texto2, 'LTBR','L',1);
		$y1=$this->GetY();
		$this->SetXY($xpri,$ypri);
		$this->SetFillColor(225,225,225);
		
		$this->SetFont ( 'Arial', $negrita, 10 );
		$this->cell ( $this->getMaxWidth()-150, $y1-$y, $ds_texto1, $bordes1,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 9 );
		$this->SetXY($x+98,$y);
		
		$this->SetFont ( 'Arial', '', 8 );
		$this->cell ( $this->getMaxWidth()-172, $y1-$y, $hasta, 'LTBR',0,'R',1);
		$this->SetFont ( 'Arial', '', 10 );
		$this->cell ( $this->getMaxWidth()-180, $y1-$y, $nu_cant, 'LTBR',0,'R',1);
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-170, $y1-$y, $nu_puntaje, 'LTBR',0,'C',1);
		$this->Ln(($y1-$y));
		
			
	}
	
	function evento($ds_texto1, $de_texto2, $hasta, $nu_cant, $nu_puntaje, $negrita, $bordes1) {
		$xpri=$this->GetX();
       	$ypri=$this->GetY();
		$this->SetFillColor(225,225,225);
		
		$this->SetFont ( 'Arial', $negrita, 10 );
		$this->cell ( $this->getMaxWidth()-150, 6, $ds_texto1, $bordes1,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 9 );
		$x=$this->GetX();
       	$y=$this->GetY();
		$this->MultiCell ( $this->getMaxWidth()-82, 4, $de_texto2, 'LTBR','L',1);
		$y1=$this->GetY();
		$this->SetXY($xpri,$ypri);
		$this->SetFillColor(225,225,225);
		
		$this->SetFont ( 'Arial', $negrita, 10 );
		$this->cell ( $this->getMaxWidth()-150, $y1-$y, $ds_texto1, $bordes1,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 9 );
		$this->SetXY($x+108,$y);
		$this->SetFont ( 'Arial', '', 8 );
		$this->cell ( $this->getMaxWidth()-172, $y1-$y, $hasta, 'LTBR',0,'R',1);
		
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-170, $y1-$y, $nu_puntaje, 'LTBR',0,'C',1);
		$this->Ln(($y1-$y));
		
	}
	
	function firma2() {
		$this->ln(15);
		
		$this->SetFillColor(255,255,255);
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-180, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, '', 'B');
		$this->Cell ( $this->getMaxWidth()-160, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, $this->encodeCharacters($this->getDs_evaluador()), 'B', 0, 'C');
		$this->ln(8);
		$this->Cell ( $this->getMaxWidth()-180, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, CYT_MSG_EVALUACION_FIRMA, '', 0, 'C');
		$this->Cell ( $this->getMaxWidth()-160, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, $this->encodeCharacters(CYT_MSG_EVALUACION_ACLARACION), '', 0, 'C');
		
		
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtPDFPrint#Footer()
	 */
	function Footer(){
		
		$this->SetY(-15);
		
		
		$this->SetFont('Arial','I',8);

		$this->Cell(0,10,$this->encodeCharacters(CYT_MSG_SOLICITUD_PDF_PAGINA).' '.$this->PageNo().' '.CYT_MSG_SOLICITUD_PDF_PAGINA_DE.' {nb}',0,0,'C');
		
	}

	
	
	

	public function getMaxWidth()
	{
	    return $this->maxWidth;
	}

	public function setMaxWidth($maxWidth)
	{
	    $this->maxWidth = $maxWidth;
	}

	public function getCategoria_oid()
	{
	    return $this->categoria_oid;
	}

	public function setCategoria_oid($categoria_oid)
	{
	    $this->categoria_oid = $categoria_oid;
	}

	public function getPeriodo_oid()
	{
	    return $this->periodo_oid;
	}

	public function setPeriodo_oid($periodo_oid)
	{
	    $this->periodo_oid = $periodo_oid;
	}

	public function getMotivo_oid()
	{
	    return $this->motivo_oid;
	}

	public function setMotivo_oid($motivo_oid)
	{
	    $this->motivo_oid = $motivo_oid;
	}

	public function getEstado_oid()
	{
	    return $this->estado_oid;
	}

	public function setEstado_oid($estado_oid)
	{
	    $this->estado_oid = $estado_oid;
	}

	public function getFacultadplanilla_oid()
	{
	    return $this->facultadplanilla_oid;
	}

	public function setFacultadplanilla_oid($facultadplanilla_oid)
	{
	    $this->facultadplanilla_oid = $facultadplanilla_oid;
	}

	public function getYear()
	{
	    return $this->year;
	}

	public function setYear($year)
	{
	    $this->year = $year;
	}

	public function getDs_investigador()
	{
	    return $this->ds_investigador;
	}

	public function setDs_investigador($ds_investigador)
	{
	    $this->ds_investigador = $ds_investigador;
	}

	public function getDs_motivo()
	{
	    return $this->ds_motivo;
	}

	public function setDs_motivo($ds_motivo)
	{
	    $this->ds_motivo = $ds_motivo;
	}

	

	public function getDs_facultadplanilla()
	{
	    return $this->ds_facultadplanilla;
	}

	public function setDs_facultadplanilla($ds_facultadplanilla)
	{
	    $this->ds_facultadplanilla = $ds_facultadplanilla;
	}

	public function getModeloPlanilla()
	{
	    return $this->modeloPlanilla;
	}

	public function setModeloPlanilla($modeloPlanilla)
	{
	    $this->modeloPlanilla = $modeloPlanilla;
	}

	public function getEvaluacion_oid()
	{
	    return $this->evaluacion_oid;
	}

	public function setEvaluacion_oid($evaluacion_oid)
	{
	    $this->evaluacion_oid = $evaluacion_oid;
	}

	public function getObservacion()
	{
	    return $this->observacion;
	}

	public function setObservacion($observacion)
	{
	    $this->observacion = $observacion;
	}

	public function getDs_evaluador()
	{
	    return $this->ds_evaluador;
	}

	public function setDs_evaluador($ds_evaluador)
	{
	    $this->ds_evaluador = $ds_evaluador;
	}
}