<?php 

/**
 * Acción para dar de alta un presupuesto de solicitud.
 * El alta es sólo en sesión para ir armando la solicitud.
 * 
 * @author Marcos
 * @since 02-01-2014
 * 
 */
class AddPresupuestoSessionAction extends AddEntityAction{

	protected function edit( $entity ){
		
		parent::edit( $entity );
		
		//vamos a retornar por json los presupuestos de la solicitud.
		
		//usamos el renderer para reutilizar lo que mostramos de los presupuestos.
		$renderer = new CMPSolicitudFormRenderer();
		$presupuestos = array();
		$total=0;
		foreach ($this->getEntityManager()->getEntities(new CdtSearchCriteria()) as $presupuesto) {
			$presupuesto->setDt_fecha(CYTSecureUtils::formatDateToPersist($presupuesto->getDt_fecha()));
			$total += $presupuesto->getNu_montopresupuesto();
			$presupuestos[] = $renderer->buildArrayPresupuesto($presupuesto);
		}		
		CdtUtils::log($total, __CLASS__, LoggerLevel::getLevelInfo() );
		return array("presupuestos" => $presupuestos, 
						"total" => CYTSecureUtils::formatMontoToView($total), 	
						"presupuestoColumns" => $renderer->getPresupuestoColumns(),
						"presupuestoColumnsAlign" => $renderer->getPresupuestoColumnsAlign(),
						"presupuestoColumnsLabels" => $renderer->getPresupuestoColumnsLabels());

	}


	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		return new CMPPresupuestoForm();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		return new Presupuesto();
	}
	
	protected function getEntityManager(){
		return new PresupuestoSessionManager();
	}
	
}