<?php

/**
 * PDF de Solicitud
 * 
 * @author Marcos
 * @since 19/11/2103
 */
class ViewSolicitudPDF extends CdtPDFPrint{
	
	private $maxWidth = "";	

	private $categoria_oid = "";
	private $periodo_oid = "";
	private $motivo_oid = "";
	private $estado_oid = "";
	private $facultadplanilla_oid = "";
	private $year = "";
	private $ds_investigador = "";
	private $nu_cuil = "";
	private $ds_calle = "";
	private $nu_nro = "";
	private $nu_piso = "";
	private $ds_depto = "";
	private $nu_cp = "";
	private $ds_mail = "";
	private $ds_googleScholar = "";
	private $nu_telefono = "";
	private $bl_notificacion = "";
	private $ds_titulogrado = "";
	private $ds_lugarTrabajo = "";
	private $ds_lugarTrabajoDireccion = "";
	private $ds_lugarTrabajoTelefono = "";
	private $ds_cargo = "";
	private $ds_deddoc = "";
	private $ds_facultad = "";
	private $ds_facultadplanilla = "";
	private $bl_becario = "";
	private $bl_carrera = "";
	private $ds_tipobeca = "";
  	private $ds_orgbeca = "";
  	private $ds_lugarTrabajoBeca = "";	
  	private $ds_periodobeca = "";
  	private $ds_resumenbeca = "";
  	private $ds_carrerainv = "";	
	private $ds_organismo = "";	
	private $ds_lugarTrabajoCarrera = "";	
	private $dt_ingreso = "";	
	private $ds_categoria = "";	
	private $ds_tipoInvestigador= "";	
	private $proyectos;	
	private $proyectosNoSeleccionados;	
	private $ambitos;	
	private $ds_objetivo= "";
	private $nu_monto= "";
	private $montosOrganismos;	
	private $ds_motivo= "";	
	private $bl_congreso= "";
	private $ds_titulotrabajo= "";
	private $ds_autorestrabajo= "";
	private $ds_congreso= "";
	private $ds_lugardeltrabajo= "";
	private $dt_fechatrabajo= "";
	private $dt_fechatrabajohasta= "";
	private $ds_resumentrabajo= "";
	private $ds_relevanciatrabajo= "";
	private $ds_modalidadtrabajo= "";
	private $bl_nacional= "";
	private $ds_profesor = "";
	private $ds_lugarprofesor = ""; 
	 private $ds_libros = ""; 
	  private $ds_compilados = ""; 
	  private $ds_capitulos = ""; 
	  private $ds_articulos = ""; 
	  private $ds_congresos = ""; 
	  private $ds_patentes = ""; 
	  private $ds_intelectuales = ""; 
	  private $ds_informes = ""; 
	 
	  private $ds_tesis = ""; 
	  private $ds_tesinas = ""; 
	  private $ds_becas= ""; 
	  
	private $ds_objetivoC= ""; 
	  private $ds_planC= ""; 
	  private $ds_relacionProyectoC= "";
	private $ds_aportesC= ""; 
	private $ds_actividadesC= ""; 
	private $ds_generalB= ""; 
	private $ds_especificoB= ""; 
	private $ds_actividadesB= ""; 
	private $ds_cronogramaB= "";
	private $ds_justificacionB= ""; 
	private $ds_aportesB= ""; 
	private $ds_relevanciaB= "";
	private $ds_relevanciaA= "";
	private $presupuestos= ""; 
	  
	public function __construct(){
		
		parent::__construct();
		$this->setProyectos(new ItemCollection());
		$this->setProyectosNoSeleccionados(new ItemCollection());
		$this->setAmbitos(new ItemCollection());
		$this->setMontosOrganismos(new ItemCollection());
		$this->setPresupuestos(new ItemCollection());
	}
	
	function printSolicitud(  ){
		$this->NyAp();
		$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_DOMICILIO));
		$this->domicilio();
		$this->mail();
		
		if ($this->getYear() > 2012 ) {
			$ds_notificacion=($this->getBl_notificacion())?CDT_UI_LBL_YES:CDT_UI_LBL_NO;
			
			$ds_notificacion = CYT_MSG_SOLICITUD_RECIBIR_POR_MAIL.$ds_notificacion;
			$this->MultiCell( $this->getMaxWidth(), 4, utf8_decode($ds_notificacion));
		}
		if ($this->getYear() > 2018 ) {
			$this->SetFillColor(255,255,255);
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell ( $this->getMaxWidth()-140, 8, utf8_decode(CYT_LBL_SOLICITUD_GOOGLESCHOLAR_PDF).":");
			$this->SetFillColor(225,225,225);
			//$this->MultiCell( $this->getMaxWidth()-60, 4, utf8_decode($this->getDs_googleScholar()), 'LTBR','L',1);
			$this->Cell ( $this->getMaxWidth()-50, 8, utf8_decode($this->getDs_googleScholar()), 'LTBR',0,'L',1);
			$this->ln(10);
		}
		$this->titulo();
		$this->unidad();
		$this->cargo();
		if ($this->getBl_becario()){
			$this->separador(CYT_MSG_SOLICITUD_BECARIO);
			$this->becario();	
		} 
		if ($this->getBl_carrera()){
			$this->separador(CYT_MSG_SOLICITUD_INVESTIGADOR_CARRERA);
			$this->carrera();	
		} 
		$this->categoria();
		if($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2016)) {
			$this->separador(CYT_MSG_SOLICITUD_PROYECTO_SELECCIONADO);
			foreach ($this->getProyectos() as $thisProyecto) {
				$this->proyecto($thisProyecto->getProyecto()->getDs_titulo(), $thisProyecto->getDirector()->getDs_apellido().', '.$thisProyecto->getDirector()->getDs_nombre(), $thisProyecto->getProyecto()->getDs_codigo(), CYTSecureUtils::formatDateToView($thisProyecto->getDt_alta()), CYTSecureUtils::formatDateToView($thisProyecto->getDt_baja()), $thisProyecto->getEstado()->getDs_estado(), $thisProyecto->getProyecto()->getDs_abstract1());
			}
			if ($this->getProyectosNoSeleccionados()->size()>0) {
				$this->separador(CYT_MSG_SOLICITUD_PROYECTOS_OTROS);
				foreach ($this->getProyectosNoSeleccionados() as $thisProyecto) {
					$this->proyecto($thisProyecto->getProyecto()->getDs_titulo(), $thisProyecto->getDirector()->getDs_apellido().', '.$thisProyecto->getDirector()->getDs_nombre(), $thisProyecto->getProyecto()->getDs_codigo(), CYTSecureUtils::formatDateToView($thisProyecto->getDt_alta()), CYTSecureUtils::formatDateToView($thisProyecto->getDt_baja()), $thisProyecto->getEstado()->getDs_estado(), $thisProyecto->getProyecto()->getDs_abstract1(), 8);
				}
			}
		}
		else{
			$this->separador(CYT_MSG_SOLICITUD_PROYECTOS_ACTUALES);
			foreach ($this->getProyectosNoSeleccionados() as $thisProyecto) {
					$this->proyecto($thisProyecto->getProyecto()->getDs_titulo(), $thisProyecto->getDirector()->getDs_apellido().', '.$thisProyecto->getDirector()->getDs_nombre(), $thisProyecto->getProyecto()->getDs_codigo(), CYTSecureUtils::formatDateToView($thisProyecto->getDt_alta()), CYTSecureUtils::formatDateToView($thisProyecto->getDt_baja()), $thisProyecto->getEstado()->getDs_estado(), $thisProyecto->getProyecto()->getDs_abstract1(), 8);
				}
		}
		
		
		if($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2016)) {
			switch ($this->getMotivo_oid()) {
				case 1:
				  $this->separador(CYT_MSG_SOLICITUD_AMBITOS_A);
				break;
				case 2:
				  $this->separador(CYT_MSG_SOLICITUD_AMBITOS_B);
				break;
				case 3:
				  $this->separador(CYT_MSG_SOLICITUD_AMBITOS_C);
				break;
				
			}
		}
		else{
			$this->separador(CYT_MSG_SOLICITUD_AMBITOS);
		}
		$this->Ambitos();
		if ($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2011)) {
			if($this->getPeriodo_oid()==intval(CYT_SOLICITUD_PERIODO_2012)) {
				$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO);
				$this->Ln(-5);
				$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO_2);
				$this->Ln(-5);
				$this->texto($this->getDs_objetivo());
			}
			
		}
		ELSE{
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO_3);
			$this->texto($this->getDs_objetivo());
		}
		$this->monto();
		$this->separador(CYT_MSG_SOLICITUD_PDF_MONTO_OTRO_ORGANISMO.':');
		$this->Montos();
		
		$this->separadorNegro(utf8_decode($this->getDs_motivo()));
		if ($this->getMotivo_oid()==CYT_MOTIVO_A) {
			if ($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2012)) {
				if ($this->getPeriodo_oid()<intval(CYT_SOLICITUD_PERIODO_2017)) {
					$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO);
					$this->Ln(-5);
				
					$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_OTRA_ACTIVIDAD);
					$this->Ln(-5);
				}
				else{
					$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_OBJETIVO_2017);
					$this->Ln(-5);
				}
				$this->texto($this->getDs_objetivo());
				if ($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2016)) {
					$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_RELEVANCIA);
					$this->Ln(-5);
					$this->texto($this->getDs_relevanciaA());
				}
				
			}
			$this->motivoA();
		}
		if ($this->getMotivo_oid()==CYT_MOTIVO_C) {
			$this->motivoC();
		}
		if ($this->getPeriodo_oid()==CYT_SOLICITUD_PERIODO_2012) {
			$this->separadorM((CYT_MSG_SOLICITUD_SEPARADOR_PRODUCCION), 'B');
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_LIBROS_AUTORIAS);
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_AUTOR));
			$this->texto($this->getDs_libros());
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_LIBROS_COMPILACIONES);
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_COMPILADOR));
			$this->texto($this->getDs_compilados());
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_CAPITULOS);
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_CAPITULOS_AUTORES));
			$this->texto($this->getDs_capitulos());
			
			$ds_referato = ((in_array($this->getCategoria_oid(), explode(",",CYT_CATEGORIA_FORMADOS))) && ($this->getMotivo_oid()==CYT_MOTIVO_A))?CYT_MSG_SOLICITUD_SEPARADOR_REFERATO_1:CYT_MSG_SOLICITUD_SEPARADOR_REFERATO_2;
			$ponerReferato = ((in_array($this->getCategoria_oid(), explode(",",CYT_CATEGORIA_NO_FORMADOS))) && ($this->getMotivo_oid()==CYT_MOTIVO_A))?CYT_MSG_SOLICITUD_SEPARADOR_REFERATO_3:'';
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_ARTICULOS.' ('.strtoupper($ds_referato).')');
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_ARTICULOS_AUTORES_1.$ponerReferato.CYT_MSG_SOLICITUD_SEPARADOR_ARTICULOS_AUTORES_2));
			$this->texto($this->getDs_articulos());
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_CONGRESOS);
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_CONGRESOS_AUTORES));
			$this->texto($this->getDs_congresos());
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_PATENTES);
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_PATENTES_AUTORES));
			$this->texto($this->getDs_patentes());
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_INTELECTUAL);
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_INTELECTUAL_TIPO));
			$this->texto($this->getDs_intelectuales());
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_TECNICO);
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_TECNICO_AUTORES));
			$this->texto($this->getDs_informes());
			$this->separadorM((CYT_MSG_SOLICITUD_SEPARADOR_RRHH), 'B');
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_DIR_TESIS);
			$this->separador((CYT_MSG_SOLICITUD_SEPARADOR_DIR_TESIS_DATOS));
			$this->texto($this->getDs_tesis());
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_DIR_BECAS);
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_DIR_BECAS_DATOS);
			$this->texto($this->getDs_becas());
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_DIR_TESINAS);
			$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_DIR_TESINAS_DATOS);
			$this->texto($this->getDs_tesinas());
		}
		if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2012) {
			if ($this->getMotivo_oid()==CYT_MOTIVO_B) {
				$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO.':', 'B');
				$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_1);
				
				$this->texto($this->getDs_generalB());
				
				
				$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_2);
				$this->texto($this->getDs_especificoB());
				
				

				if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2016) {
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_3_2017);
					$this->texto($this->getDs_actividadesB());
				}
				else{
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_3);
					$this->texto($this->getDs_actividadesB());
				}
				
				
				
				$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_4);
				$this->texto($this->getDs_cronogramaB());
				if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2017) {
					$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_5_2018);
					$this->Ln(-5);
					$this->texto($this->getDs_justificacionB());
				}
				
				if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2016) {
					if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2017) {
						$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_6_2018);
						$this->Ln(-5);
						$this->texto($this->getDs_aportesB());
					}
					else{
						$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_5_2017);
						$this->Ln(-5);
						$this->texto($this->getDs_aportesB());
					}
				}
				else{
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_5);
					$this->texto($this->getDs_aportesB());
				}
				
				if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2016) {
					if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2017) {
						$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_7);
					
						$this->texto($this->getDs_relevanciaB());
					}
					else{
						$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_B_PLAN_TRABAJO_6);
				
						$this->texto($this->getDs_relevanciaB());
					}
				}
				
			}
			if ($this->getMotivo_oid()==CYT_MOTIVO_C) {
				$this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO.':', 'B');
				$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_1);
				$this->texto($this->getDs_objetivoC());
				if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2016) {
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_2_2017);				
					$this->texto($this->getDs_planC());
				}
				else{
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_2);				
					$this->texto($this->getDs_planC());
				}
				if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2016) {
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_3_2017);				
					$this->texto($this->getDs_relacionProyectoC());
				}
				else{
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_3);				
					$this->texto($this->getDs_aportesC());
				}
				if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2016) {
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_4_2017);
					$this->texto($this->getDs_aportesC());
				}
				else{
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_4);
					$this->texto($this->getDs_actividadesC());
				}
				if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2016) {
					$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_C_PLAN_TRABAJO_5_2017);
					$this->texto($this->getDs_actividadesC());
				}
				
			}
		}
		$this->firma1();
		$this->AddPage();
	
        $this->Apellido();
	
        
	    $this->separadorM(CYT_MSG_SOLICITUD_SEPARADOR_DESCRIPCION, 'B');
		$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_PRESUPUESTO,'B','C');
		$total=0;
		
		if ($this->getPeriodo_oid() > CYT_SOLICITUD_PERIODO_2012 ) {
			if($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2016)) {
				switch ($this->getMotivo_oid()) {
					case 1:
					  $this->separador(CYT_MSG_SOLICITUD_AMBITOS_A);
					break;
					case 2:
					  $this->separador(CYT_MSG_SOLICITUD_AMBITOS_B);
					break;
					case 3:
					  $this->separador(CYT_MSG_SOLICITUD_AMBITOS_C);
					break;
					
				}
			}
			else{
				$this->separador(CYT_MSG_SOLICITUD_AMBITOS);
			}
			$this->Ambitos();
		}
		$this->separador(CYT_MSG_SOLICITUD_SEPARADOR_SERVICIOS_NO_PERSONALES);
		$this->Presupuestos();
		$this->firma2();
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
		if ($this->getEstado_oid()==CYT_ESTADO_SOLICITUD_CREADA) {
			$this->RotatedText($this->lMargin, $this->h - 10, utf8_decode('      '.CYT_MSG_SOLICITUD_PDF_PRELIMINAR_TEXT.'       '.CYT_MSG_SOLICITUD_PDF_PRELIMINAR_TEXT), 60);
		}
			
		
		$this->SetY(13);
		
		$this->SetTextColor(0, 0, 0);
		$this->Image(APP_PATH . 'css/images/unlp.png',12,16,85,16);
	
		$this->SetFont ( 'Arial', '', 13 );
		
		
		
		$this->Cell ( $this->getMaxWidth(), 10, utf8_decode(CYT_MSG_SOLICITUD_PDF_HEADER_TITLE)." ".$this->getYear(), 'LRT',0,'R');
		$this->ln(5);
		
		$this->SetFont ( 'Arial', '', 12 );
		$this->Cell ( $this->getMaxWidth(), 10, utf8_decode(CYT_MSG_SOLICITUD_PDF_HEADER_TITLE_2), 'LR',0,'R');
		$this->ln(5);
		
		$this->SetFont ( 'Arial', '', 12 );
		$this->Cell ( $this->getMaxWidth(), 10, CYT_MSG_SOLICITUD_PDF_MES_2." ".$this->getYear()." - ".CYT_MSG_SOLICITUD_PDF_MES_1." ".($this->getYear()+1), 'LRB',0,'R');
		
		
		//Line break
		$this->Ln(15);
	}
	
		
	

	/**
	 * (non-PHPdoc)
	 * @see CdtPDFPrint#Footer()
	 */
	function Footer(){
		
		$this->SetY(-15);
		
		
		$this->SetFont('Arial','I',8);

		$this->Cell(0,10,utf8_decode(CYT_MSG_SOLICITUD_PDF_PAGINA).' '.$this->PageNo().' '.CYT_MSG_SOLICITUD_PDF_PAGINA_DE.' {nb}',0,0,'C');
		
	}

	
	
	function NyAp() {
		
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-155, 8, utf8_decode(CYT_LBL_DOCENTE_APELLIDO_NOMBRE).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-80, 8, utf8_decode($this->getDs_investigador()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-175, 8, utf8_decode(CYT_LBL_DOCENTE_CUIL).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-160, 8, utf8_decode($this->getNu_cuil()), 'LTBR',0,'L',1);
		$this->ln(10);
	}

	function separadorM($ds_texto, $style='') {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', $style, 10 );
		$this->MultiCell( $this->getMaxWidth(), 6, utf8_decode($ds_texto),0, 'L');
		$this->ln(6);
	}
	
	function separador($ds_texto, $style='', $align='L', $fontSize='10') {
		
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', $style, $fontSize );
		$this->Cell ( $this->getMaxWidth(), 6, utf8_decode($ds_texto),0,0,$align);
		$this->ln(6);
	}
	
	function separadorNegro($ds_texto) {
		
		$this->SetTextColor(255,255,255);
		$this->SetFillColor(0,0,0);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth(), 6, $ds_texto,0,0,'',1);
		$this->ln(6);
		$this->SetTextColor(0,0,0);
	}
	
	function domicilio() {
		
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-175, 8, utf8_decode(CYT_LBL_DOCENTE_CALLE).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-115, 8, utf8_decode($this->getDs_calle()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-180, 8, utf8_decode(CYT_LBL_DOCENTE_NRO).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-175, 8, utf8_decode($this->getNu_nro()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-180, 8, utf8_decode(CYT_LBL_DOCENTE_PISO).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-178, 8, utf8_decode($this->getNu_piso()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-175, 8, utf8_decode(CYT_LBL_DOCENTE_DEPTO).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-178, 8, utf8_decode($this->getDs_depto()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-180, 8,  utf8_decode(CYT_LBL_DOCENTE_CP).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-174, 8, utf8_decode($this->getNu_cp()), 'LTBR',0,'L',1);
		$this->ln(10);
	}
	
	function mail() {
		
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-175, 8, utf8_decode(CYT_LBL_DOCENTE_MAIL).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-70, 8, utf8_decode($this->getDs_mail()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_DOCENTE_TELEFONO).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-155, 8, utf8_decode($this->getNu_telefono()), 'LTBR',0,'L',1);
		$this->ln(10);
	}
	
	function titulo() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-160, 8, utf8_decode(CYT_LBL_DOCENTE_TITULO_GRADO).":");
		$this->SetFillColor(225,225,225);
		
		$this->MultiCell( $this->getMaxWidth()-30, 4, utf8_decode($this->getDs_titulogrado()), 'LTBR','L',1);
		$this->ln(10);
	}
	
	function unidad() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-130, 8, utf8_decode(CYT_LBL_DOCENTE_LUGAR_TRABAJO_UNLP).":");
		$this->SetFillColor(225,225,225);
		$this->MultiCell( $this->getMaxWidth()-60, 4, utf8_decode($this->getDs_lugarTrabajo()), 'LTBR','L',1);
		
		$this->ln(6);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_LUGAR_TRABAJO_DIRECCION).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-85, 8, utf8_decode($this->getDs_lugarTrabajoDireccion()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_DOCENTE_TELEFONO).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-145, 8, utf8_decode($this->getDs_lugarTrabajoTelefono()), 'LTBR',0,'L',1);
		$this->ln(10);
	}
	
	function cargo() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-150, 8, utf8_decode(CYT_LBL_DOCENTE_CARGO).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-105, 8, utf8_decode($this->getDs_cargo()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_DOCENTE_DEDDOC).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-145, 8, utf8_decode($this->getDs_deddoc()), 'LTBR',0,'L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_DOCENTE_FACULTAD).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-20, 8, utf8_decode($this->getDs_facultad()), 'LTBR',0,'L',1);

		$this->ln(10);
	}
	
	function becario() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_SOLICITUD_BECA_INSTIUTCION).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-20, 8, utf8_decode($this->getDs_orgbeca()), 'LTBR',0,'L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-160, 8, utf8_decode(CYT_LBL_SOLICITUD_BECA_NIVEL).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-105, 8, utf8_decode($this->getDs_tipobeca()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-175, 8, utf8_decode(CYT_LBL_SOLICITUD_BECA_PERIODO).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-130, 8, $this->getDs_periodobeca(), 'LTBR',0,'L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-160, 8, utf8_decode(CYT_LBL_SOLICITUD_BECA_LUGAR_TRABAJO).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-30, 8, utf8_decode($this->getDs_lugarTrabajoBeca()), 'LTBR',0,'L',1);
		if($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2017)) {
			if ($this->getDs_resumenbeca()!='') {
				$this->ln(10);
				$this->separador(CYT_MSG_BECA_RESUMEN.':', '', 'L', $fontSize);
				$this->SetFont ( 'Arial', '', $fontSize );
				$this->SetFillColor(225,225,225);
				$this->MultiCell( $this->getMaxWidth(), 4, utf8_decode($this->getDs_resumenbeca()), 'LTBR','L',1);
				
			
			}
		}
		$this->ln(10);
	}
	
	function carrera() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_SOLICITUD_CARRERA_ORGANISMO).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-20, 8, utf8_decode($this->getDs_organismo()), 'LTBR',0,'L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_SOLICITUD_CARRERA_CATEGORIA).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-95, 8, utf8_decode($this->getDs_carrerainv()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-175, 8, utf8_decode(CYT_LBL_SOLICITUD_CARRERA_INGRESO).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-130, 8, $this->getDt_ingreso(), 'LTBR',0,'L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-160, 8, utf8_decode(CYT_LBL_SOLICITUD_CARRERA_LUGAR_TRABAJO).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-30, 8, utf8_decode($this->getDs_lugarTrabajoCarrera()), 'LTBR',0,'L',1);

		$this->ln(10);
	}
	
	function categoria() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-130, 8, utf8_decode(CYT_LBL_SOLICITUD_CATEGORIA_PDF).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-175, 8, $this->getDs_categoria(), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-165, 8, utf8_decode(CYT_LBL_SOLICITUD_POSTULANTE).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-100, 8, $this->getDs_tipoInvestigador(), 'LTBR',0,'L',1);
		$this->ln(10);
		
	}
	
	function proyecto($ds_titulo, $ds_director, $ds_codigo, $dt_ini, $dt_fin, $ds_estado, $ds_abstract1, $fontSize='10') {
		$this->SetFont ( 'Arial', '', $fontSize );
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_PROYECTO_TITULO).":"); 
		$this->SetFillColor(225,225,225);
		$this->MultiCell ( $this->getMaxWidth()-20, 5, utf8_decode($ds_titulo), 'LTBR','L',1);
		$this->ln(2);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_PROYECTO_DIRECTOR).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-80, 8, utf8_decode($ds_director), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_PROYECTO_ESTADO).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-150, 8, utf8_decode($ds_estado), 'LTBR',0,'L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_PROYECTO_CODIGO).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-150, 8, $ds_codigo, 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_PROYECTO_DESDE).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-145, 8, $dt_ini, 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-170, 8, utf8_decode(CYT_LBL_PROYECTO_HASTA).":"); 
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-145, 8, $dt_fin, 'LTBR',0,'L',1);
		
		$this->ln(10);
		$this->separador(CYT_MSG_PROYECTO_RESUMEN.':', '', 'L', $fontSize);
		$this->SetFont ( 'Arial', '', $fontSize );
		$this->SetFillColor(225,225,225);
		$this->MultiCell( $this->getMaxWidth(), 4, utf8_decode($ds_abstract1), 'LTBR','L',1);
		
		
		$this->ln(10);
	}
	
	function Ambitos(){
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C','C','C'));
		$this->SetWidths(array($this->getMaxWidth()-135, $this->getMaxWidth()-145, $this->getMaxWidth()-140, $this->getMaxWidth()-170, $this->getMaxWidth()-170));
		$this->row(array(utf8_decode(CYT_LBL_AMBITO_INSTITUCION),utf8_decode(CYT_LBL_AMBITO_CIUDAD),utf8_decode(CYT_LBL_AMBITO_PAIS), CYT_LBL_AMBITO_DESDE, CYT_LBL_AMBITO_HASTA));
		//$this->ln(8);
	 	$this->SetFillColor(225,225,225);
	 	$this->SetAligns(array('L','L','L','C','C'));
		foreach ($this->getAmbitos() as $oAmbito) {
			$this->row(array(utf8_decode($oAmbito->getDs_institucion()),utf8_decode($oAmbito->getDs_ciudad()),utf8_decode($oAmbito->getDs_pais()),CYTSecureUtils::formatDateToView($oAmbito->getDt_desde()),CYTSecureUtils::formatDateToView($oAmbito->getDt_hasta())));
		}
			
		
		//$this->SetFont ( 'times', '', 12 );
	}
	
	function Montos(){
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C'));
		$this->SetWidths(array($this->getMaxWidth()-115, $this->getMaxWidth()-115, $this->getMaxWidth()-150));
		$this->row(array(utf8_decode(CYT_LBL_MONTO_INSTITUCION),utf8_decode(CYT_LBL_MONTO_CARACTER),utf8_decode(CYT_LBL_MONTO_IMPORTE)));
		//$this->ln(8);
	 	$this->SetFillColor(225,225,225);
	 	$this->SetAligns(array('L','L','R'));
		foreach ($this->getMontosOrganismos() as $oMonto) {
			$this->row(array(utf8_decode($oMonto->getDs_institucion()),utf8_decode($oMonto->getDs_caracter()), CYTSecureUtils::formatMontoToView($oMonto->getNu_monto())));
		}
			
		$this->ln(10);
		//$this->SetFont ( 'times', '', 12 );
	}
	
	function Presupuestos(){
		$total=0;
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C'));
		$this->SetWidths(array($this->getMaxWidth()-160, $this->getMaxWidth()-65, $this->getMaxWidth()-155));
		$this->row(array(utf8_decode(CYT_LBL_PRESUPUESTO_FECHA),utf8_decode(CYT_LBL_PRESUPUESTO_DESCRIPCION_CONCEPTO),utf8_decode(CYT_LBL_PRESUPUESTO_IMPORTE)));
		//$this->ln(8);
	 	$this->SetFillColor(225,225,225);
	 	$this->SetAligns(array('L','L','R'));
		foreach ($this->getPresupuestos() as $oPresupuesto) {
			$array_presupuesto = explode('|',stripslashes($oPresupuesto->getDs_presupuesto()));
			switch ($array_presupuesto[0]) {
				case CYT_LBL_PRESUPUESTO_VIATICOS:
					$ds_presupuesto = utf8_decode(CYT_LBL_PRESUPUESTO_VIATICOS_ACENTO).' - '.utf8_decode(CYT_LBL_PRESUPUESTO_DIAS).': '.$oPresupuesto->getDs_dias().' - '.utf8_decode(CYT_LBL_PRESUPUESTO_LUGAR).': '.utf8_decode($oPresupuesto->getDs_lugar());
					break;
				case CYT_LBL_PRESUPUESTO_PASAJES:
					$ds_presupuesto = CYT_LBL_PRESUPUESTO_PASAJES.' - '.utf8_decode($oPresupuesto->getDs_pasajes()).' - '.CYT_LBL_PRESUPUESTO_DESTINO.': '.utf8_decode($oPresupuesto->getDs_destino());
					break;
				case CYT_LBL_PRESUPUESTO_ALOJAMIENTO:
					$ds_presupuesto = CYT_LBL_PRESUPUESTO_ALOJAMIENTO.' - '.CYT_LBL_PRESUPUESTO_NOCHES.': '.$oPresupuesto->getDs_dias().' - '.CYT_LBL_PRESUPUESTO_LUGAR.': '.utf8_decode($oPresupuesto->getDs_lugar());
					break;
				case CYT_LBL_PRESUPUESTO_INSCRIPCION:
					$ds_presupuesto = utf8_decode(CYT_LBL_PRESUPUESTO_INSCRIPCION_ACENTO).' - '.utf8_decode(CYT_LBL_PRESUPUESTO_DESCRIPCION).': '.utf8_decode($oPresupuesto->getDs_inscripcion());
					break;
				case CYT_LBL_PRESUPUESTO_OTROS:
					$ds_presupuesto = CYT_LBL_PRESUPUESTO_OTROS.' - '.utf8_decode(CYT_LBL_PRESUPUESTO_DESCRIPCION).': '.utf8_decode($oPresupuesto->getDs_inscripcion());
					break;
			}
			$this->row(array(CYTSecureUtils::formatDateToView($oPresupuesto->getDt_fecha()),$ds_presupuesto, CYTSecureUtils::formatMontoToView($oPresupuesto->getNu_montopresupuesto())));
			$total +=$oPresupuesto->getNu_montopresupuesto();
		}
			
		$this->ln(10);
		$this->Cell ( $this->getMaxWidth(), 8, CYT_MSG_SOLICITUD_TOTAL.': '.CYTSecureUtils::formatMontoToView($total), 'LTBR',0,'R',1);
		//$this->SetFont ( 'times', '', 12 );
	}

	function texto($ds_texto) {
		
		$this->SetFillColor(225,225,225);
		$this->MultiCell( $this->getMaxWidth(), 4, utf8_decode($ds_texto), 'LTBR','L',1);
		
		
		$this->ln(10);
	}
	
	function monto() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-108, 8, utf8_decode(CYT_MSG_SOLICITUD_PDF_MONTO).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-150, 8, CYTSecureUtils::formatMontoToView($this->getNu_monto()), 'LTBR',0,'L',1);
		
		$this->ln(10);
		
	}
	
	function motivoA() {
		if ($this->getBl_congreso()) {
			$this->SetFillColor(255,255,255);
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell ( $this->getMaxWidth()-150, 8, utf8_decode(CYT_MSG_SOLICITUD_PDF_MOTIVO_A_TIPO).":");
			$this->SetFillColor(225,225,225);
			switch ($this->getBl_congreso()) {
				case CYT_CD_CONGRESO:
					$congreso=CYT_DS_CONGRESO;
					break;
				case CYT_CD_CONFERENCIA:
					$congreso=CYT_DS_CONFERENCIA;
					break;
			}
		//	$this->Cell ( 145, 8, stripslashes($congreso), 'LTBR',0,'L',1);	
			$this->MultiCell( $this->getMaxWidth()-40, 8, utf8_decode($congreso), 'LTBR','L',1);
			$this->ln(10);
		}
		
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$titulo=($this->getBl_congreso()==CYT_CD_CONFERENCIA)?CYT_MSG_SOLICITUD_PDF_TITULO_CONFERENCIA.':':CYT_MSG_SOLICITUD_PDF_TITULO_TRABAJO.':';
		$this->Cell ( $this->getMaxWidth()-150, 8, utf8_decode($titulo));
		$this->SetFillColor(225,225,225);
	//	$this->Cell ( 145, 8, stripslashes($ds_titulotrabajo), 'LTBR',0,'L',1);
		$this->MultiCell( $this->getMaxWidth()-40, 8, utf8_decode($this->getDs_titulotrabajo()), 'LTBR','L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$autor=($this->getBl_congreso()==CYT_CD_CONFERENCIA)?CYT_MSG_SOLICITUD_PDF_AUTOR_CONFERENCIA.':':CYT_MSG_SOLICITUD_PDF_AUTOR_TRABAJO.':';
		$this->Cell ( $this->getMaxWidth()-150, 8, $autor);
		$this->SetFillColor(225,225,225);
		//$this->Cell ( 145, 8, stripslashes($ds_autorestrabajo), 'LTBR',0,'L',1);
		$this->MultiCell( $this->getMaxWidth()-40, 8, utf8_decode($this->getDs_autorestrabajo()), 'LTBR','L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$congreso=($this->getBl_congreso()==CYT_CD_CONFERENCIA)?CYT_MSG_SOLICITUD_PDF_NOMBRE_CONFERENCIA.':':CYT_MSG_SOLICITUD_PDF_NOMBRE_TRABAJO.':';
		if($this->getBl_congreso()==CYT_CD_CONFERENCIA){
			$x = $this->GetX();
			$y = $this->GetY();
			$this->MultiCell( $this->getMaxWidth()-150, 4, $congreso);
			$this->SetXY($x+40, $y-1);
			
			
		}
		else $this->Cell ( $this->getMaxWidth()-150, 8, $congreso);
		$this->SetFillColor(225,225,225);
		//$this->Cell ( 145, 8, stripslashes($ds_congreso), 'LTBR',0,'L',1);
		$this->MultiCell( $this->getMaxWidth()-40, 8, utf8_decode($this->getDs_congreso()), 'LTBR','L',1);
		$this->ln(10);
		if ($this->getBl_nacional()) {
			$this->SetFillColor(255,255,255);
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell ( $this->getMaxWidth()-150, 8, utf8_decode(CYT_MSG_SOLICITUD_PDF_CARACTER).":");
			$this->SetFillColor(225,225,225);
			switch ($this->getBl_nacional()) {
				case CYT_CD_NACIONAL:
					$nacional=CYT_DS_NACIONAL;
					break;
				case CYT_CD_INTERNACIONAL:
					$nacional=CYT_DS_INTERNACIONAL;
					break;
			}
		//	$this->Cell ( 145, 8, stripslashes($congreso), 'LTBR',0,'L',1);	
			$this->MultiCell( $this->getMaxWidth()-40, 8, utf8_decode($nacional), 'LTBR','L',1);
			$this->ln(10);
		}
		if ($this->getPeriodo_oid()>CYT_SOLICITUD_PERIODO_2016) {
			$this->SetFillColor(255,255,255);
			$this->Cell ( $this->getMaxWidth()-178, 8, CYT_MSG_SOLICITUD_PDF_LUGAR.":");
			$this->SetFillColor(225,225,225);
			$this->Cell ( $this->getMaxWidth()-98, 8, utf8_decode($this->getDs_lugardeltrabajo()), 'LTBR',0,'L',1);
			$this->SetFillColor(255,255,255);
			$this->Cell ( $this->getMaxWidth()-168, 8, CYT_MSG_SOLICITUD_PDF_FECHA.":");
			$this->SetFillColor(225,225,225);
			$this->Cell ( $this->getMaxWidth()-168, 8, CYTSecureUtils::formatDateToView($this->getDt_fechatrabajo()), 'LTBR',0,'L',1);
			$this->SetFillColor(255,255,255);
			$this->Cell ( $this->getMaxWidth()-170, 8, CYT_MSG_SOLICITUD_PDF_FECHA_HASTA.":");
			$this->SetFillColor(225,225,225);
			$this->Cell ( $this->getMaxWidth()-168, 8, CYTSecureUtils::formatDateToView($this->getDt_fechatrabajohasta()), 'LTBR',0,'L',1);
		}
		else{
			$this->SetFillColor(255,255,255);
			$this->Cell ( $this->getMaxWidth()-170, 8, CYT_MSG_SOLICITUD_PDF_LUGAR.":");
			$this->SetFillColor(225,225,225);
			$this->Cell ( $this->getMaxWidth()-95, 8, utf8_decode($this->getDs_lugardeltrabajo()), 'LTBR',0,'L',1);
			$this->SetFillColor(255,255,255);
			$this->Cell ( $this->getMaxWidth()-155, 8, CYT_MSG_SOLICITUD_PDF_FECHA.":");
			$this->SetFillColor(225,225,225);
			$this->Cell ( $this->getMaxWidth()-150, 8, CYTSecureUtils::formatDateToView($this->getDt_fechatrabajo()), 'LTBR',0,'L',1);
		}
		$this->ln(10);
		if ($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2016)) {
			$this->SetFillColor(255,255,255);
			$this->Cell ( $this->getMaxWidth(), 8, CYT_MSG_SOLICITUD_PDF_RELEVANCIA_EVENTO.":");
			$this->ln(6);
			$this->SetFillColor(225,225,225);
			$this->MultiCell( $this->getMaxWidth(), 8, utf8_decode($this->getDs_relevanciatrabajo()), 'LTBR','L',1);
			$this->ln(10);
		}
		$this->SetFillColor(255,255,255);
		$resumen = ($this->getBl_congreso()==CYT_CD_CONFERENCIA)?CYT_MSG_SOLICITUD_PDF_RESUMEN_CONFERENCIA:CYT_MSG_SOLICITUD_PDF_RESUMEN_TRABAJO;
		$this->Cell ( $this->getMaxWidth(), 8, CYT_MSG_SOLICITUD_PDF_RESUMEN.$resumen.":");
		$this->ln(6);
		$this->SetFillColor(225,225,225);
		$this->MultiCell( $this->getMaxWidth(), 8, utf8_decode($this->getDs_resumentrabajo()), 'LTBR','L',1);

		$this->ln(10);
		if ($this->getPeriodo_oid()>intval(CYT_SOLICITUD_PERIODO_2016)) {
			$this->SetFillColor(255,255,255);
			$this->Cell ( $this->getMaxWidth(), 8, utf8_decode(CYT_MSG_SOLICITUD_PDF_MODALIDAD_EVENTO).":");
			$this->ln(6);
			$this->SetFillColor(225,225,225);
			$this->MultiCell( $this->getMaxWidth(), 8, utf8_decode($this->getDs_modalidadtrabajo()), 'LTBR','L',1);
			$this->ln(10);
		}
	}
	
	function motivoC() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell( $this->getMaxWidth()-150, 8, CYT_MSG_SOLICITUD_PDF_MOTIVO_C_PROFESOR.":");
		$this->SetFillColor(225,225,225);
		$this->Cell (  $this->getMaxWidth()-40, 8, utf8_decode($this->getDs_profesor()), 'LTBR',0,'L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-130, 8, CYT_MSG_SOLICITUD_PDF_MOTIVO_C_LUGAR.":");
		$this->SetFillColor(225,225,225);
		$this->Cell (  $this->getMaxWidth()-60, 8, utf8_decode($this->getDs_lugarprofesor()), 'LTBR',0,'L',1);
		$this->ln(10);
		
	}
	
	function firma1() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', 'I', 11 );
		$this->MultiCell( $this->getMaxWidth(), 8, utf8_decode(CYT_MSG_SOLICITUD_DECLARACION_JURADA));
		$this->ln(6);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-180, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, '', 'B');
		$this->Cell ( $this->getMaxWidth()-160, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( $this->getMaxWidth()-180, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, CYT_MSG_SOLICITUD_FIRMA_LUGAR, '', 0, 'C');
		$this->Cell ( $this->getMaxWidth()-160, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, utf8_decode(CYT_MSG_SOLICITUD_FIRMA_ACLARACION), '', 0, 'C');
		$this->ln(10);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth(), 8, CYT_MSG_SOLICITUD_FIRMA_AVAL.$this->getDs_facultadplanilla(), 0, 0, 'C');
		$this->ln(15);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-180, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, '', 'B');
		$this->Cell ( $this->getMaxWidth()-160, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( $this->getMaxWidth()-180, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, CYT_MSG_SOLICITUD_FIRMA_LUGAR, '', 0, 'C');
		$this->Cell ( $this->getMaxWidth()-160, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, CYT_MSG_SOLICITUD_FIRMA_DECANO, '', 0, 'C');
	}
	
	function firma2() {
		$this->ln(30);
		
		$this->SetFillColor(255,255,255);
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( $this->getMaxWidth()-180, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, '', 'B');
		$this->Cell ( $this->getMaxWidth()-160, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( $this->getMaxWidth()-180, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, CYT_MSG_SOLICITUD_FIRMA_LUGAR, '', 0, 'C');
		$this->Cell ( $this->getMaxWidth()-160, 8);
		$this->Cell ( $this->getMaxWidth()-130, 8, utf8_decode(CYT_MSG_SOLICITUD_FIRMA_ACLARACION), '', 0, 'C');
		
		
	}
	
	function Apellido() {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-155, 8, CYT_LBL_DOCENTE_APELLIDO_NOMBRE.":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-35, 8, utf8_decode($this->getDs_investigador()), 'LTBR',0,'L',1);
		$this->ln(10);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-155, 8, CYT_LBL_FACULTAD.":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-35, 8, $this->getDs_facultadplanilla(), 'LTBR',0,'L',1);
		$this->ln(10);
	}
	
	
	
	
	public function getEstado_oid()
	{
	    return $this->estado_oid;
	}

	public function setEstado_oid($estado_oid)
	{
	    $this->estado_oid = $estado_oid;
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

	public function getNu_cuil()
	{
	    return $this->nu_cuil;
	}

	public function setNu_cuil($nu_cuil)
	{
	    $this->nu_cuil = $nu_cuil;
	}

	public function getDs_calle()
	{
	    return $this->ds_calle;
	}

	public function setDs_calle($ds_calle)
	{
	    $this->ds_calle = $ds_calle;
	}

	public function getNu_nro()
	{
	    return $this->nu_nro;
	}

	public function setNu_nro($nu_nro)
	{
	    $this->nu_nro = $nu_nro;
	}

	public function getNu_piso()
	{
	    return $this->nu_piso;
	}

	public function setNu_piso($nu_piso)
	{
	    $this->nu_piso = $nu_piso;
	}

	public function getDs_depto()
	{
	    return $this->ds_depto;
	}

	public function setDs_depto($ds_depto)
	{
	    $this->ds_depto = $ds_depto;
	}

	public function getNu_cp()
	{
	    return $this->nu_cp;
	}

	public function setNu_cp($nu_cp)
	{
	    $this->nu_cp = $nu_cp;
	}

	public function getDs_mail()
	{
	    return $this->ds_mail;
	}

	public function setDs_mail($ds_mail)
	{
	    $this->ds_mail = $ds_mail;
	}

	public function getNu_telefono()
	{
	    return $this->nu_telefono;
	}

	public function setNu_telefono($nu_telefono)
	{
	    $this->nu_telefono = $nu_telefono;
	}

	public function getBl_notificacion()
	{
	    return $this->bl_notificacion;
	}

	public function setBl_notificacion($bl_notificacion)
	{
	    $this->bl_notificacion = $bl_notificacion;
	}

	public function getMaxWidth()
	{
	    return $this->maxWidth;
	}

	public function setMaxWidth($maxWidth)
	{
	    $this->maxWidth = $maxWidth;
	}

	public function getDs_titulogrado()
	{
	    return $this->ds_titulogrado;
	}

	public function setDs_titulogrado($ds_titulogrado)
	{
	    $this->ds_titulogrado = $ds_titulogrado;
	}

	public function getDs_lugarTrabajo()
	{
	    return $this->ds_lugarTrabajo;
	}

	public function setDs_lugarTrabajo($ds_lugarTrabajo)
	{
	    $this->ds_lugarTrabajo = $ds_lugarTrabajo;
	}

	public function getDs_lugarTrabajoDireccion()
	{
	    return $this->ds_lugarTrabajoDireccion;
	}

	public function setDs_lugarTrabajoDireccion($ds_lugarTrabajoDireccion)
	{
	    $this->ds_lugarTrabajoDireccion = $ds_lugarTrabajoDireccion;
	}

	public function getDs_lugarTrabajoTelefono()
	{
	    return $this->ds_lugarTrabajoTelefono;
	}

	public function setDs_lugarTrabajoTelefono($ds_lugarTrabajoTelefono)
	{
	    $this->ds_lugarTrabajoTelefono = $ds_lugarTrabajoTelefono;
	}

	public function getDs_cargo()
	{
	    return $this->ds_cargo;
	}

	public function setDs_cargo($ds_cargo)
	{
	    $this->ds_cargo = $ds_cargo;
	}

	public function getDs_deddoc()
	{
	    return $this->ds_deddoc;
	}

	public function setDs_deddoc($ds_deddoc)
	{
	    $this->ds_deddoc = $ds_deddoc;
	}

	public function getDs_facultad()
	{
	    return $this->ds_facultad;
	}

	public function setDs_facultad($ds_facultad)
	{
	    $this->ds_facultad = $ds_facultad;
	}

	public function getBl_becario()
	{
	    return $this->bl_becario;
	}

	public function setBl_becario($bl_becario)
	{
	    $this->bl_becario = $bl_becario;
	}

	public function getBl_carrera()
	{
	    return $this->bl_carrera;
	}

	public function setBl_carrera($bl_carrera)
	{
	    $this->bl_carrera = $bl_carrera;
	}

	public function getDs_tipobeca()
	{
	    return $this->ds_tipobeca;
	}

	public function setDs_tipobeca($ds_tipobeca)
	{
	    $this->ds_tipobeca = $ds_tipobeca;
	}

	public function getDs_orgbeca()
	{
	    return $this->ds_orgbeca;
	}

	public function setDs_orgbeca($ds_orgbeca)
	{
	    $this->ds_orgbeca = $ds_orgbeca;
	}

	public function getDs_lugarTrabajoBeca()
	{
	    return $this->ds_lugarTrabajoBeca;
	}

	public function setDs_lugarTrabajoBeca($ds_lugarTrabajoBeca)
	{
	    $this->ds_lugarTrabajoBeca = $ds_lugarTrabajoBeca;
	}

	public function getDs_periodobeca()
	{
	    return $this->ds_periodobeca;
	}

	public function setDs_periodobeca($ds_periodobeca)
	{
	    $this->ds_periodobeca = $ds_periodobeca;
	}

	public function getDs_carrerainv()
	{
	    return $this->ds_carrerainv;
	}

	public function setDs_carrerainv($ds_carrerainv)
	{
	    $this->ds_carrerainv = $ds_carrerainv;
	}

	public function getDs_organismo()
	{
	    return $this->ds_organismo;
	}

	public function setDs_organismo($ds_organismo)
	{
	    $this->ds_organismo = $ds_organismo;
	}

	public function getDs_lugarTrabajoCarrera()
	{
	    return $this->ds_lugarTrabajoCarrera;
	}

	public function setDs_lugarTrabajoCarrera($ds_lugarTrabajoCarrera)
	{
	    $this->ds_lugarTrabajoCarrera = $ds_lugarTrabajoCarrera;
	}

	public function getDt_ingreso()
	{
	    return $this->dt_ingreso;
	}

	public function setDt_ingreso($dt_ingreso)
	{
	    $this->dt_ingreso = $dt_ingreso;
	}

	public function getDs_categoria()
	{
	    return $this->ds_categoria;
	}

	public function setDs_categoria($ds_categoria)
	{
	    $this->ds_categoria = $ds_categoria;
	}

	public function getTipoInvestigador()
	{
	    return $this->tipoInvestigador;
	}

	public function setTipoInvestigador($tipoInvestigador)
	{
	    $this->tipoInvestigador = $tipoInvestigador;
	}

	public function getDs_tipoInvestigador()
	{
	    return $this->ds_tipoInvestigador;
	}

	public function setDs_tipoInvestigador($ds_tipoInvestigador)
	{
	    $this->ds_tipoInvestigador = $ds_tipoInvestigador;
	}

	public function getProyectos()
	{
	    return $this->proyectos;
	}

	public function setProyectos($proyectos)
	{
	    $this->proyectos = $proyectos;
	}

	public function getAmbitos()
	{
	    return $this->ambitos;
	}

	public function setAmbitos($ambitos)
	{
	    $this->ambitos = $ambitos;
	}

	public function getPeriodo_oid()
	{
	    return $this->periodo_oid;
	}

	public function setPeriodo_oid($periodo_oid)
	{
	    $this->periodo_oid = $periodo_oid;
	}

	public function getDs_objetivo()
	{
	    return $this->ds_objetivo;
	}

	public function setDs_objetivo($ds_objetivo)
	{
	    $this->ds_objetivo = $ds_objetivo;
	}

	public function getNu_monto()
	{
	    return $this->nu_monto;
	}

	public function setNu_monto($nu_monto)
	{
	    $this->nu_monto = $nu_monto;
	}

	public function getMontosOrganismos()
	{
	    return $this->montosOrganismos;
	}

	public function setMontosOrganismos($montosOrganismos)
	{
	    $this->montosOrganismos = $montosOrganismos;
	}

	public function getDs_motivo()
	{
	    return $this->ds_motivo;
	}

	public function setDs_motivo($ds_motivo)
	{
	    $this->ds_motivo = $ds_motivo;
	}

	public function getMotivo_oid()
	{
	    return $this->motivo_oid;
	}

	public function setMotivo_oid($motivo_oid)
	{
	    $this->motivo_oid = $motivo_oid;
	}

	public function getBl_congreso()
	{
	    return $this->bl_congreso;
	}

	public function setBl_congreso($bl_congreso)
	{
	    $this->bl_congreso = $bl_congreso;
	}

	public function getDs_titulotrabajo()
	{
	    return $this->ds_titulotrabajo;
	}

	public function setDs_titulotrabajo($ds_titulotrabajo)
	{
	    $this->ds_titulotrabajo = $ds_titulotrabajo;
	}

	public function getDs_autorestrabajo()
	{
	    return $this->ds_autorestrabajo;
	}

	public function setDs_autorestrabajo($ds_autorestrabajo)
	{
	    $this->ds_autorestrabajo = $ds_autorestrabajo;
	}

	public function getDs_congreso()
	{
	    return $this->ds_congreso;
	}

	public function setDs_congreso($ds_congreso)
	{
	    $this->ds_congreso = $ds_congreso;
	}

	
	public function getDt_fechatrabajo()
	{
	    return $this->dt_fechatrabajo;
	}

	public function setDt_fechatrabajo($dt_fechatrabajo)
	{
	    $this->dt_fechatrabajo = $dt_fechatrabajo;
	}

	public function getDs_resumentrabajo()
	{
	    return $this->ds_resumentrabajo;
	}

	public function setDs_resumentrabajo($ds_resumentrabajo)
	{
	    $this->ds_resumentrabajo = $ds_resumentrabajo;
	}

	public function getBl_nacional()
	{
	    return $this->bl_nacional;
	}

	public function setBl_nacional($bl_nacional)
	{
	    $this->bl_nacional = $bl_nacional;
	}

	public function getDs_lugardeltrabajo()
	{
	    return $this->ds_lugardeltrabajo;
	}

	public function setDs_lugardeltrabajo($ds_lugardeltrabajo)
	{
	    $this->ds_lugardeltrabajo = $ds_lugardeltrabajo;
	}

	public function getDs_profesor()
	{
	    return $this->ds_profesor;
	}

	public function setDs_profesor($ds_profesor)
	{
	    $this->ds_profesor = $ds_profesor;
	}

	public function getDs_lugarprofesor()
	{
	    return $this->ds_lugarprofesor;
	}

	public function setDs_lugarprofesor($ds_lugarprofesor)
	{
	    $this->ds_lugarprofesor = $ds_lugarprofesor;
	}

	public function getDs_libros()
	{
	    return $this->ds_libros;
	}

	public function setDs_libros($ds_libros)
	{
	    $this->ds_libros = $ds_libros;
	}

	public function getDs_compilados()
	{
	    return $this->ds_compilados;
	}

	public function setDs_compilados($ds_compilados)
	{
	    $this->ds_compilados = $ds_compilados;
	}

	public function getDs_capitulos()
	{
	    return $this->ds_capitulos;
	}

	public function setDs_capitulos($ds_capitulos)
	{
	    $this->ds_capitulos = $ds_capitulos;
	}

	public function getDs_articulos()
	{
	    return $this->ds_articulos;
	}

	public function setDs_articulos($ds_articulos)
	{
	    $this->ds_articulos = $ds_articulos;
	}

	public function getDs_congresos()
	{
	    return $this->ds_congresos;
	}

	public function setDs_congresos($ds_congresos)
	{
	    $this->ds_congresos = $ds_congresos;
	}

	public function getDs_patentes()
	{
	    return $this->ds_patentes;
	}

	public function setDs_patentes($ds_patentes)
	{
	    $this->ds_patentes = $ds_patentes;
	}

	public function getDs_intelectuales()
	{
	    return $this->ds_intelectuales;
	}

	public function setDs_intelectuales($ds_intelectuales)
	{
	    $this->ds_intelectuales = $ds_intelectuales;
	}

	public function getDs_informes()
	{
	    return $this->ds_informes;
	}

	public function setDs_informes($ds_informes)
	{
	    $this->ds_informes = $ds_informes;
	}

	public function getDs_tesis()
	{
	    return $this->ds_tesis;
	}

	public function setDs_tesis($ds_tesis)
	{
	    $this->ds_tesis = $ds_tesis;
	}

	public function getDs_tesinas()
	{
	    return $this->ds_tesinas;
	}

	public function setDs_tesinas($ds_tesinas)
	{
	    $this->ds_tesinas = $ds_tesinas;
	}

	public function getCategoria_oid()
	{
	    return $this->categoria_oid;
	}

	public function setCategoria_oid($categoria_oid)
	{
	    $this->categoria_oid = $categoria_oid;
	}

	public function getDs_becas()
	{
	    return $this->ds_becas;
	}

	public function setDs_becas($ds_becas)
	{
	    $this->ds_becas = $ds_becas;
	}

	public function getDs_objetivoC()
	{
	    return $this->ds_objetivoC;
	}

	public function setDs_objetivoC($ds_objetivoC)
	{
	    $this->ds_objetivoC = $ds_objetivoC;
	}

	public function getDs_planC()
	{
	    return $this->ds_planC;
	}

	public function setDs_planC($ds_planC)
	{
	    $this->ds_planC = $ds_planC;
	}

	public function getDs_aportesC()
	{
	    return $this->ds_aportesC;
	}

	public function setDs_aportesC($ds_aportesC)
	{
	    $this->ds_aportesC = $ds_aportesC;
	}

	public function getDs_actividadesC()
	{
	    return $this->ds_actividadesC;
	}

	public function setDs_actividadesC($ds_actividadesC)
	{
	    $this->ds_actividadesC = $ds_actividadesC;
	}

	public function getDs_generalB()
	{
	    return $this->ds_generalB;
	}

	public function setDs_generalB($ds_generalB)
	{
	    $this->ds_generalB = $ds_generalB;
	}

	public function getDs_especificoB()
	{
	    return $this->ds_especificoB;
	}

	public function setDs_especificoB($ds_especificoB)
	{
	    $this->ds_especificoB = $ds_especificoB;
	}

	public function getDs_actividadesB()
	{
	    return $this->ds_actividadesB;
	}

	public function setDs_actividadesB($ds_actividadesB)
	{
	    $this->ds_actividadesB = $ds_actividadesB;
	}

	public function getDs_cronogramaB()
	{
	    return $this->ds_cronogramaB;
	}

	public function setDs_cronogramaB($ds_cronogramaB)
	{
	    $this->ds_cronogramaB = $ds_cronogramaB;
	}

	public function getDs_aportesB()
	{
	    return $this->ds_aportesB;
	}

	public function setDs_aportesB($ds_aportesB)
	{
	    $this->ds_aportesB = $ds_aportesB;
	}

	public function getFacultadplanilla_oid()
	{
	    return $this->facultadplanilla_oid;
	}

	public function setFacultadplanilla_oid($facultadplanilla_oid)
	{
	    $this->facultadplanilla_oid = $facultadplanilla_oid;
	}

	public function getDs_facultadplanilla()
	{
	    return $this->ds_facultadplanilla;
	}

	public function setDs_facultadplanilla($ds_facultadplanilla)
	{
	    $this->ds_facultadplanilla = $ds_facultadplanilla;
	}

	public function getPresupuestos()
	{
	    return $this->presupuestos;
	}

	public function setPresupuestos($presupuestos)
	{
	    $this->presupuestos = $presupuestos;
	}

	public function getProyectosNoSeleccionados()
	{
	    return $this->proyectosNoSeleccionados;
	}

	public function setProyectosNoSeleccionados($proyectosNoSeleccionados)
	{
	    $this->proyectosNoSeleccionados = $proyectosNoSeleccionados;
	}

	public function getDt_fechatrabajohasta()
	{
	    return $this->dt_fechatrabajohasta;
	}

	public function setDt_fechatrabajohasta($dt_fechatrabajohasta)
	{
	    $this->dt_fechatrabajohasta = $dt_fechatrabajohasta;
	}

	public function getDs_relevanciatrabajo()
	{
	    return $this->ds_relevanciatrabajo;
	}

	public function setDs_relevanciatrabajo($ds_relevanciatrabajo)
	{
	    $this->ds_relevanciatrabajo = $ds_relevanciatrabajo;
	}

	public function getDs_modalidadtrabajo()
	{
	    return $this->ds_modalidadtrabajo;
	}

	public function setDs_modalidadtrabajo($ds_modalidadtrabajo)
	{
	    $this->ds_modalidadtrabajo = $ds_modalidadtrabajo;
	}

	public function getDs_relevanciaB()
	{
	    return $this->ds_relevanciaB;
	}

	public function setDs_relevanciaB($ds_relevanciaB)
	{
	    $this->ds_relevanciaB = $ds_relevanciaB;
	}

	public function getDs_relacionProyectoC()
	{
	    return $this->ds_relacionProyectoC;
	}

	public function setDs_relacionProyectoC($ds_relacionProyectoC)
	{
	    $this->ds_relacionProyectoC = $ds_relacionProyectoC;
	}

	public function getDs_relevanciaA()
	{
	    return $this->ds_relevanciaA;
	}

	public function setDs_relevanciaA($ds_relevanciaA)
	{
	    $this->ds_relevanciaA = $ds_relevanciaA;
	}

	public function getDs_resumenbeca()
	{
	    return $this->ds_resumenbeca;
	}

	public function setDs_resumenbeca($ds_resumenbeca)
	{
	    $this->ds_resumenbeca = $ds_resumenbeca;
	}

	public function getDs_justificacionB()
	{
	    return $this->ds_justificacionB;
	}

	public function setDs_justificacionB($ds_justificacionB)
	{
	    $this->ds_justificacionB = $ds_justificacionB;
	}

	public function getDs_googleScholar()
	{
	    return $this->ds_googleScholar;
	}

	public function setDs_googleScholar($ds_googleScholar)
	{
	    $this->ds_googleScholar = $ds_googleScholar;
	}
}