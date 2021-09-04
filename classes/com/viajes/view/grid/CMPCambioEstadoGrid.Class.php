<?php

/**
 * componente grilla para cambios estado
 *
 * @author Marcos
 * @since 11-06-2015
 *
 */
class CMPCambioEstadoGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();
		
		$filter = new CMPCambioEstadoFilter();
		
		$cambio_oid = CdtUtils::getParam('id');
			
		if (!empty( $cambio_oid )) {
			$cambio = new Cambio();
			$cambio->setOid($cambio_oid);
			$filter->setCambio( $cambio );
			$filter->saveProperties();
		}
		$this->setFilter( $filter );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new CambioEstadoGridModel() );
		//$this->setRenderer( );
	}

}