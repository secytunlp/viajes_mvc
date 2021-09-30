<?php

/**
 * Implementación para renderizar un formulario de rendicion
 *
 * @author Marcos
 * @since 29-09-2021
 *
 */
class CMPRendicionFormRenderer extends DefaultFormRenderer {

	 protected function getXTemplate() {
    	return new XTemplate( CYT_TEMPLATE_RENDICION_FORM );
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


				$xtpl->assign("display", 'block');



			$xtpl->parse("main.ds_observacion");

			$hiddens = $form->getHiddens();

			$xtpl->assign("value", CYT_LBL_RENDICION_INFORME );
			$xtpl->assign("required", "*" );
			$xtpl->parse("main.ds_informe.label");
			$xtpl->assign("actionFile", "doAction?action=add_file_session_rendicion&solicitud_oid=".$hiddens['solicitud.oid']->getInputValue() );
			$xtpl->parse("main.ds_informe.input");
			$xtpl->assign("display", 'block');



			$hiddenDs_informe = $hiddens['ds_informe'];

			if ($hiddenDs_informe->getInputValue()) {
				$xtpl->assign("ds_informe_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_informe->getInputValue().'</span>');
			}
			$xtpl->parse("main.ds_informe");

            $xtpl->assign("value", CYT_LBL_RENDICION_RENDICION );
            $xtpl->assign("required", "*" );
            $xtpl->parse("main.ds_rendicion.label");
            $xtpl->assign("actionFile", "doAction?action=add_file_session_rendicion&solicitud_oid=".$hiddens['solicitud.oid']->getInputValue() );
            $xtpl->parse("main.ds_rendicion.input");
            $xtpl->assign("display", 'block');



            $hiddenDs_rendicion = $hiddens['ds_rendicion'];

            if ($hiddenDs_rendicion->getInputValue()) {
                $xtpl->assign("ds_rendicion_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_rendicion->getInputValue().'</span>');
            }
            $xtpl->parse("main.ds_rendicion");

            $hiddenMotivo = $hiddens['motivo_oid'];

            switch ($hiddenMotivo->getInputValue()) {
                case 1:
                    $valueConstancia = CYT_LBL_RENDICION_CONSTANCIA_A;
                    break;

                case 2:
                    $valueConstancia = CYT_LBL_RENDICION_CONSTANCIA_B;
                    break;

                default:
                    $valueConstancia = '';
                    break;
            }

            $displayConstancia = (($hiddenMotivo->getInputValue()==1) || ($hiddenMotivo->getInputValue()==2))? 'block':'none';

            $xtpl->assign("value", $valueConstancia );

            $xtpl->parse("main.ds_certificado.label");
            $xtpl->assign("actionFile", "doAction?action=add_file_session_rendicion&solicitud_oid=".$hiddens['solicitud.oid']->getInputValue() );
            $xtpl->parse("main.ds_certificado.input");
            $xtpl->assign("display", $displayConstancia);



            $hiddenDs_certificado = $hiddens['ds_certificado'];

            if ($hiddenDs_certificado->getInputValue()) {
                $xtpl->assign("ds_certificado_cargado", '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$hiddenDs_certificado->getInputValue().'</span>');
            }
            $xtpl->parse("main.ds_certificado");

		}
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













}
