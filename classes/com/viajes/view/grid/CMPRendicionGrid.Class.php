<?php

/**
 * componente grilla para rendiciones
 *
 * @author Marcos
 * @since 08-06-2015
 *
 */
class CMPRendicionGrid extends CMPEntityGrid{

	public function __construct(){

		parent::__construct();


		$filter = new CMPRendicionFilter();

		$solicitud_oid = CdtUtils::getParam('id');

		if (!empty( $solicitud_oid )) {
			$solicitud = new Solicitud();
			$solicitud->setOid($solicitud_oid);
			$filter->setSolicitud( $solicitud );
			$filter->saveProperties();
			/*$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('solicitud_oid', $solicitud_oid, '=');
			$oCriteria->addNull('fechaHasta');
			$managerSolicitudEstado =  CYTSecureManagerFactory::getSolicitudEstadoManager();
			$oSolicitudEstado = $managerSolicitudEstado->getEntity($oCriteria);
			if (($oSolicitudEstado->getEstado()->getOid()!=CYT_ESTADO_SOLICITUD_OTORGADA)) {

				throw new GenericException( CYT_MSG_RENDICIONES_PROHIBIDO_AGREGAR);
			}*/
		}
		$this->setFilter( $filter );
		$this->setLayout( new CdtLayoutBasicAjax() );
		$this->setModel( new RendicionGridModel() );
		//$this->setRenderer( );
	}

}
