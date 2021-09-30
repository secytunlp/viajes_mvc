<?php

/**
 * componente filter para rendiciones.
 *
 * @author Marcos
 * @since 08-06-2015
 *
 */
class CMPRendicionFilter extends CMPFilter{


	/**
	 * solicitud
	 * @var string
	 */
	private $solicitud;







	public function __construct( $id="filter_rendicion"){
		parent::__construct($id);
		//$this->setOrderBy('cd_rendicion');
		$this->setComponent("CMPRendicionGrid");



		$this->setSolicitud( new Solicitud() );



		$findSolicitud = CYTSecureComponentsFactory::getFindSolicitud(new Solicitud(), CYT_LBL_SOLICITUD, "", "rendicion_filter_solicitud_oid", "solicitud.oid", "");
		$this->addField( $findSolicitud );




		$this->fillForm();

	}





	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);


		//filtramos por solicitud.
		$solicitud = $this->getSolicitud();
		if($solicitud!=null && $solicitud->getOid()!=null){
			$criteria->addFilter("solicitud_oid", $solicitud->getOid(), "=" );
		}


		$criteria->addNull('fechaHasta');


	}









	public function getSolicitud()
	{
	    return $this->solicitud;
	}

	public function setSolicitud($solicitud)
	{
	    $this->solicitud = $solicitud;
	}
}
