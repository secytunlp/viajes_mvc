<?php

/**
 * componente grilla para rendiciones estado
 *
 * @author Marcos
 * @since 29-09-2021
 *
 */
class CMPRendicionEstadoGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();

		$filter = new CMPRendicionEstadoFilter();

		$rendicion_oid = CdtUtils::getParam('id');

		if (!empty( $rendicion_oid )) {
			$rendicion = new Rendicion();
			$rendicion->setOid($rendicion_oid);
			$filter->setRendicion( $rendicion );
			$filter->saveProperties();
		}
		$this->setFilter( $filter );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new RendicionEstadoGridModel() );
		//$this->setRenderer( );
	}

}
