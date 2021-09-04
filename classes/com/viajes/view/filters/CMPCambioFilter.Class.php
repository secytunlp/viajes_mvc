<?php

/**
 * componente filter para cambios.
 *
 * @author Marcos
 * @since 08-06-2015
 *
 */
class CMPCambioFilter extends CMPFilter{

	
	/**
	 * solicitud 
	 * @var string
	 */
	private $solicitud;
	
	
	
	
	
	
	
	public function __construct( $id="filter_cambio"){
		parent::__construct($id);
		$this->setOrderBy('cd_cambio');
		$this->setComponent("CMPCambioGrid");

		
		
		$this->setSolicitud( new Solicitud() );
		
		
		
		$findSolicitud = CYTSecureComponentsFactory::getFindSolicitud(new Solicitud(), CYT_LBL_SOLICITUD, "", "cambio_filter_solicitud_oid", "solicitud.oid", "");
		$this->addField( $findSolicitud );
		
		
		
		
		$this->fillForm();

	}


	
	
	
	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);
		
		
		//filtramos por solicitud.
		$solicitud = $this->getSolicitud();
		if($solicitud!=null && $solicitud->getOid()!=null){
			$criteria->addFilter("cd_solicitud", $solicitud->getOid(), "=" );
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