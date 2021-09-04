<?php

/**
 * Implementación para renderizar un formulario de cambio 
 *
 * @author Marcos
 * @since 09-06-2015
 *
 */
class CMPCambioFormRenderer extends DefaultFormRenderer {

	 protected function getXTemplate() {
    	return new XTemplate( CYT_TEMPLATE_CAMBIO_FORM );
    }
	
	
	protected function renderFieldset(CMPForm $form, XTemplate $xtpl){
		
		foreach ($form->getFieldsets() as $fieldset) {
			
			//legend
			$legend = $fieldset->getLegend();
			if(!empty($legend)){
				$xtpl->assign("value", $legend);
				$xtpl->parse("main.fieldset.legend");
			}
			
			
			$fields = $fieldset->getFields();
			$fieldInvestigador = $fields['ds_investigador'];		
			$input = $fieldInvestigador->getInput();
			$label = $fieldInvestigador->getLabel();	
			$this->renderLabel( $label, $input, $xtpl );
			$this->renderInput( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldInvestigador->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.fieldset.column.ds_investigador");
			
			$fieldCUIL = $fields['nu_cuil'];		
			$input = $fieldCUIL->getInput();
			$label = $fieldCUIL->getLabel();	
			$this->renderLabel( $label, $input, $xtpl );
			$this->renderInput( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldCUIL->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.fieldset.column.nu_cuil");
			
			
			
			$xtpl->parse("main.fieldset.column");
			
			
			$xtpl->parse("main.fieldset");
			
			$fieldCalle = $fields['ds_observacion'];		
			$input = $fieldCalle->getInput();
			$label = $fieldCalle->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldCalle->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_observacion");
			
			$hiddens = $form->getHiddens();
			
			$xtpl->assign("value", CYT_LBL_CAMBIO_A_ARCHIVO );
			$xtpl->assign("required", "*" );
			$xtpl->parse("main.ds_archivo.label");
			$xtpl->assign("actionFile", "doAction?action=add_file_session_cambio&solicitud_oid=".$hiddens['solicitud.oid']->getInputValue() );
			$xtpl->parse("main.ds_archivo.input");
			$xtpl->assign("display", 'block');
			
			
			
			$hiddenDs_archivo = $hiddens['ds_archivo'];	
				
			if ($hiddenDs_archivo->getInputValue()) {
				$xtpl->assign("ds_archivo_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_archivo->getInputValue().'</span>');
			}
			$xtpl->parse("main.ds_archivo");
			
		} 
	}

	
	
	
	
	
	/**
	 * renderizamos en el formulario de solicitud los ambitos.
	 
	 *
	 * @param CMPForm $form
	 * @param XTemplate $xtpl
	 */
	protected function getHTMLAmbitos(CMPForm $form){	

		$xtpl_ambitos = new XTemplate( CYT_TEMPLATE_CAMBIO_EDIT_AMBITOS );
		
		//mostrar los ambitos actuales.
		$xtpl_ambitos->assign('ambitos_title', CYT_MSG_SOLICITUD_AMBITOS_TITULO );
		
    	//TODO parsear labels.
    	$this->parseAmbitosLabels($xtpl_ambitos);
    	
		//recuperamos los ambitos de la solicitud desde la sesión.
		$manager = new AmbitoSessionManager();
    	$ambitos = $manager->getEntities( new CdtSearchCriteria() );
    	
    	//parseamos los ambitos.
    	$this->parseAmbitos($ambitos, $form, $xtpl_ambitos);
    	
    	//formulario para agregar un nuevo ambito a la solicitud.
    	if( $form->getIsEditable() ){
    		$hiddens = $form->getHiddens();
    		$ambitoForm = new CMPAmbitoForm('add_ambito_session&solicitud_oid='.$hiddens['solicitud.oid']->getInputValue());
			$xtpl_ambitos->assign('formulario', $ambitoForm->show() );
    	}
		$xtpl_ambitos->parse("main");
		
		return $xtpl_ambitos->text("main") ;

	}
	

	
/**
	 * renderizamos en el formulario de solicitud los presupuestos.
	 
	 *
	 * @param CMPForm $form
	 * @param XTemplate $xtpl
	 */
	protected function getHTMLPresupuesto(CMPForm $form){	

		$xtpl_presupuestos = new XTemplate( CYT_TEMPLATE_CAMBIO_EDIT_PRESUPUESTOS );
		
		//mostrar los presupuestos actuales.
		$xtpl_presupuestos->assign('presupuestos_title', CYT_MSG_SOLICITUD_PRESUPUESTOS_TITULO );
		
    	//TODO parsear labels.
    	$this->parsePresupuestosLabels($xtpl_presupuestos);
    	
		//recuperamos los presupuestos de la solicitud desde la sesión.
		$manager = new PresupuestoSessionManager();
    	$presupuestos = $manager->getEntities( new CdtSearchCriteria() );
    	
    	//parseamos los presupuestos.
    	$this->parsePresupuestos($presupuestos, $form, $xtpl_presupuestos);
    	
    	//formulario para agregar un nuevo presupuesto a la solicitud.
    	if( $form->getIsEditable() ){
    		$hiddens = $form->getHiddens();
    		$presupuestoForm = new CMPPresupuestoForm('add_presupuesto_session&solicitud_oid='.$hiddens['solicitud.oid']->getInputValue());
			$xtpl_presupuestos->assign('formulario', $presupuestoForm->show() );
    	}
		$xtpl_presupuestos->parse("main");
		
		return $xtpl_presupuestos->text("main") ;

	}
	
	
	
	protected function renderLabel( $label, CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("value", $label );
		
		if( $input->getIsRequired() && $input->getIsEditable() ){
			$xtpl->assign("required", $input->getRequiredLabel() );
		}else{
			$xtpl->assign("required", "" );
		}
		
		$xtpl->assign("input_name", $input->getId() );
		$xtpl->parse("main.fieldset.column.".$input->getId().".label");
	}
	
	protected function renderInput( CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("input", $input->show() );
		
		$xtpl->parse("main.fieldset.column.".$input->getId().".input");
		
	}
	
	protected function renderLabelTab( $label, CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("value", $label );
		
		if( $input->getIsRequired() && $input->getIsEditable() ){
			$xtpl->assign("required", $input->getRequiredLabel() );
		}else{
			$xtpl->assign("required", "" );
		}
		
		$xtpl->assign("input_name", $input->getId() );
		$xtpl->parse("main.".$input->getId().".label");
	}
	
	protected function renderInputTab( CMPFormInput $input, XTemplate $xtpl ){
		
		$xtpl->assign("input", $input->show() );
		
		$xtpl->parse("main.".$input->getId().".input");
		
	}
	
	protected function renderCustom(CMPForm $form, XTemplate $xtpl){
		
		//renderizamos las relaciones con sus formularios de alta
		
		$xtpl_relaciones = new XTemplate( CYT_TEMPLATE_CAMBIO_EDIT_CAMBIO_RELACIONES );
		
		//ambitos
		$ambitosHTML = $this->getHTMLAmbitos($form);
		$xtpl_relaciones->assign( "ambitos_tab", CYT_MSG_SOLICITUD_TAB_AMBITOS );
		$xtpl_relaciones->assign( "ambitos", $ambitosHTML );
		
		
		
		//presupuestos
		$presupuestosHTML = $this->getHTMLPresupuesto($form);
		$xtpl_relaciones->assign( "presupuestos_tab", CYT_MSG_SOLICITUD_TAB_PRESUPUESTOS );
		$xtpl_relaciones->assign( "presupuestos", $presupuestosHTML );
		
		$xtpl_relaciones->parse("main");
		
		
		
		$xtpl->assign( "customHTML", $xtpl_relaciones->text("main").$form->getCustomHTML());
	}	
	
	
	
	
	
	/**
	 * armamos un array con los datos del ambito.
	 * @param Ambito $ambito
	 */
	public function buildArrayAmbito(Ambito $ambito){

		$array_ambito = array();
		
		$array_ambito["item_oid"] = $ambito->getDs_institucion();
		$array_ambito["ds_institucion"] = $ambito->getDs_institucion();
		$array_ambito["ds_ciudad"] = $ambito->getDs_ciudad();
		$array_ambito["ds_pais"] = $ambito->getDs_pais();
		$array_ambito["dt_desde"] = CYTSecureUtils::formatDateToView($ambito->getDt_desde());
		$array_ambito["dt_hasta"] = CYTSecureUtils::formatDateToView($ambito->getDt_hasta());
		
		return $array_ambito;
		
	}
	/**
	 * columnas para el listado de ambitos
	 * @return multitype:string
	 */	
	public function getAmbitoColumns(){
		return array( "ds_institucion","ds_ciudad", "ds_pais","dt_desde","dt_hasta");
	}
	
	/**
	 * labels para el listado de ambitos
	 * @return multitype:string
	 */
	public function getAmbitoColumnsLabels(){
		return array( CYT_LBL_AMBITO_INSTITUCION, CYT_LBL_AMBITO_CIUDAD, CYT_LBL_AMBITO_PAIS,CYT_LBL_AMBITO_DESDE,CYT_LBL_AMBITO_HASTA);
	}
	
	/**
	 * aligns para las columnas del listado de ambitos.
	 * @return multitype:string
	 */
	public function getAmbitoColumnsAlign(){
		return array( "left", "left", "left","left","left");
	}

	/**
	 * parseamos los labels para el listado de ambitos.
	 * @param XTemplate $xtpl_ambitos
	 */
	protected function parseAmbitosLabels(XTemplate $xtpl_ambitos){
	
		$aligns = $this->getAmbitoColumnsAlign();
	
		$index=0;
		foreach ( $this->getAmbitoColumnsLabels() as $label) {
				
			$xtpl_ambitos->assign('ambito_label', $label );
			$xtpl_ambitos->assign('align', $aligns[$index]);
			$xtpl_ambitos->parse('main.ambito_th');
				
			$index++;
		}
	}
	
/**
	 * armamos un array con los datos del presupuesto.
	 * @param Presupuesto $presupuesto
	 */
	public function buildArrayPresupuesto(Presupuesto $presupuesto){

		$array_presupuesto = array();
		
		
		$array_presupuesto["dt_fecha"] = CYTSecureUtils::formatDateToView($presupuesto->getDt_fecha());
		$ds_presupuesto = $presupuesto->getDs_presupuesto().' - ';
		switch ($presupuesto->getDs_presupuesto()) {
				case CYT_CD_VIATICO:
				
				$ds_presupuesto .= CYT_LBL_PRESUPUESTO_DIAS.': '.$presupuesto->getDs_dias().' - '.CYT_LBL_PRESUPUESTO_LUGAR.': '.$presupuesto->getDs_lugar();
				break;
				
				case CYT_DS_PASAJE:
				
				$ds_presupuesto .= $presupuesto->getDs_pasajes().' - '.CYT_LBL_PRESUPUESTO_DESTINO.': '.$presupuesto->getDs_destino();
				break;
				
				case CYT_CD_INSCRIPCION:
				$ds_presupuesto .= CYT_LBL_PRESUPUESTO_DESCRIPCION.': '.$presupuesto->getDs_inscripcion();
				break;
			}
		$array_presupuesto["ds_presupuesto"] = $ds_presupuesto;
		$array_presupuesto["item_oid"] =$ds_presupuesto;
		$array_presupuesto["nu_montopresupuesto"] = CYTSecureUtils::formatMontoToView($presupuesto->getNu_montopresupuesto());
		
		
		return $array_presupuesto;
		
	}
	
/**
	 * columnas para el listado de presupuestos
	 * @return multitype:string
	 */	
	public function getPresupuestoColumns(){
		return array( "dt_fecha","ds_presupuesto", "nu_montopresupuesto");
	}
	
/**
	 * labels para el listado de presupuestos
	 * @return multitype:string
	 */
	public function getPresupuestoColumnsLabels(){
		return array( CYT_LBL_PRESUPUESTO_FECHA, CYT_LBL_PRESUPUESTO_DESCRIPCION_CONCEPTO, CYT_LBL_PRESUPUESTO_IMPORTE);
	}
	
	/**
	 * aligns para las columnas del listado de presupuestos.
	 * @return multitype:string
	 */
	public function getPresupuestoColumnsAlign(){
		return array( "left", "left", "right");
	}
	
	
/**
	 * parseamos los labels para el listado de presupuestos.
	 * @param XTemplate $xtpl_presupuestos
	 */
	protected function parsePresupuestosLabels(XTemplate $xtpl_presupuestos){
	
		$aligns = $this->getPresupuestoColumnsAlign();
	
		$index=0;
		foreach ( $this->getPresupuestoColumnsLabels() as $label) {
				
			$xtpl_presupuestos->assign('presupuesto_label', $label );
			$xtpl_presupuestos->assign('align', $aligns[$index]);
			$xtpl_presupuestos->parse('main.presupuesto_th');
				
			$index++;
		}
	}
	
	
	/**
	 * parseamos el listado de ambitos.
	 * @param ItemCollection $ambitos
	 * @param CMPForm $form
	 * @param XTemplate $xtpl_ambitos
	 */
	protected function parseAmbitos(ItemCollection $ambitos=null, CMPForm $form, XTemplate $xtpl_ambitos){
	
		if( $ambitos!= null ){
			foreach ($ambitos as $ambito) {
		   
				$this->parseAmbito($ambito, $xtpl_ambitos);
		   
				if( $form->getIsEditable() ){
					$xtpl_ambitos->assign('item_oid',$ambito->getDs_institucion());
					$xtpl_ambitos->parse("main.ambito.editar_ambito");
				}
		   
				$xtpl_ambitos->parse("main.ambito");
			}
		}
	}
	
	/**
	 * parseamos un ambito.
	 * @param Ambito $ambito
	 * @param XTemplate $xtpl_ambitos
	 */
	protected function parseAmbito(Ambito $ambito, XTemplate $xtpl_ambitos){
	
		$columns = $this->getAmbitoColumns();
		$aligns = $this->getAmbitoColumnsAlign();
		$array_ambito = $this->buildArrayAmbito($ambito);
	
		$index=0;
		foreach ($columns as $column) {
	
			$xtpl_ambitos->assign('data', $array_ambito[$column] );
			$xtpl_ambitos->assign('align', $aligns[$index]);
			$xtpl_ambitos->parse('main.ambito.ambito_data');
	
			$index++;
		}
	
	}
	
	
/**
	 * parseamos el listado de presupuestos.
	 * @param ItemCollection $presupuestos
	 * @param CMPForm $form
	 * @param XTemplate $xtpl_presupuestos
	 */
	protected function parsePresupuestos(ItemCollection $presupuestos=null, CMPForm $form, XTemplate $xtpl_presupuestos){
		$total = 0;
		if( $presupuestos!= null ){
			foreach ($presupuestos as $presupuesto) {
		   
				$this->parsePresupuesto($presupuesto, $xtpl_presupuestos);
		   		$total +=$presupuesto->getNu_montopresupuesto();
				if( $form->getIsEditable() ){
					$xtpl_presupuestos->assign('item_oid',$presupuesto->getDs_presupuesto());
					$xtpl_presupuestos->parse("main.presupuesto.editar_presupuesto");
				}
		   
				$xtpl_presupuestos->parse("main.presupuesto");
			}
		}
		$xtpl_presupuestos->assign('total_lbl',CYT_LBL_PRESUPUESTO_TOTAL);
		$xtpl_presupuestos->assign('total',CYTSecureUtils::formatMontoToView($total));
	}
	
	/**
	 * parseamos un presupuesto.
	 * @param Presupuesto $presupuesto
	 * @param XTemplate $xtpl_presupuestos
	 */
	protected function parsePresupuesto(Presupuesto $presupuesto, XTemplate $xtpl_presupuestos){
	
		$columns = $this->getPresupuestoColumns();
		$aligns = $this->getPresupuestoColumnsAlign();
		$array_presupuesto = $this->buildArrayPresupuesto($presupuesto);
	
		$index=0;
		foreach ($columns as $column) {
	
			$xtpl_presupuestos->assign('data', $array_presupuesto[$column] );
			$xtpl_presupuestos->assign('align', $aligns[$index]);
			$xtpl_presupuestos->parse('main.presupuesto.presupuesto_data');
	
			$index++;
		}
	
	}

	
	
	
	
	
}