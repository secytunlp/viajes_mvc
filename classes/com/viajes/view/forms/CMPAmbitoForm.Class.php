<?php

/**
 * Formulario para ambito de solicitud
 *  
 * @author Marcos
 * @since 20-12-2013
 */
class CMPAmbitoForm extends CMPForm{


public function getLegend(){
		return '<div style="color:#A43B3B; font-weight:bold">'.CYT_MSG_ASIGNAR_AVISO.'</div>';
	}
	
	/**
	 * se construye el formulario para editar un detalle de venta
	 */
	public function __construct($action="add_ambito_session",$id="edit_ambito") {

		parent::__construct($id, CYT_MSG_ASIGNAR);
		
		$this->setCancelLabel( null );
		
		//properties del form.
    	$this->addProperty("method", "POST");
		$this->setAction("doAction?action=$action");
		$this->addHidden( FieldBuilder::buildInputHidden ( "oid", "") );
		//$this->addHidden( FieldBuilder::buildInputHidden ( "solicitud.oid", "") );
		
		$this->setUseAjaxSubmit( true );
		
		$this->getRenderer()->setTemplateName( CDT_CMP_TEMPLATE_FORM_INLINE );
		
		$this->setOnSuccessCallback("add_ambito");
		$this->setBeforeSubmit("before_submit_ambito");
		

		$fieldset = new FormFieldset( $this->getLegend() );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_AMBITO_INSTITUCION, "ds_institucion", CYT_MSG_AMBITO_INSTITUCION_REQUIRED,"",13) );
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_AMBITO_CIUDAD, "ds_ciudad", CYT_MSG_AMBITO_CIUDAD_REQUIRED,"",13) );
		
		$fieldset->addField( FieldBuilder::buildFieldText ( CYT_LBL_AMBITO_PAIS, "ds_pais", CYT_MSG_AMBITO_PAIS_REQUIRED,"",13) );
		$fieldset->addField( FieldBuilder::buildFieldDate ( CYT_LBL_AMBITO_DESDE, "dt_desde", CYT_MSG_AMBITO_DESDE_REQUIRED) );
		$fieldset->addField( FieldBuilder::buildFieldDate ( CYT_LBL_AMBITO_HASTA, "dt_hasta", CYT_MSG_AMBITO_HASTA_REQUIRED) );
		
		$this->addFieldset($fieldset);
		
    }
    
}
?>
