<?php 

/**
 * Acción para quitar un presupuesto de solicitud.
 * Es sólo en sesión para ir armando la solicitud.
 * 
 * @author Marcos
 * @since 02-01-2014
 * 
 */
class DeletePresupuestoSessionAction extends EditEntityAction{

	protected function edit( $entity ){
		
		$presupuesto = CdtUtils::getParam("item_oid");
		
		//el oid representa el dato "presupuesto" ya que no hay entity relacionada
		$this->getEntityManager()->delete( $presupuesto );

		
		//vamos a retornar por json los presupuestos de la encomienda.
		
		//usamos el renderer para reutilizar lo que mostramos de los presupuestos.
		$renderer = new CMPSolicitudFormRenderer();
		$presupuestos = array();
		$total = 0;
		foreach ($this->getEntityManager()->getEntities(new CdtSearchCriteria()) as $presupuesto) {
			$presupuesto->setDt_fecha(CYTSecureUtils::formatDateToPersist($presupuesto->getDt_fecha()));
			$total += $presupuesto->getNu_montopresupuesto();
			$presupuestos[] = $renderer->buildArrayPresupuesto($presupuesto);
		}		
		
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
