<?php

/**
 * Se chequea el concepto
 * 
 * @author Marcos
 * @since 02-01-2014
 *
 */
class AddSolicitudPresupuestoChequearConceptoAction extends CdtAction{


	/**
	 * (non-PHPdoc)
	 * @see CdtAction::execute();
	 */
	public function execute(){

		
		$result = "";
		
		try{
			
			$concepto_oid = CdtUtils::getParam("concepto_oid");
			
			//$valido = true; //TODO validar
			$show = array();
			$hide = array();
			
			
			switch ($concepto_oid) {
				case CYT_CD_VIATICO:
				$show[]='ds_dias';
				$show[]='ds_lugar';
				$hide[]='ds_pasajes';
				$hide[]='ds_destino';
				$hide[]='ds_inscripcion';
				break;
				
				case CYT_DS_PASAJE:
				$hide[]='ds_dias';
				$hide[]='ds_lugar';
				$show[]='ds_pasajes';
				$show[]='ds_destino';
				$hide[]='ds_inscripcion';
				break;
				
				case CYT_CD_INSCRIPCION:
				$hide[]='ds_dias';
				$hide[]='ds_lugar';
				$hide[]='ds_pasajes';
				$hide[]='ds_destino';
				$show[]='ds_inscripcion';
				break;
			}
			
	    	
			
			
			
			
			
			$result['hide'] = $hide;
			$result['show'] = $show;
			
		}catch(Exception $ex){
			
			$result['error'] = $ex->getMessage();
			
		}

		echo json_encode( $result ); 
		return null;
	}
	
	
	
}