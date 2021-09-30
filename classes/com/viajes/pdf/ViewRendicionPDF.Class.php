<?php

/**
 * PDF de Cambio
 *
 * @author Marcos
 * @since 29-09-2021
 */
class ViewRendicionPDF extends CdtPDFPrint{

	private $maxWidth = "";


	private $periodo_oid = "";

	private $estado_oid = "";
	private $facultadplanilla_oid = "";
	private $year = "";
	private $ds_investigador = "";
	private $nu_cuil = "";

	private $ds_facultadplanilla = "";

	private $ambitos;

	private $dt_fecha= "";

	private $ds_observacion= "";

	private $presupuestos= "";

	public function __construct(){

		parent::__construct();

		$this->setAmbitos(new ItemCollection());

		$this->setPresupuestos(new ItemCollection());
	}

	function printRendicion(  ){
		$this->NyAp();

		$this->Ln(3);
		$this->separadorNegro(CYT_MSG_EVALUACION_OBSERVACIONES,'','');
		$this->SetFont ( 'Arial', '', 8 );
		$this->MultiCell($this->getMaxWidth(),4,$this->encodeCharacters($this->getDs_observacion()),'LTBR');


		/*$this->firma1();
		$this->AddPage();

        $this->Apellido();*/



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
			$this->RotatedText($this->lMargin, $this->h - 10, $this->encodeCharacters('      '.CYT_MSG_SOLICITUD_PDF_PRELIMINAR_TEXT.'       '.CYT_MSG_SOLICITUD_PDF_PRELIMINAR_TEXT), 60);
		}


		$this->SetY(13);

		$this->SetTextColor(0, 0, 0);
		$this->Image(APP_PATH . 'css/images/unlp.png',12,16,85,16);

		$this->SetFont ( 'Arial', '', 13 );



		$this->Cell ( $this->getMaxWidth(), 10, $this->encodeCharacters(CYT_MSG_SOLICITUD_PDF_HEADER_TITLE)." ".$this->getYear(), 'LRT',0,'R');
		$this->ln(5);

		$this->SetFont ( 'Arial', '', 12 );
		$this->Cell ( $this->getMaxWidth(), 10, $this->encodeCharacters(CYT_MSG_SOLICITUD_PDF_HEADER_TITLE_2), 'LR',0,'R');
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

		$this->Cell(0,10,$this->encodeCharacters(CYT_MSG_SOLICITUD_PDF_PAGINA).' '.$this->PageNo().' '.CYT_MSG_SOLICITUD_PDF_PAGINA_DE.' {nb}',0,0,'C');

	}



	function NyAp() {

		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( $this->getMaxWidth()-155, 8, $this->encodeCharacters(CYT_LBL_DOCENTE_APELLIDO_NOMBRE).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-80, 8, $this->encodeCharacters($this->getDs_investigador()), 'LTBR',0,'L',1);
		$this->SetFillColor(255,255,255);
		$this->Cell ( $this->getMaxWidth()-175, 8, $this->encodeCharacters(CYT_LBL_DOCENTE_CUIL).":");
		$this->SetFillColor(225,225,225);
		$this->Cell ( $this->getMaxWidth()-160, 8, $this->encodeCharacters($this->getNu_cuil()), 'LTBR',0,'L',1);
		$this->ln(10);
	}

	function separadorM($ds_texto, $style='') {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', $style, 10 );
		$this->MultiCell( $this->getMaxWidth(), 6, $this->encodeCharacters($ds_texto),0, 'L');
		$this->ln(6);
	}

	function separador($ds_texto, $style='', $align='L') {

		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', $style, 10 );
		$this->Cell ( $this->getMaxWidth(), 6, $this->encodeCharacters($ds_texto),0,0,$align);
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



	function Ambitos(){
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C','C','C'));
		$this->SetWidths(array($this->getMaxWidth()-135, $this->getMaxWidth()-145, $this->getMaxWidth()-140, $this->getMaxWidth()-170, $this->getMaxWidth()-170));
		$this->row(array($this->encodeCharacters(CYT_LBL_AMBITO_INSTITUCION),$this->encodeCharacters(CYT_LBL_AMBITO_CIUDAD),$this->encodeCharacters(CYT_LBL_AMBITO_PAIS), CYT_LBL_AMBITO_DESDE, CYT_LBL_AMBITO_HASTA));
		//$this->ln(8);
	 	$this->SetFillColor(225,225,225);
	 	$this->SetAligns(array('L','L','L','C','C'));
		foreach ($this->getAmbitos() as $oAmbito) {
			$this->row(array($this->encodeCharacters($oAmbito->getDs_institucion()),$this->encodeCharacters($oAmbito->getDs_ciudad()),$this->encodeCharacters($oAmbito->getDs_pais()),CYTSecureUtils::formatDateToView($oAmbito->getDt_desde()),CYTSecureUtils::formatDateToView($oAmbito->getDt_hasta())));
		}


		//$this->SetFont ( 'times', '', 12 );
	}


	function Presupuestos(){
		$total=0;
		$this->SetFillColor(255,255,255);
		$this->SetAligns(array('C','C','C'));
		$this->SetWidths(array($this->getMaxWidth()-160, $this->getMaxWidth()-65, $this->getMaxWidth()-155));
		$this->row(array($this->encodeCharacters(CYT_LBL_PRESUPUESTO_FECHA),$this->encodeCharacters(CYT_LBL_PRESUPUESTO_DESCRIPCION_CONCEPTO),$this->encodeCharacters(CYT_LBL_PRESUPUESTO_IMPORTE)));
		//$this->ln(8);
	 	$this->SetFillColor(225,225,225);
	 	$this->SetAligns(array('L','L','R'));
		foreach ($this->getPresupuestos() as $oPresupuesto) {
			$array_presupuesto = explode('|',stripslashes($oPresupuesto->getDs_presupuesto()));
			switch ($array_presupuesto[0]) {
				case CYT_LBL_PRESUPUESTO_VIATICOS:
					$ds_presupuesto = $this->encodeCharacters(CYT_LBL_PRESUPUESTO_VIATICOS_ACENTO).' - '.$this->encodeCharacters(CYT_LBL_PRESUPUESTO_DIAS).': '.$oPresupuesto->getDs_dias().' - '.$this->encodeCharacters(CYT_LBL_PRESUPUESTO_LUGAR).': '.$this->encodeCharacters($oPresupuesto->getDs_lugar());
					break;
				case CYT_LBL_PRESUPUESTO_PASAJES:
					$ds_presupuesto = CYT_LBL_PRESUPUESTO_PASAJES.' - '.$this->encodeCharacters($oPresupuesto->getDs_pasajes()).' - '.CYT_LBL_PRESUPUESTO_DESTINO.': '.$this->encodeCharacters($oPresupuesto->getDs_destino());
					break;
				case CYT_LBL_PRESUPUESTO_ALOJAMIENTO:
					$ds_presupuesto = CYT_LBL_PRESUPUESTO_ALOJAMIENTO.' - '.CYT_LBL_PRESUPUESTO_NOCHES.': '.$oPresupuesto->getDs_dias().' - '.CYT_LBL_PRESUPUESTO_LUGAR.': '.$this->encodeCharacters($oPresupuesto->getDs_lugar());
					break;
				case CYT_LBL_PRESUPUESTO_INSCRIPCION:
					$ds_presupuesto = $this->encodeCharacters(CYT_LBL_PRESUPUESTO_INSCRIPCION_ACENTO).' - '.$this->encodeCharacters(CYT_LBL_PRESUPUESTO_DESCRIPCION).': '.$this->encodeCharacters($oPresupuesto->getDs_inscripcion());
					break;
				case CYT_LBL_PRESUPUESTO_OTROS:
					$ds_presupuesto = CYT_LBL_PRESUPUESTO_OTROS.' - '.$this->encodeCharacters(CYT_LBL_PRESUPUESTO_DESCRIPCION).': '.$this->encodeCharacters($oPresupuesto->getDs_inscripcion());
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
		$this->MultiCell( $this->getMaxWidth(), 4, $this->encodeCharacters($ds_texto), 'LTBR','L',1);


		$this->ln(10);
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
		$this->Cell ( $this->getMaxWidth()-130, 8, $this->encodeCharacters(CYT_MSG_SOLICITUD_FIRMA_ACLARACION), '', 0, 'C');


	}






	public function getMaxWidth()
	{
	    return $this->maxWidth;
	}

	public function setMaxWidth($maxWidth)
	{
	    $this->maxWidth = $maxWidth;
	}

	public function getPeriodo_oid()
	{
	    return $this->periodo_oid;
	}

	public function setPeriodo_oid($periodo_oid)
	{
	    $this->periodo_oid = $periodo_oid;
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

	public function getNu_cuil()
	{
	    return $this->nu_cuil;
	}

	public function setNu_cuil($nu_cuil)
	{
	    $this->nu_cuil = $nu_cuil;
	}

	public function getDs_facultadplanilla()
	{
	    return $this->ds_facultadplanilla;
	}

	public function setDs_facultadplanilla($ds_facultadplanilla)
	{
	    $this->ds_facultadplanilla = $ds_facultadplanilla;
	}

	public function getAmbitos()
	{
	    return $this->ambitos;
	}

	public function setAmbitos($ambitos)
	{
	    $this->ambitos = $ambitos;
	}

	public function getDt_fecha()
	{
	    return $this->dt_fecha;
	}

	public function setDt_fecha($dt_fecha)
	{
	    $this->dt_fecha = $dt_fecha;
	}

	public function getDs_observacion()
	{
	    return $this->ds_observacion;
	}

	public function setDs_observacion($ds_observacion)
	{
	    $this->ds_observacion = $ds_observacion;
	}

	public function getPresupuestos()
	{
	    return $this->presupuestos;
	}

	public function setPresupuestos($presupuestos)
	{
	    $this->presupuestos = $presupuestos;
	}
}
