<?php

/**
 * componente filter para rendiciones estados.
 *
 * @author Marcos
 * @since 29-09-2021
 *
 */
class CMPRendicionEstadoFilter extends CMPFilter{





	/**
	 * rendicion
	 * @var string
	 */
	private $rendicion;

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





	public function __construct( $id="filter_rendicionesEstado"){

		parent::__construct($id);


		$this->setComponent("CMPRendicionEstadoGrid");



		$this->setRendicion( new Rendicion() );
		$this->setEstado( new Estado() );

		//formamos el form de búsqueda.




		$findRendicion = CYTSecureComponentsFactory::getFindRendicion(new Rendicion(), CYT_LBL_RENDICION, "", "rendicionEstado_filter_rendicion_oid", "rendicion.oid", "");
		$findRendicion->setMinWidth("372px;");
		$this->addField( $findRendicion );

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



		//filtramos por rendicion.
		$rendicion = $this->getRendicion();
		if($rendicion!=null && $rendicion->getOid()!=null){
			$criteria->addFilter("rendicion_oid", $rendicion->getOid(), "=" );
		}

		//filtramos por estado de rendicion.
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










	public function getRendicion()
	{
	    return $this->rendicion;
	}

	public function setRendicion($rendicion)
	{
	    $this->rendicion = $rendicion;
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
