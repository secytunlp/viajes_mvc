<?php 

/**
 * Acción para quitar un monto de solicitud.
 * Es sólo en sesión para ir armando la solicitud.
 * 
 * @author Marcos
 * @since 02-01-2014
 * 
 */
class DeleteMontoSessionAction extends EditEntityAction{

	protected function edit( $entity ){
		
		$monto = CdtUtils::getParam("item_oid");
		
		//el oid representa el dato "monto" ya que no hay entity relacionada
		$this->getEntityManager()->delete( $monto );

		
		//vamos a retornar por json los montos de la encomienda.
		
		//usamos el renderer para reutilizar lo que mostramos de los montos.
		$renderer = new CMPSolicitudFormRenderer();
		$montos = array();
		foreach ($this->getEntityManager()->getEntities(new CdtSearchCriteria()) as $monto) {
			
			$montos[] = $renderer->buildArrayMonto($monto);
		}		
		
		return array("montos" => $montos, 
						"montoColumns" => $renderer->getMontoColumns(),
						"montoColumnsAlign" => $renderer->getMontoColumnsAlign(),
						"montoColumnsLabels" => $renderer->getMontoColumnsLabels());
	}


	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		return new CMPMontoForm();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		return new Monto();
	}
	
	protected function getEntityManager(){
		return new MontoSessionManager();
	}

}
