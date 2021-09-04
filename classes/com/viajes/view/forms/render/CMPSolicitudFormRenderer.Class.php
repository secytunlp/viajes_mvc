<?php

/**
 * Implementación para renderizar un formulario de solicitud 
 *
 * @author Marcos
 * @since 11-12-2013
 *
 */
class CMPSolicitudFormRenderer extends DefaultFormRenderer {

	 protected function getXTemplate() {
    	return new XTemplate( CYT_TEMPLATE_SOLICITUD_FORM );
    }
	
	
	protected function renderFieldset(CMPForm $form, XTemplate $xtpl){
		$xtpl->assign("titulo_domicilio", CYT_MSG_SOLICITUD_DOMICILIO_TITULO);
		$xtpl->assign("titulo_proyectos", CYT_MSG_SOLICITUD_PROYECTOS_TITULO);
		$xtpl->assign("titulo_tipo_investigador", CYT_MSG_SOLICITUD_TIPO_INVESTIGADOR_TITULO);
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
			$xtpl->assign("domicilio_tab", CYT_MSG_SOLICITUD_TAB_DOMICILIO);
			$fieldCalle = $fields['ds_calle'];		
			$input = $fieldCalle->getInput();
			$label = $fieldCalle->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldCalle->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_calle");
			
			$fieldNro = $fields['nu_nro'];		
			$input = $fieldNro->getInput();
			$label = $fieldNro->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldNro->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.nu_nro");
			
			$fieldPiso = $fields['nu_piso'];		
			$input = $fieldPiso->getInput();
			$label = $fieldPiso->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldPiso->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.nu_piso");
			
			$fieldDepto = $fields['ds_depto'];		
			$input = $fieldDepto->getInput();
			$label = $fieldDepto->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldDepto->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_depto");
			
			$fieldCP = $fields['nu_cp'];		
			$input = $fieldCP->getInput();
			$label = $fieldCP->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldCP->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.nu_cp");
			$fieldMail = $fields['ds_mail'];		
			$input = $fieldMail->getInput();
			$label = $fieldMail->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldMail->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_mail");
			$fieldMail = $fields['ds_googleScholar'];		
			$input = $fieldMail->getInput();
			$xtpl->assign("label_googleScholar", CYT_LBL_SOLICITUD_GOOGLESCHOLAR_LABEL);
			$xtpl->assign("label_googleScholar2", CYT_LBL_SOLICITUD_GOOGLESCHOLAR_LABEL2);
			$label = $fieldMail->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldMail->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_googleScholar");
			
			$fieldNotificacion = $fields['bl_notificacion'];		
			$input = $fieldNotificacion->getInput();
			$label = $fieldNotificacion->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldNotificacion->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.bl_notificacion");
			$fieldTelefono = $fields['nu_telefono'];		
			$input = $fieldTelefono->getInput();
			$label = $fieldTelefono->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldTelefono->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.nu_telefono");
			
			$xtpl->assign("universidad_tab", CYT_MSG_SOLICITUD_TAB_UNIVERSIDAD);
			/*$fieldTitulo = $fields['ds_titulogrado'];		
			$input = $fieldTitulo->getInput();
			$label = $fieldTitulo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldTitulo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_titulogrado");*/
			
			$field = $fields['solicitud_filter_titulo_oid'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.solicitud_filter_titulo_oid");
			
			$fieldLugarTrabajo = $fields['solicitud_filter_lugarTrabajo_oid'];		
			$input = $fieldLugarTrabajo->getInput();
			$label = $fieldLugarTrabajo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldLugarTrabajo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.solicitud_filter_lugarTrabajo_oid");
			
			$fieldDireccion = $fields['ds_direccion'];		
			$input = $fieldDireccion->getInput();
			$label = $fieldDireccion->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldDireccion->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_direccion");
			
			$fieldTelefono = $fields['ds_telefono'];		
			$input = $fieldTelefono->getInput();
			$label = $fieldTelefono->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldTelefono->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_telefono");
			
			$fieldCargo = $fields['cargo_oid'];		
			$input = $fieldCargo->getInput();
			$xtpl->assign("label_cargo_dedicacion", CYT_LBL_SOLICITUD_CARGO_DEDICACION_LABEL);
			$label = $fieldCargo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldCargo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.cargo_oid");
			
			$fieldDedDoc = $fields['deddoc_oid'];		
			$input = $fieldDedDoc->getInput();
			
			$label = $fieldDedDoc->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldDedDoc->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.deddoc_oid");
			
			$fieldFacultad = $fields['facultad_oid'];		
			$input = $fieldFacultad->getInput();
			$label = $fieldFacultad->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldFacultad->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.facultad_oid");
			
			$fieldDisciplina = $fields['ds_disciplina'];		
			$input = $fieldDisciplina->getInput();
			$label = $fieldDisciplina->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldDisciplina->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_disciplina");
			
			$fieldCategoria = $fields['categoria_oid'];		
			$input = $fieldCategoria->getInput();
			$label = $fieldCategoria->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldCategoria->getMinWidth());
			/*$categorizado = 0;
			if ((in_array($input->getInputValue(), explode(",",CYT_CATEGORIA_FORMADOS)))||(in_array($input->getInputValue(), explode(",",CYT_CATEGORIA_NO_FORMADOS)))) {
				
				$categorizado = 1;
			}*/
			$formado = 0;
			if ((in_array($input->getInputValue(), explode(",",CYT_CATEGORIA_FORMADOS)))) {
				
				$formado = 1;
			}
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.categoria_oid");
			
			$xtpl->assign("becario_tab", CYT_MSG_SOLICITUD_TAB_BECARIO);
			$fieldUNLP = $fields['bl_unlp'];		
			$input = $fieldUNLP->getInput();
			$label = $fieldUNLP->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldUNLP->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.bl_unlp");
			
			$fieldOrgBeca = $fields['ds_orgbeca'];		
			$input = $fieldOrgBeca->getInput();
			$label = $fieldOrgBeca->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldOrgBeca->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_orgbeca");
			
			$fieldTipoBeca = $fields['ds_tipobeca'];		
			$input = $fieldTipoBeca->getInput();
			$label = $fieldTipoBeca->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldTipoBeca->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_tipobeca");
			
			$fieldPeriodoBeca = $fields['ds_periodobeca'];		
			$input = $fieldPeriodoBeca->getInput();
			$label = $fieldPeriodoBeca->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldPeriodoBeca->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_periodobeca");
			
			$fieldLugarTrabajoBeca = $fields['solicitud_filter_lugarTrabajoBeca_oid'];		
			$input = $fieldLugarTrabajoBeca->getInput();
			$label = $fieldLugarTrabajoBeca->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldLugarTrabajoBeca->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.solicitud_filter_lugarTrabajoBeca_oid");
			
			$xtpl->assign("carrerainv_tab", CYT_MSG_SOLICITUD_TAB_CARRERAINV);
			
			$fieldInstitucion = $fields['organismo_oid'];		
			$input = $fieldInstitucion->getInput();
			$label = $fieldInstitucion->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldInstitucion->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.organismo_oid");
			
			$fieldCarreraInv = $fields['carrerainv_oid'];		
			$input = $fieldCarreraInv->getInput();
			$label = $fieldCarreraInv->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldCarreraInv->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.carrerainv_oid");
			
			$fieldIngreso = $fields['dt_ingreso'];		
			$input = $fieldIngreso->getInput();
			$label = $fieldIngreso->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldIngreso->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.dt_ingreso");
			
			$fieldLugarTrabajoCarrerainv = $fields['solicitud_filter_lugarTrabajoCarrerainv_oid'];		
			$input = $fieldLugarTrabajoCarrerainv->getInput();
			$label = $fieldLugarTrabajoCarrerainv->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldLugarTrabajoCarrerainv->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.solicitud_filter_lugarTrabajoCarrerainv_oid");
			
			$xtpl->assign("proyectos_tab", CYT_MSG_SOLICITUD_TAB_PROYECTOS);
			$HTMLProyectos = $this->getHTMLProyectos($xtpl);
			$xtpl->assign("HTMLProyectos", $HTMLProyectos);
			
			$xtpl->assign("tipoinvestigador_tab", CYT_MSG_SOLICITUD_TAB_TIPO_INVESTIGADOR);
			$fieldFacultadplanilla = $fields['facultadplanilla_oid'];		
			$input = $fieldFacultadplanilla->getInput();
			$label = $fieldFacultadplanilla->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldFacultadplanilla->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.facultadplanilla_oid");
			
			$fieldTipoinvestigador = $fields['tipoinvestigador_oid'];		
			$input = $fieldTipoinvestigador->getInput();
			/*if ($categorizado) {
				$input->setIsEditable(false);
			}
			else {
				$xtpl->assign("label_tipoinvestigador", CYT_LBL_SOLICITUD_TIPO_INVESTIGADOR_LABEL);
			}*/
			if ($formado) {
				$input->setIsEditable(false);
			}
			
			$xtpl->assign("label_tipoinvestigador", CYT_LBL_SOLICITUD_TIPO_INVESTIGADOR_LABEL_2);
			
			$label = $fieldTipoinvestigador->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldTipoinvestigador->getMinWidth());
					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.tipoinvestigador_oid");
			
			$xtpl->assign("motivo_tab", CYT_MSG_SOLICITUD_TAB_MOTIVO);
			$fieldMonto = $fields['nu_monto'];		
			$input = $fieldMonto->getInput();
			$label = $fieldMonto->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldMonto->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.nu_monto");
			
			$fieldMotivo = $fields['motivo_oid'];		
			$input = $fieldMotivo->getInput();
			$label = $fieldMotivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldMotivo->getMinWidth());
			$xtpl->assign("label_motivo", CYT_LBL_SOLICITUD_ARCHIVO_SIZE);					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.motivo_oid");
			
			$fieldObjetivo = $fields['ds_objetivo'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_objetivo");
			
			$fieldObjetivo = $fields['ds_relevanciaA'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_relevanciaA");
			
			//$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			$xtpl->assign("value", CYT_LBL_SOLICITUD_A_CURRICULUM );
			$xtpl->assign("required", "*" );
			$xtpl->parse("main.ds_curriculum.label");
			$xtpl->assign("actionFile", "doAction?action=add_file_session" );
			$xtpl->parse("main.ds_curriculum.input");
			$xtpl->assign("display", 'block');
			$xtpl->assign("label_curriculum", CYT_LBL_SOLICITUD_A_CURRICULUM_SIGEVA);
			$hiddens = $form->getHiddens();
			$hiddenDs_curriculum = $hiddens['ds_curriculum'];	
				
			if ($hiddenDs_curriculum->getInputValue()) {
				$xtpl->assign("ds_curriculum_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_curriculum->getInputValue().'</span>');
			}
			$xtpl->parse("main.ds_curriculum");
			
			$fieldTipoEvento = $fields['bl_congreso'];		
			$input = $fieldTipoEvento->getInput();
			$label = $fieldTipoEvento->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldTipoEvento->getMinWidth());
			$xtpl->assign("label_motivo", CYT_LBL_SOLICITUD_ARCHIVO_SIZE);					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.bl_congreso");
			
			$xtpl->assign("value", "" );
			$xtpl->assign("required", "" );
			$xtpl->parse("main.ds_trabajo.label");
			$xtpl->parse("main.ds_trabajo.input");
			$xtpl->assign("display", 'none');
			
			$hiddenDs_trabajo = $hiddens['ds_trabajo'];		
			if ($hiddenDs_trabajo->getInputValue()) {
				$xtpl->assign("ds_trabajo_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_trabajo->getInputValue().'</span>');
			}
			
			$xtpl->parse("main.ds_trabajo");
			
			$xtpl->assign("value", "" );
			$xtpl->assign("required", "" );
			$xtpl->parse("main.ds_aceptacion.label");
			$xtpl->parse("main.ds_aceptacion.input");
			$xtpl->assign("display", 'none');
		
			$hiddenDs_aceptacion = $hiddens['ds_aceptacion'];		
			if ($hiddenDs_aceptacion->getInputValue()) {
				$xtpl->assign("ds_aceptacion_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_aceptacion->getInputValue().'</span>');
			}
			
			$xtpl->parse("main.ds_aceptacion");
			
			$fieldTituloTrabajo = $fields['ds_titulotrabajo'];		
			$input = $fieldTituloTrabajo->getInput();
			$label = $fieldTituloTrabajo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldTituloTrabajo->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_titulotrabajo");
			
			$fieldAutorTrabajo = $fields['ds_autorestrabajo'];		
			$input = $fieldAutorTrabajo->getInput();
			$label = $fieldAutorTrabajo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldAutorTrabajo->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_autorestrabajo");
			
			$field = $fields['ds_congreso'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_congreso");
			
			$field = $fields['bl_nacional'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.bl_nacional");
			
			$field = $fields['ds_lugartrabajo'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_lugartrabajo");
			
			$field = $fields['dt_fechatrabajo'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.dt_fechatrabajo");
			
			$field = $fields['dt_fechatrabajohasta'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.dt_fechatrabajohasta");
			
			$field = $fields['ds_relevanciatrabajo'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_relevanciatrabajo");
			
			$field = $fields['ds_resumentrabajo'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_resumentrabajo");
			
			$field = $fields['ds_modalidadtrabajo'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_modalidadtrabajo");
			
			$xtpl->assign("value", CYT_LBL_SOLICITUD_B_INVITACION );
			$xtpl->assign("required", "*" );
			$xtpl->parse("main.ds_invitaciongrupo.label");
			$xtpl->parse("main.ds_invitaciongrupo.input");
			$xtpl->assign("display", 'none');
			
			$hiddenDs_invitaciongrupo = $hiddens['ds_invitaciongrupo'];		
			if ($hiddenDs_invitaciongrupo->getInputValue()) {
				$xtpl->assign("ds_invitaciongrupo_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_invitaciongrupo->getInputValue().'</span>');
			}
			
			$xtpl->parse("main.ds_invitaciongrupo");
			
			$xtpl->assign("value", CYT_LBL_SOLICITUD_B_AVAL );
			$xtpl->assign("required", "" );
			$xtpl->parse("main.ds_aval.label");
			$xtpl->parse("main.ds_aval.input");
			$xtpl->assign("display", 'none');
			
			$hiddenDs_aval = $hiddens['ds_aval'];		
			if ($hiddenDs_aval->getInputValue()) {
				$xtpl->assign("ds_aval_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_aval->getInputValue().'</span>');
			}
			
			$xtpl->parse("main.ds_aval");
			
			$xtpl->assign("value", CYT_LBL_SOLICITUD_B_CONVENIO );
			$xtpl->assign("required", "" );
			$xtpl->parse("main.ds_convenio.label");
			$xtpl->parse("main.ds_convenio.input");
			$xtpl->assign("display", 'none');
			
			$hiddenDs_convenio = $hiddens['ds_convenio'];		
			if ($hiddenDs_convenio->getInputValue()) {
				$xtpl->assign("ds_convenio_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_convenio->getInputValue().'</span>');
			}
			
			$xtpl->parse("main.ds_convenio");
			$fieldObjetivo = $fields['ds_generalB'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_generalB");
			$fieldObjetivo = $fields['ds_especificoB'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_especificoB");
			$fieldObjetivo = $fields['ds_actividadesB'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_actividadesB");
			$fieldObjetivo = $fields['ds_cronogramaB'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_cronogramaB");
			$fieldObjetivo = $fields['ds_justificacionB'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_justificacionB");
			$fieldObjetivo = $fields['ds_aportesB'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_aportesB");
			
			
			
			
			
			$fieldObjetivo = $fields['ds_relevanciaB'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_relevanciaB");
			
			$xtpl->assign("value", CYT_LBL_SOLICITUD_C_CURRICULUM_VISITANTE );
			$xtpl->assign("required", "*" );
			$xtpl->parse("main.ds_cvprofesor.label");
			$xtpl->parse("main.ds_cvprofesor.input");
			$xtpl->assign("display", 'none');
		
			$hiddenDs_cvprofesor = $hiddens['ds_cvprofesor'];		
			if ($hiddenDs_cvprofesor->getInputValue()) {
				$xtpl->assign("ds_cvprofesor_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_cvprofesor->getInputValue().'</span>');
			}
			$xtpl->parse("main.ds_cvprofesor");
			
			$field = $fields['ds_profesor'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_profesor");
			
			$field = $fields['ds_lugarprofesor'];		
			$input = $field->getInput();
			$label = $field->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $field->getMinWidth());					
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');	
			}
			else $xtpl->assign("display", 'none');
			$xtpl->parse("main.ds_lugarprofesor");
			
			$fieldObjetivo = $fields['ds_objetivoC'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_objetivoC");
			$fieldObjetivo = $fields['ds_planC'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_planC");
			$fieldObjetivo = $fields['ds_relacionProyectoC'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_relacionProyectoC");
			$fieldObjetivo = $fields['ds_aportesC'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_aportesC");
			$fieldObjetivo = $fields['ds_actividadesC'];		
			$input = $fieldObjetivo->getInput();
			$label = $fieldObjetivo->getLabel();	
			$this->renderLabelTab( $label, $input, $xtpl );
			$this->renderInputTab( $input, $xtpl );
			$xtpl->assign("minWidth", $fieldObjetivo->getMinWidth());
			
			if( $input->getIsVisible() ){
				$xtpl->assign("display", 'block');
				
			}
			else $xtpl->assign("display", 'none');
			
			$xtpl->parse("main.ds_actividadesC");
		} 
	}

	
	
	
	/**
	 * renderizamos en el formulario de solicitud los proyectos que tiene en ejecucion.
	 
	 *
	 * @param CMPForm $form
	 * @param XTemplate $xtpl
	 */
	protected function getHTMLProyectos(XTemplate $xtpl){
	
		$xtpl_proyectos = new XTemplate( CYT_TEMPLATE_SOLICITUD_EDIT_PROYECTOS );
	
		//mostrar las proyectos actuales.
		//$xtpl_proyectos->assign('proyectos_title', CYT_MSG_UNIDAD_FACULTAD );
	
		//TODO parsear labels.
		$this->parseProyectosLabels($xtpl_proyectos);
		 
		//recuperamos las proyectos de la unidad desde la sesión.
		$manager = new SolicitudProyectoSessionManager();
		$proyectos = $manager->getEntities( new CdtSearchCriteria() );
		 
		//parseamos los proyectos.
		$this->parseProyectos($proyectos, $xtpl_proyectos);
		 
		
		$xtpl_proyectos->parse("main");
	
		return $xtpl_proyectos->text("main");
	
	}
	
	/**
	 * renderizamos en el formulario de solicitud los ambitos.
	 
	 *
	 * @param CMPForm $form
	 * @param XTemplate $xtpl
	 */
	protected function getHTMLAmbitos(CMPForm $form){	

		$xtpl_ambitos = new XTemplate( CYT_TEMPLATE_SOLICITUD_EDIT_AMBITOS );
		
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
    		$ambitoForm = new CMPAmbitoForm();
			$xtpl_ambitos->assign('formulario', $ambitoForm->show() );
    	}
		$xtpl_ambitos->parse("main");
		
		return $xtpl_ambitos->text("main") ;

	}
	
/**
	 * renderizamos en el formulario de solicitud los montos.
	 
	 *
	 * @param CMPForm $form
	 * @param XTemplate $xtpl
	 */
	protected function getHTMLMontos(CMPForm $form){	

		$xtpl_montos = new XTemplate( CYT_TEMPLATE_SOLICITUD_EDIT_MONTOS );
		
		//mostrar los montos actuales.
		$xtpl_montos->assign('montos_title', CYT_MSG_SOLICITUD_MONTOS_TITULO );
		
    	//TODO parsear labels.
    	$this->parseMontosLabels($xtpl_montos);
    	
		//recuperamos los montos de la solicitud desde la sesión.
		$manager = new MontoSessionManager();
    	$montos = $manager->getEntities( new CdtSearchCriteria() );
    	
    	//parseamos los montos.
    	$this->parseMontos($montos, $form, $xtpl_montos);
    	
    	//formulario para agregar un nuevo monto a la solicitud.
    	if( $form->getIsEditable() ){
    		$montoForm = new CMPMontoForm();
			$xtpl_montos->assign('formulario', $montoForm->show() );
    	}
		$xtpl_montos->parse("main");
		
		return $xtpl_montos->text("main") ;

	}
	
/**
	 * renderizamos en el formulario de solicitud los presupuestos.
	 
	 *
	 * @param CMPForm $form
	 * @param XTemplate $xtpl
	 */
	protected function getHTMLPresupuesto(CMPForm $form){	

		$xtpl_presupuestos = new XTemplate( CYT_TEMPLATE_SOLICITUD_EDIT_PRESUPUESTOS );
		
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
    		$presupuestoForm = new CMPPresupuestoForm();
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
		
		$xtpl_relaciones = new XTemplate( CYT_TEMPLATE_SOLICITUD_EDIT_SOLICITUD_RELACIONES );
		
		//ambitos
		$ambitosHTML = $this->getHTMLAmbitos($form);
		$xtpl_relaciones->assign( "ambitos_tab", CYT_MSG_SOLICITUD_TAB_AMBITOS );
		$xtpl_relaciones->assign( "ambitos", $ambitosHTML );
		
		//montos
		$montosHTML = $this->getHTMLMontos($form);
		$xtpl_relaciones->assign( "montos_tab", CYT_MSG_SOLICITUD_TAB_MONTOS );
		$xtpl_relaciones->assign( "montos", $montosHTML );
		
		//presupuestos
		$presupuestosHTML = $this->getHTMLPresupuesto($form);
		$xtpl_relaciones->assign( "presupuestos_tab", CYT_MSG_SOLICITUD_TAB_PRESUPUESTOS );
		$xtpl_relaciones->assign( "presupuestos", $presupuestosHTML );
		
		$xtpl_relaciones->parse("main");
		
		
		
		$xtpl->assign( "customHTML", $xtpl_relaciones->text("main").$form->getCustomHTML());
	}	
	
	
	
	/**
	 * armamos un array con los datos del proyecto.
	 * @param Proyecto $solicitudProyecto
	 */
	public function buildArrayProyecto(SolicitudProyecto $solicitudProyecto){
	
		$array_proyecto = array();
	
		//$array_proyecto["item_oid"] = $solicitudProyecto->getOid();
		$array_proyecto["item_oid"] = $solicitudProyecto->getProyecto()->getOid();
		
		/*$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_proyecto', $solicitudProyecto->getOid(), '=');
		$oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
		$managerProyecto =  CYTSecureManagerFactory::getProyectoManager();
		$oProyecto = $managerProyecto->getEntity($oCriteria);*/
		$array_proyecto["bl_seleccionado"] = $solicitudProyecto->getBl_seleccionado();
		$array_proyecto["ds_codigo"] = $solicitudProyecto->getProyecto()->getDs_codigo();
		$array_proyecto["ds_director"] = $solicitudProyecto->getProyecto()->getDirector()->getDs_apellido().', '.$solicitudProyecto->getProyecto()->getDirector()->getDs_nombre();
		$array_proyecto["ds_titulo"] = $solicitudProyecto->getProyecto()->getDs_titulo();
		$array_proyecto["dt_inicio"] = CYTSecureUtils::formatDateToView($solicitudProyecto->getDt_alta());
		$array_proyecto["dt_fin"] = CYTSecureUtils::formatDateToView($solicitudProyecto->getDt_baja());
		$array_proyecto["ds_estado"] = $solicitudProyecto->getProyecto()->getTipoEstadoProyecto()->getDs_estado();
	
		return $array_proyecto;
	
	}
	/**
	 * columnas para el listado de proyectos
	 * @return multitype:string
	 */
	public function getProyectoColumns(){
		return array( "bl_seleccionado","ds_codigo","ds_titulo","ds_director","dt_inicio","dt_fin","ds_estado");
	}
	
	/**
	 * labels para el listado de proyectos
	 * @return multitype:string
	 */
	public function getProyectoColumnsLabels(){
		return array( CYT_LBL_SOLICITUD_PROYECTOS_ELEGIDO,CYT_LBL_SOLICITUD_PROYECTOS_CODIGO,CYT_LBL_SOLICITUD_PROYECTOS_TITULO,CYT_LBL_SOLICITUD_PROYECTOS_DIRECTOR,CYT_LBL_SOLICITUD_PROYECTOS_INICIO,CYT_LBL_SOLICITUD_PROYECTOS_FIN,CYT_LBL_SOLICITUD_PROYECTOS_ESTADO);
	}
	
	/**
	 * aligns para las columnas del listado de facultades.
	 * @return multitype:string
	 */
	public function getProyectoColumnsAlign(){
		return array("center","center","left","left","center","center","left");
	}
		
	/**
	 * parseamos los labels para el listado de proyectos.
	 * @param XTemplate $xtpl_facultades
	 */
	protected function parseProyectosLabels(XTemplate $xtpl_proyectos){
	
		$aligns = $this->getProyectoColumnsAlign();
	
		$index=0;
		foreach ( $this->getProyectoColumnsLabels() as $label) {
	
			$xtpl_proyectos->assign('proyecto_label', $label );
			$xtpl_proyectos->assign('align', $aligns[$index]);
			$xtpl_proyectos->parse('main.proyecto_th');
	
			$index++;
		}
	}
	
	
	/**
	 * parseamos el listado de proyectos.
	 * @param ItemCollection $proyectos
	 * @param CMPForm $form
	 * @param XTemplate $xtpl_proyectos
	 */
	protected function parseProyectos(ItemCollection $proyectos=null, XTemplate $xtpl_proyectos){
	
		if( $proyectos!= null ){
			foreach ($proyectos as $proyecto) {
				 
				$this->parseProyecto($proyecto, $xtpl_proyectos);
				 
				/*if( $form->getIsEditable() ){
					$xtpl_proyectos->assign('item_oid', $proyecto->getFacultad()->getOid() );
					$xtpl_proyectos->parse("main.proyecto.editar_proyecto");
				}*/
				 
				$xtpl_proyectos->parse("main.proyecto");
			}
		}
	}
	
	/**
	 * parseamos un proyecto.
	 * @param UnidadFacultad $proyecto
	 * @param XTemplate $xtpl_proyectos
	 */
	protected function parseProyecto(SolicitudProyecto $solicitudProyecto, XTemplate $xtpl_proyectos){
	
		$columns = $this->getProyectoColumns();
		$aligns = $this->getProyectoColumnsAlign();
		$disabled=($solicitudProyecto->getDt_baja()<date('Y-m-d'))?' DISABLED ':'';
		$array_proyecto = $this->buildArrayProyecto($solicitudProyecto);
		
		
		$index=0;
		foreach ($columns as $column) {

			$checked = (($column=='bl_seleccionado')&&($array_proyecto[$column]==1))?' checked ':'';
			
			$data=($column=='bl_seleccionado')?"<input ".$disabled." type='checkbox' name='bl_seleccionado' value=''".$checked." onclick='javascript: seleccionar_proyecto(encodeURI(".$array_proyecto['item_oid']."), this);'>":$array_proyecto[$column];  

			$xtpl_proyectos->assign('data', $data );
			$xtpl_proyectos->assign('align', $aligns[$index]);
			$xtpl_proyectos->parse('main.proyecto.proyecto_data');
	
			$index++;
		}
	
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
	 * armamos un array con los datos del monto.
	 * @param Monto $monto
	 */
	public function buildArrayMonto(Monto $monto){

		$array_monto = array();
		
		$array_monto["item_oid"] = $monto->getDs_institucion();
		$array_monto["ds_institucion"] = $monto->getDs_institucion();
		$array_monto["ds_caracter"] = $monto->getDs_caracter();
		$array_monto["nu_monto"] = CYTSecureUtils::formatMontoToView($monto->getNu_monto());
		
		
		return $array_monto;
		
	}
	
/**
	 * columnas para el listado de montos
	 * @return multitype:string
	 */	
	public function getMontoColumns(){
		return array( "ds_institucion","ds_caracter", "nu_monto");
	}
	
/**
	 * labels para el listado de montos
	 * @return multitype:string
	 */
	public function getMontoColumnsLabels(){
		return array( CYT_LBL_MONTO_INSTITUCION, CYT_LBL_MONTO_CARACTER, CYT_LBL_MONTO_IMPORTE);
	}
	
	/**
	 * aligns para las columnas del listado de montos.
	 * @return multitype:string
	 */
	public function getMontoColumnsAlign(){
		return array( "left", "left", "right");
	}
	
	
/**
	 * parseamos los labels para el listado de montos.
	 * @param XTemplate $xtpl_montos
	 */
	protected function parseMontosLabels(XTemplate $xtpl_montos){
	
		$aligns = $this->getMontoColumnsAlign();
	
		$index=0;
		foreach ( $this->getMontoColumnsLabels() as $label) {
				
			$xtpl_montos->assign('monto_label', $label );
			$xtpl_montos->assign('align', $aligns[$index]);
			$xtpl_montos->parse('main.monto_th');
				
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
	 * parseamos el listado de montos.
	 * @param ItemCollection $montos
	 * @param CMPForm $form
	 * @param XTemplate $xtpl_montos
	 */
	protected function parseMontos(ItemCollection $montos=null, CMPForm $form, XTemplate $xtpl_montos){
		
		if( $montos!= null ){
			foreach ($montos as $monto) {
		   
				$this->parseMonto($monto, $xtpl_montos);
		   
				if( $form->getIsEditable() ){
					$xtpl_montos->assign('item_oid',$monto->getDs_institucion());
					$xtpl_montos->parse("main.monto.editar_monto");
				}
		   
				$xtpl_montos->parse("main.monto");
			}
		}
	}
	
	/**
	 * parseamos un monto.
	 * @param Monto $monto
	 * @param XTemplate $xtpl_montos
	 */
	protected function parseMonto(Monto $monto, XTemplate $xtpl_montos){
	
		$columns = $this->getMontoColumns();
		$aligns = $this->getMontoColumnsAlign();
		$array_monto = $this->buildArrayMonto($monto);
	
		$index=0;
		foreach ($columns as $column) {
	
			$xtpl_montos->assign('data', $array_monto[$column] );
			$xtpl_montos->assign('align', $aligns[$index]);
			$xtpl_montos->parse('main.monto.monto_data');
	
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