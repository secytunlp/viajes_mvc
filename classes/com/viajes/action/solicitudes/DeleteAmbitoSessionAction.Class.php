<?php 

/**
 * Acción para quitar un ambito de solicitud.
 * Es sólo en sesión para ir armando la solicitud.
 * 
 * @author Marcos
 * @since 20-12-2013
 * 
 */
class DeleteAmbitoSessionAction extends EditEntityAction{

	protected function edit( $entity ){
		
		$ambito = CdtUtils::getParam("item_oid");
		
		//el oid representa el dato "ambito" ya que no hay entity relacionada
		$this->getEntityManager()->delete( $ambito );

		
		//vamos a retornar por json los ambitos de la encomienda.
		
		//usamos el renderer para reutilizar lo que mostramos de los ambitos.
		$renderer = new CMPSolicitudFormRenderer();
		$ambitos = array();
		foreach ($this->getEntityManager()->getEntities(new CdtSearchCriteria()) as $ambito) {
			$ambito->setDt_desde(CYTSecureUtils::formatDateToPersist($ambito->getDt_desde()));
			$ambito->setDt_hasta(CYTSecureUtils::formatDateToPersist($ambito->getDt_hasta()));
			$ambitos[] = $renderer->buildArrayAmbito($ambito);
		}		
		
		return array("ambitos" => $ambitos, 
						"ambitoColumns" => $renderer->getAmbitoColumns(),
						"ambitoColumnsAlign" => $renderer->getAmbitoColumnsAlign(),
						"ambitoColumnsLabels" => $renderer->getAmbitoColumnsLabels());
	}


	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		return new CMPAmbitoForm();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		return new Ambito();
	}
	
	protected function getEntityManager(){
		return new AmbitoSessionManager();
	}

}
