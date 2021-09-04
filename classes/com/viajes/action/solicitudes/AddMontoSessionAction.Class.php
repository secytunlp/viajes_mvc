<?php 

/**
 * Acción para dar de alta un monto de solicitud.
 * El alta es sólo en sesión para ir armando la solicitud.
 * 
 * @author Marcos
 * @since 02-01-2014
 * 
 */
class AddMontoSessionAction extends AddEntityAction{

	protected function edit( $entity ){
		
		parent::edit( $entity );
		
		//vamos a retornar por json los montos de la solicitud.
		
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