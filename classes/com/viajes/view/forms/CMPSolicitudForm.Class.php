<?php

/**
 * Formulario para Solicitud
 *
 * @author Marcos
 * @since 11-12-2013
 */
class CMPSolicitudForm extends CMPForm{

	
	
	public function getRenderer(){
		return new CMPSolicitudFormRenderer();
	}
	
	/**
	 * se construye el formulario para editar el encomienda
	 */
	public function __construct($action="", $id="edit_solicitud") {

		parent::__construct($id);

		$fieldset = new FormFieldset( "" );
		$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CYT_LBL_SOLICITUD_SOLICITANTE, "ds_investigador", ""  ) );
		$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CYT_LBL_SOLICITUD_CUIL, "nu_cuil", ""  ) );
		
		
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_CALLE, "ds_calle") );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_CALLE_NRO, "nu_nro", "","",10) );
		
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_PISO, "nu_piso","","",10 ) );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_DEPTO, "ds_depto","", "",10) );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_CP, "nu_cp", "","",10) );
		$fieldset->addField( FieldBuilder::buildFieldEmail ( CYT_LBL_SOLICITUD_MAIL, "ds_mail", "","",40) );
		$field = FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_GOOGLESCHOLAR, "ds_googleScholar", "","",40);
		$field->getInput()->addProperty("placeholder", "https://scholar.google.com/citations?user=...=es");
		$fieldset->addField( $field );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_TELEFONO, "nu_telefono","","",10) );
		$fieldset->addField( FieldBuilder::buildFieldCheckbox ( CYT_LBL_SOLICITUD_MAIL_ACEPTO, "bl_notificacion", "bl_notificacion") );
		
		//$fieldTitulo = FieldBuilder::buildFieldEntityAutocomplete(CYT_LBL_SOLICITUD_TITULO, new CMPTituloAutocomplete(),"ds_titulogrado",CYT_MSG_SOLICITUD_TITULO_REQUIRED,"",60);
		
		$fieldTitulo = CYTSecureComponentsFactory::getFindTitulo(new Titulo(), CYT_LBL_SOLICITUD_TITULO, "", "solicitud_filter_titulo_oid", "titulo.oid","solicitud_filter_titulo_change");
		$fieldTitulo->getInput()->setInputSize(5,80);
		$fieldset->addField( $fieldTitulo );
		
		$findLugarTrabajo = CYTSecureComponentsFactory::getFindLugarTrabajo(new LugarTrabajo(), CYT_LBL_SOLICITUD_LUGAR_TRABAJO_EXTENDIDO, "", "solicitud_filter_lugarTrabajo_oid", "lugarTrabajo.oid","solicitud_filter_lugarTrabajo_change");
		$findLugarTrabajo->getInput()->setInputSize(5,80);
		$findLugarTrabajo->getInput()->setFunctionCallback("editSolicitud_lugarTrabajoCallback");
		$fieldset->addField( $findLugarTrabajo );
		
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_LUGAR_TRABAJO_DIRECCION, "ds_direccion") );
		
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_LUGAR_TRABAJO_TELEFONO, "ds_telefono") );
		
		$fieldCargo = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_CARGO, "cargo.oid", CYTSecureUtils::getCargosItems('1,2,3,4,5,6,7,8,9,10,11'), "", null, null, "--seleccionar--", "cargo_oid" );
		$fieldset->addField( $fieldCargo );
	
	  	$fieldDeddoc = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_DEDICACION, "deddoc.oid", CYTSecureUtils::getDeddocsItems('1,2,3,4'), "", null, null, "--seleccionar--", "deddoc_oid" );
		$fieldset->addField( $fieldDeddoc );
	
	  	$fieldFacultad = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_FACULTAD, "facultad.oid", CYTSecureUtils::getFacultadesItems(), "", null, null, "--seleccionar--", "facultad_oid" );
		$fieldset->addField( $fieldFacultad );
		
		$fieldCategoria = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_CATEGORIA, "categoria.oid", CYTSecureUtils::getCategoriasItems(), "", null, null, "--seleccionar--", "categoria_oid" );
		$fieldCategoria->getInput()->setIsEditable(false);
		$fieldset->addField( $fieldCategoria );
		
		$fieldBecarioUnlp = FieldBuilder::buildFieldCheckbox ( CYT_LBL_SOLICITUD_BECARIO_UNLP, "bl_unlp", "bl_unlp");
		$fieldBecarioUnlp->getInput()->setIsEditable(false);
		$fieldset->addField( $fieldBecarioUnlp );
		
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_ORGANISMO_BECA, "ds_orgbeca") );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_TIPO_BECA, "ds_tipobeca") );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_PERIODO_BECA, "ds_periodobeca") );
		
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_DISCIPLINA, "ds_disciplina","", "",90) );
		
		$findLugarTrabajo = CYTSecureComponentsFactory::getFindLugarTrabajo(new LugarTrabajo(), CYT_LBL_SOLICITUD_LUGAR_TRABAJO_BECA, "", "solicitud_filter_lugarTrabajoBeca_oid", "lugarTrabajoBeca.oid","solicitud_filter_lugarTrabajoBeca_change");
		$findLugarTrabajo->getInput()->setInputSize(5,80);
		$fieldset->addField( $findLugarTrabajo );
		
		$fieldOrganismo = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_INSTITUCION_CARRERAINV, "organismo.oid", CYTSecureUtils::getOrganismosItems(CYT_ORGANISMO_MOSTRADAS), "", null, null, "--seleccionar--", "organismo_oid" );
		$fieldset->addField( $fieldOrganismo );
		
		$fieldCarreraInv = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_CATEGORIA_CARRERAINV, "carrerainv.oid", CYTSecureUtils::getCarreraInvsItems(CYT_CARRERAINV_MOSTRADAS), "", null, null, "--seleccionar--", "carrerainv_oid" );
		$fieldset->addField( $fieldCarreraInv );
		
		$fieldset->addField( FieldBuilder::buildFieldDate ( CYT_LBL_SOLICITUD_INGRESO_CARRERAINV, "dt_ingreso") );
		
		$findLugarTrabajo = CYTSecureComponentsFactory::getFindLugarTrabajo(new LugarTrabajo(), CYT_LBL_SOLICITUD_LUGAR_TRABAJO_CARRERAINV, "", "solicitud_filter_lugarTrabajoCarrerainv_oid", "lugarTrabajoCarrera.oid","solicitud_filter_lugarTrabajoCarrerainv_change");
		$findLugarTrabajo->getInput()->setInputSize(5,80);
		$fieldset->addField( $findLugarTrabajo );
		
		$fieldFacultadplanilla = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_FACULTAD_PLANILLA, "facultadplanilla.oid", CYTSecureUtils::getFacultadesItems(), "", null, null, "--seleccionar--", "facultadplanilla_oid" );
		$fieldset->addField( $fieldFacultadplanilla );
		
		$fieldTipoInvestigador = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_TIPO_INVESTIGADOR, "tipoinvestigador.oid", CYTSecureUtils::getTiposInvestigadorItems(CYT_TIPO_INVESTIGADOR_MOSTRADOS), "", null, null, "--seleccionar--", "tipoinvestigador_oid" );
		$fieldset->addField( $fieldTipoInvestigador );
		
		$fieldset->addField( FieldBuilder::buildFieldNumber ( CYT_LBL_SOLICITUD_MONTO_SOLICITADO, "nu_monto", "", "", 10 ) );
		
		$fieldMotivo = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_MOTIVO, "motivo.oid", CYTUtils::getMotivosDescripcionItems(), "", null, null, "--seleccionar--", "motivo_oid" );
		$fieldMotivo->getInput()->addProperty( 'onChange', 'seleccionarMotivo(this)' );
		$fieldset->addField( $fieldMotivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_A_OBJETIVO, "ds_objetivo","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_A_RELEVANCIA, "ds_relevanciaA","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$fieldTipoEvento = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_A_TIPO_EVENTO, "bl_congreso", TipoEvento::getItems(), "", null, null, "--seleccionar--" );
		$fieldTipoEvento->getInput()->setIsVisible(false);
		$fieldTipoEvento->getInput()->addProperty( 'onChange', 'seleccionarTipoEvento(this)' );
		$fieldset->addField( $fieldTipoEvento );

		$field = FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_LINK_REUNION, "ds_linkreunion", "","",80);
		//$field->getInput()->addProperty("placeholder", "https://scholar.google.com/citations?user=...=es");
		$fieldset->addField( $field );
		
		$fieldTituloTrabajo = FieldBuilder::buildFieldText ( "", "ds_titulotrabajo", "","",80) ;
		$fieldTituloTrabajo->getInput()->setIsVisible(false);
		$fieldset->addField( $fieldTituloTrabajo );
		
		$fieldAutorTrabajo = FieldBuilder::buildFieldText ( "", "ds_autorestrabajo", "","",80) ;
		$fieldAutorTrabajo->getInput()->setIsVisible(false);
		$fieldset->addField( $fieldAutorTrabajo );
		
		$fieldAutorTrabajo = FieldBuilder::buildFieldText ( "", "ds_congreso", "","",80) ;
		$fieldAutorTrabajo->getInput()->setIsVisible(false);
		$fieldset->addField( $fieldAutorTrabajo );
		
		$fieldTipoEvento = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_A_CARACTER, "bl_nacional", Caracter::getItems(), null, null, "--seleccionar--" );
		$fieldTipoEvento->getInput()->setIsVisible(false);
		$fieldset->addField( $fieldTipoEvento );
		
		$field = FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_A_LUGAR, "ds_lugartrabajo") ;
		$field->getInput()->setIsVisible(false);
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_SOLICITUD_A_FECHA, "dt_fechatrabajo") ;
		$field->getInput()->setIsVisible(false);
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldDate ( CYT_LBL_SOLICITUD_A_FECHA_HASTA, "dt_fechatrabajohasta") ;
		$field->getInput()->setIsVisible(false);
		$fieldset->addField( $field );
		
		$input = FieldBuilder::buildFieldTextArea ( "", "ds_relevanciatrabajo","","",8,110);
		$input->getInput()->setIsVisible(false);
		$fieldset->addField( $input );
		
		$input = FieldBuilder::buildFieldTextArea ( "", "ds_resumentrabajo","","",8,110);
		$input->getInput()->setIsVisible(false);
		$fieldset->addField( $input );
		
		//$input = FieldBuilder::buildFieldTextArea ( "", "ds_modalidadtrabajo","","",8,110);
		$input = FieldBuilder::buildFieldText ( "", "ds_modalidadtrabajo", "","",80);
		$input->getInput()->setIsVisible(false);
		$fieldset->addField( $input );
		
		$field = FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_C_PROFESOR, "ds_profesor") ;
		$field->getInput()->setIsVisible(false);
		$fieldset->addField( $field );
		
		$field = FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_C_PROFESOR_LUGAR, "ds_lugarprofesor") ;
		$field->getInput()->setIsVisible(false);
		$fieldset->addField( $field );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_B_GENERAL, "ds_generalB","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_B_ESPECIFICO, "ds_especificoB","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_B_ACTIVIDADES, "ds_actividadesB","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_B_CRONOGRAMA, "ds_cronogramaB","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_B_JUSTIFICACION, "ds_justificacionB","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_B_APORTES, "ds_aportesB","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		

		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_B_RELEVANCIA, "ds_relevanciaB","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_C_OBJETIVO, "ds_objetivoC","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_C_PLAN, "ds_planC","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_C_RELACION, "ds_relacionProyectoC","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_C_APORTES, "ds_aportesC","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$inputObjetivo = FieldBuilder::buildFieldTextArea ( CYT_LBL_SOLICITUD_C_ACTIVIDADES, "ds_actividadesC","","",8,110);
		$inputObjetivo->getInput()->setIsVisible(false);
		$fieldset->addField( $inputObjetivo );
		
		$this->addFieldset($fieldset);
	
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "categoria.oid", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_curriculum", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_trabajo", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_aceptacion", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_invitaciongrupo", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_aval", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_convenio", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_cvprofesor", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "tipoinvestigador_oid", "") );

		//properties del form.
		$this->addProperty("method", "POST");
		$this->addProperty("enctype", "multipart/form-data");
		$this->setAction("doAction?action=$action");
		$this->setOnCancel("window.location.href = 'doAction?action=list_solicitudes';");
		$this->setUseAjaxSubmit( true );
		//$this->setOnSuccessCallback("successTest");
		//$this->setUseAjaxCallback( true );
		//$this->setIdAjaxCallback( "content-left" );
		$this->setCustomHTML('<script> $(function() {$("#motivo_oid").change();});</script>');
	}


}
?>
