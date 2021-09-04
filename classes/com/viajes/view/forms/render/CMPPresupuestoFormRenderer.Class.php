<?php
/**
 * Implementación para renderizar un formulario de resupuesto 
 *
 * @author Marcos
 * @since 02-01-2014
 *
 */
class CMPPresupuestoFormRenderer extends DefaultFormRenderer {
	
	
 	protected function getXTemplate() {
    	return new XTemplate( CYT_CMP_TEMPLATE_FORM_INLINE );
    }
	
	protected function renderFieldset(CMPForm $form, XTemplate $xtpl){

		foreach ($form->getFieldsets() as $fieldset) {
			
			//legend
			$legend = $fieldset->getLegend();
			if(!empty($legend)){
				$xtpl->assign("value", $legend);
				$xtpl->parse("main.fieldset.legend");
			}
			
			
			
			foreach ($fieldset->getFieldsColumns() as $column => $fields) {
				
				foreach ($fields as $formField) {
					
					$input = $formField->getInput();
					$label = $formField->getLabel();
					
					$this->renderLabel( $label, $input, $xtpl );
					$this->renderInput( $input, $xtpl );
					$xtpl->assign("minWidth", $formField->getMinWidth());
					
					if( $input->getIsVisible() ){
						$xtpl->assign("display", 'inline-block');
						
					}
					else $xtpl->assign("display", 'none');
					
					$xtpl->parse("main.fieldset.column.field");
				}
				$xtpl->parse("main.fieldset.column");
			}
			
			
			$xtpl->parse("main.fieldset");
		} 
	}

}