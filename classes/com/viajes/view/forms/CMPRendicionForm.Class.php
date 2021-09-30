<?php

/**
 * Formulario para Rendicion
 *
 * @author Marcos
 * @since 29-09-2021
 */
class CMPRendicionForm extends CMPForm{



	public function getRenderer(){
		return new CMPRendicionFormRenderer();
	}

	/**
	 * se construye el formulario para editar el encomienda
	 */
	public function __construct($action="", $id="edit_rendicion") {

		parent::__construct($id);

		$fieldset = new FormFieldset( "" );
		$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CYT_LBL_SOLICITUD_SOLICITANTE, "ds_investigador", ""  ) );
		$fieldset->addField( FieldBuilder::buildFieldReadOnly ( CYT_LBL_SOLICITUD_CUIL, "nu_cuil", ""  ) );

		$input = FieldBuilder::buildFieldTextArea ( CYT_LBL_EVALUACION_OBSERVACIONES, "ds_observacion","","",8,100);
		$fieldset->addField( $input );


		$this->addFieldset($fieldset);

		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );
		$this->addHidden( FieldBuilder::buildInputHidden ( "solicitud.oid", "") );

		$this->addHidden( FieldBuilder::buildInputHidden ( "ds_informe", "") );
        $this->addHidden( FieldBuilder::buildInputHidden ( "ds_certificado", "") );
        $this->addHidden( FieldBuilder::buildInputHidden ( "ds_rendicion", "") );
        $this->addHidden( FieldBuilder::buildInputHidden ( "motivo_oid", "") );


		//properties del form.
		$this->addProperty("method", "POST");
		$this->addProperty("enctype", "multipart/form-data");
		$this->setAction("doAction?action=$action");
		$this->setOnCancel("window.location.href = 'doAction?action=list_rendiciones';");
		$this->setUseAjaxSubmit( true );
		//$this->setOnSuccessCallback("successTest");
		//$this->setUseAjaxCallback( true );
		//$this->setIdAjaxCallback( "content-left" );
		//$this->setCustomHTML('<script> $(function() {$("#motivo_oid").change();});</script>');
	}


}
?>
