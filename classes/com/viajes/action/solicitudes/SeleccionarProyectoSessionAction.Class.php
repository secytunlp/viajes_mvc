<?php 

/**
 * Acción para seleccionar un proyecto de solicitud.
 * Es sólo en sesión para ir armando la solicitud.
 * 
 * @author Marcos
 * @since 03-08-2016
 * 
 */
class SeleccionarProyectoSessionAction extends EditEntityAction{

	protected function edit( $entity ){
		
		$solicitudProyecto = CdtUtils::getParam("item_oid");
		$checked = CdtUtils::getParam("checked");
		
		//el oid representa el dato "solicitudProyecto" ya que no hay entity relacionada
		$this->getEntityManager()->select( $solicitudProyecto,$checked );

		
		//vamos a retornar por json los solicitudProyectos de la encomienda.
		
		//usamos el renderer para reutilizar lo que mostramos de los solicitudProyectos.
		/*$renderer = new CMPSolicitudFormRenderer();
		$solicitudProyectos = array();
		foreach ($this->getEntityManager()->getEntities(new CdtSearchCriteria()) as $solicitudProyecto) {
			$solicitudProyecto->setDt_alta(CYTSecureUtils::formatDateToPersist($solicitudProyecto->getDt_alta()));
			$solicitudProyecto->setDt_baja(CYTSecureUtils::formatDateToPersist($solicitudProyecto->getDt_baja()));
			$solicitudProyectos[] = $renderer->buildArrayProyecto($solicitudProyecto);
		}		
		
		return array("proyectos" => $solicitudProyectos, 
						"proyectoColumns" => $renderer->getProyectoColumns(),
						"proyectoColumnsAlign" => $renderer->getProyectoColumnsAlign(),
						"proyectoColumnsLabels" => $renderer->getProyectoColumnsLabels());*/
	}

	/**
     * (non-PHPdoc)
     * @see CdtEditAction::getEntity();
     */
    protected function getEntity() {

       
        
        return "";
    }

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		return "";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		return new SolicitudProyecto();
	}
	
	protected function getEntityManager(){
		return new SolicitudProyectoSessionManager();
	}

}
