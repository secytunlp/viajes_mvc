<?php

/**
 * componente filter para cambios estados.
 *
 * @author Marcos
 * @since 11-06-2013
 *
 */
class CMPCambioEstadoFilter extends CMPFilter{

	
	
	
	
	/**
	 * cambio 
	 * @var string
	 */
	private $cambio;
	
	/**
	 * estado
	 * @var Estado
	 */
	private $estado;
	
	/**
	 * inicio  desde.
	 * @var string
	 */
	private $inicioDesde;
	
	/**
	 * inicio  hasta.
	 * @var string
	 */
	private $inicioHasta;
	
	/**
	 * fin  desde.
	 * @var string
	 */
	private $finDesde;
	
	/**
	 * fin  hasta.
	 * @var string
	 */
	private $finHasta;
	
	
	
	
	
	public function __construct( $id="filter_cambiosEstado"){

		parent::__construct($id);


		$this->setComponent("CMPCambioEstadoGrid");

		
		
		$this->setCambio( new Cambio() );
		$this->setEstado( new Estado() );
		
		//formamos el form de búsqueda.
		
		
		
		
		$findCambio = CYTSecureComponentsFactory::getFindCambio(new Cambio(), CYT_LBL_CAMBIO, "", "cambioEstado_filter_cambio_oid", "cambio.oid", "");
		$findCambio->setMinWidth("372px;");
		$this->addField( $findCambio );
		
		$fieldEstado = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_ESTADO, "estado.oid", CYTSecureUtils::getEstadosItems(), null, null, null, "--Seleccionar--" );
		$this->addField( $fieldEstado );
		
		$fieldInicioDesde = FieldBuilder::buildFieldDate ( CYT_LBL_SOLICITUD_ESTADO_FECHA_DESDE_DESDE, "inicioDesde"  );
		$this->addField( $fieldInicioDesde,2 );
		
		$fieldInicioHasta = FieldBuilder::buildFieldDate ( CYT_LBL_SOLICITUD_ESTADO_FECHA_DESDE_HASTA, "inicioHasta"  );
		$this->addField( $fieldInicioHasta,2 );
		
		$fieldFinDesde = FieldBuilder::buildFieldDate ( CYT_LBL_SOLICITUD_ESTADO_FECHA_HASTA_DESDE, "finDesde"  );
		$this->addField( $fieldFinDesde,2 );
		
		$fieldFinHasta = FieldBuilder::buildFieldDate ( CYT_LBL_SOLICITUD_ESTADO_FECHA_HASTA_HASTA, "finHasta"  );
		$this->addField( $fieldFinHasta,2 );
		
		
		
		
		
		$this->fillForm();

	}


	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);
		
		
		
		//filtramos por cambio.
		$cambio = $this->getCambio();
		if($cambio!=null && $cambio->getOid()!=null){
			$criteria->addFilter("cambio_oid", $cambio->getOid(), "=" );
		}
		
		//filtramos por estado de cambio.
		$estado = $this->getEstado();
		if($estado!=null && $estado->getOid()!=null){
			$criteria->addFilter("estado_oid", $estado->getOid(), "=" );
		}
		
		//filtramos por rango de fechas.
		$inicioDesde = $this->getInicioDesde();
		if(!empty($inicioDesde)){
			$criteria->addFilter("fechaDesde", $inicioDesde, ">=", new CdtCriteriaFormatMysqlDateValue("d/m/y", DB_DEFAULT_DATETIME_FORMAT) );
		}
		
		$inicioHasta = $this->getInicioHasta();
		if(!empty($inicioHasta)){
			$criteria->addFilter("fechaDesde", CYTUtils::addDays(CYTSecureUtils::formatDateToPersist($inicioHasta), DB_DEFAULT_DATETIME_FORMAT, 1), "<=", new CdtCriteriaFormatStringValue());
		}
		
		$finDesde = $this->getFinDesde();
		if(!empty($finDesde)){
			$criteria->addFilter("fechaHasta", $finDesde, ">=", new CdtCriteriaFormatMysqlDateValue("d/m/y",DB_DEFAULT_DATETIME_FORMAT) );
		}
		
		$finHasta = $this->getFinHasta();
		if(!empty($finHasta)){
			$criteria->addFilter("fechaDesde", CYTUtils::addDays(CYTSecureUtils::formatDateToPersist($finHasta), DB_DEFAULT_DATETIME_FORMAT, 1), "<=", new CdtCriteriaFormatStringValue());
		}
		
	}




	

	

	

	public function getCambio()
	{
	    return $this->cambio;
	}

	public function setCambio($cambio)
	{
	    $this->cambio = $cambio;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	

	public function getInicioDesde()
	{
	    return $this->inicioDesde;
	}

	public function setInicioDesde($inicioDesde)
	{
	    $this->inicioDesde = $inicioDesde;
	}

	public function getInicioHasta()
	{
	    return $this->inicioHasta;
	}

	public function setInicioHasta($inicioHasta)
	{
	    $this->inicioHasta = $inicioHasta;
	}

	public function getFinDesde()
	{
	    return $this->finDesde;
	}

	public function setFinDesde($finDesde)
	{
	    $this->finDesde = $finDesde;
	}

	public function getFinHasta()
	{
	    return $this->finHasta;
	}

	public function setFinHasta($finHasta)
	{
	    $this->finHasta = $finHasta;
	}
}