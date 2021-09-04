<?php

/**
 * Formulario para monto de solicitud
 *  
 * @author Marcos
 * @since 02-01-2014
 */
class CMPMontoForm extends CMPForm{


	public function getLegend(){
		return '<div style="color:#A43B3B; font-weight:bold">'.CYT_MSG_ASIGNAR_AVISO.'</div>';
	}
	
	/**
	 * se construye el formulario para editar un detalle de venta
	 */
	public function __construct($action="add_monto_session",$id="edit_monto") {

		parent::__construct($id, CYT_MSG_ASIGNAR);
		
		$this->setCancelLabel( null );
		
		//properties del form.
    	$this->addProperty("method", "POST");
		$this->setAction("doAction?action=$action");
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );
		
		$this->setUseAjaxSubmit( true );
		
		$this->getRenderer()->setTemplateName( CDT_CMP_TEMPLATE_FORM_INLINE );
		
		$this->setOnSuccessCallback("add_monto");
		$this->setBeforeSubmit("before_submit_monto");
		

		$fieldset = new FormFieldset( $this->getLegend() );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_MONTO_INSTITUCION, "ds_institucion", CYT_MSG_MONTO_INSTITUCION_REQUIRED,"",25) );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_MONTO_CARACTER, "ds_caracter", CYT_MSG_MONTO_CARACTER_REQUIRED,"",25) );
		
		$fieldset->addField( FieldBuilder::buildFieldNumber ( CYT_LBL_MONTO_IMPORTE, "nu_monto", CYT_MSG_MONTO_IMPORTE_REQUIRED,"",10) );
		
		
		$this->addFieldset($fieldset);
		
    }
    
}
?>
