<?php

/**
 * Acción para actualizar una evaluacion
 *
 * @author Marcos
 * @since 22-05-2014
 *
 */
class EvaluarSolicitudAction extends UpdateEntityAction{

	protected function getEntity() {
	
		
		
		$entity =  parent::getEntity();
		$entity->setDt_fecha(date('YmdHis'));
		
		CYTSecureUtils::logObject($_POST);
		if ( isset($_POST ['nu_puntajeplan0']) ){	
			$entity->setNu_puntajePlan( $_POST ['nu_puntajeplan0'] );
		}
		if ( isset($_POST ['ds_justificacionplan']) ){	
			$entity->setDs_justificacionplan( $_POST ['ds_justificacionplan'] );
		}
		if ( $_POST ['cd_categoriamaximo'] ){
			$entity->setCategoria_oid( $_POST ['cd_categoriamaximo'] );
		}
		if ( $_POST ['cd_cargomaximo'] ){
			$entity->setCargo_oid( $_POST ['cd_cargomaximo'] );
		}
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $entity->getModeloplanilla_oid(), '=');
		$oItemMaximoManager =  ManagerFactory::getItemMaximoManager();
		$items = $oItemMaximoManager->getEntities($oCriteria);
		foreach ($items as $item) {
			if ( isset($_POST ['nu_cantitem'.$item->getOid()]) ){
				$itemmaximo = $item->getOid().'-'.$_POST ['nu_cantitem'.$item->getOid()];
				if ( isset($_POST ['nu_puntajeitem'.$item->getOid()]) ){
					$itemmaximo .='-'.$_POST ['nu_puntajeitem'.$item->getOid()];
				}
				else{
					$itemmaximo .='-0';
				}
				$entity->getItems()->addItem($itemmaximo);	
			}
		}
		
		$oEventoMaximoManager =  ManagerFactory::getEventoMaximoManager();
		$eventos = $oEventoMaximoManager->getEntities($oCriteria);
		foreach ($eventos as $evento) {
			if ( isset($_POST ['nu_puntajeevento'.$evento->getOid()]) ){
				$ds_justificacion = ( isset($_POST ['ds_justificacionevento'.$evento->getOid()]) )?$_POST ['ds_justificacionevento'.$evento->getOid()]:'';
				$eventomaximo = $evento->getOid().'#/#'.$_POST ['nu_puntajeevento'.$evento->getOid()].'#/#'.$ds_justificacion;
				$entity->getEventos()->addItem($eventomaximo);	
			}
		}
		
		return $entity;
		
	}
	
	public function getNewFormInstance(){
		return new CMPEvaluacionForm();
	}

	public function getNewEntityInstance(){
		$oEvaluacion = new Evaluacion();
		
		return $oEvaluacion;
	}

	protected function getEntityManager(){
		return ManagerFactory::getEvaluacionManager();
	}



	



}
