<?php

/**
 * componente filter para solicitudes.
 *
 * @author Marcos
 * @since 13-11-2013
 *
 */
class CMPSolicitudFilter extends CMPFilter{

	/**
	 * solicitante 
	 * @var string
	 */
	private $solicitante;
	
	/**
	 * cat
	 * @var Cat
	 */
	private $cat;
	
	/**
	 * estado
	 * @var Estado
	 */
	private $estado;
	
	/**
	 * motivo
	 * @var Motivo
	 */
	private $motivo;
	
	/**
	 * periodo
	 * @var Facultad
	 */
	private $periodo;
	
	/**
	 * facultad
	 * @var Facultad
	 */
	private $facultad;
	
	/**
	 * bl_otorgada 
	 * @var string
	 */
	private $bl_otorgada;
	
	
	public function __construct( $id="filter_solicitudes"){

		parent::__construct($id);
	
		$this->setOrderBy('cd_solicitud');

		$this->setComponent("CMPSolicitudGrid");

		$this->setFacultad( new Facultad() );
		$this->setPeriodo( new Periodo() );
		$this->setMotivo( new Motivo() );
		$this->setCat( new Cat() );
		$this->setEstado( new Estado() );
		
		//formamos el form de búsqueda.
		$fieldCodigo = FieldBuilder::buildFieldText ( CYT_LBL_SOLICITUD_SOLICITANTE, "solicitante"  );
		$this->addField( $fieldCodigo );
		
		$fieldCat = FieldBuilder::buildFieldSelect (CYT_LBL_CAT, "cat.oid", CYTSecureUtils::getCatsItems(), '', null, null, "--seleccionar--", "cat_oid" );
		$this->addField( $fieldCat );
		
		
		$fieldFacultad = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_FACULTAD, "facultad.oid", CYTSecureUtils::getFacultadesItems(), '', null, null, "--seleccionar--", "facultad_oid" );
		$fieldFacultad->getInput()->addProperty('style','width:250px;');
		$this->addField( $fieldFacultad );
		
		$fieldEstado = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_ESTADO, "estado.oid", CYTSecureUtils::getEstadosItems(), '', null, null, "--seleccionar--", "estado_oid" );
		$this->addField( $fieldEstado,2 );
	
		$fieldMotivo = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_MOTIVO, "motivo.oid", CYTUtils::getMotivosItems(), '', null, null, "--seleccionar--", "motivo_oid" );
		$this->addField( $fieldMotivo,2 );

		
		$fieldPeriodo = FieldBuilder::buildFieldSelect (CYT_LBL_SOLICITUD_PERIODO, "periodo.oid", CYTSecureUtils::getPeriodosItems(), '', null, null, "--seleccionar--", "periodo_oid" );
		$this->addField( $fieldPeriodo,2 );
		
		$this->addField( FieldBuilder::buildFieldCheckbox ( CYT_LBL_SOLICITUD_ESTADO_OTORGADAS, "bl_otorgada", "bl_otorgada") );
		
		
		$this->fillForm();

	}


	protected function fillCriteria( $criteria ){

		parent::fillCriteria($criteria);
		
		$solicitante = $this->getSolicitante();

		if(!empty($solicitante)){
			$tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
			$filter = new CdtSimpleExpression( "(($tDocente.ds_nombre like '$solicitante%') OR ($tDocente.ds_apellido like '$solicitante%'))");

			$criteria->setExpresion($filter);
		}
		
		
		$facultad = $this->getFacultad();
		if($facultad!=null && $facultad->getOid()!=null){
			$criteria->addFilter("cd_facultadplanilla", $facultad->getOid(), "=" );
		}
		
		$estado = $this->getEstado();
		if($estado!=null && $estado->getOid()!=null){
			$tSolicitudEstado = CYTSecureDAOFactory::getSolicitudEstadoDAO()->getTableName();
			$criteria->addFilter("$tSolicitudEstado.estado_oid", $estado->getOid(), "=" );
		}
		
		$cat = $this->getCat();
		if($cat!=null && $cat->getOid()!=null){
			$criteria->addFilter("FacultadPlanilla.cd_cat", $cat->getOid(), "=" );
		}
		
		$periodo = $this->getPeriodo();
		if($periodo!=null && $periodo->getOid()!=null){
			$criteria->addFilter("cd_periodo", $this->getPeriodo()->getOid(), "=" );
			
		}
		
		
		
		$motivo = $this->getMotivo();
		if($motivo!=null && $motivo->getOid()!=null){
			$criteria->addFilter("cd_motivo", $motivo->getOid(), "=" );
		}

		//filtramos por bl_otorgada.
		$bl_otorgada = $this->getBl_otorgada();
		if($bl_otorgada){
			$tSolicitudEstado = CYTSecureDAOFactory::getSolicitudEstadoDAO()->getTableName();
			$otorgadas =CYT_ESTADO_SOLICITUD_OTORGADA.",".CYT_ESTADO_SOLICITUD_RENDIDA.",".CYT_ESTADO_SOLICITUD_RENUNCIADA.",".CYT_ESTADO_SOLICITUD_DEVUELTA;
			
			$filter = new CdtSimpleExpression( "$tSolicitudEstado.estado_oid IN (".$otorgadas.")");

			$criteria->setExpresion($filter);
		}
		
		
		
		$oUser = CdtSecureUtils::getUserLogged();
		
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_SOLICITANTE) {
            $separarCUIL = explode('-',trim($oUser->getDs_username()));
            $oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('nu_documento', $separarCUIL[1], '=');
			
			$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
			$oDocente = $oDocenteManager->getEntity($oCriteria);
            $criteria->addFilter("cd_docente", $oDocente->getOid(), "=");
        }
        
        
		if ($oUser->getCd_usergroup()==CYT_CD_GROUP_EVALUADOR) {
        	$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_usuario',$oUser->getCd_user(), '=');
			$oCriteria->addNull('fechaHasta');
			$tEvaluacionEstado = CYTSecureDAOFactory::getEvaluacionEstadoDAO()->getTableName();
			$filter = new CdtSimpleExpression( "(".$tEvaluacionEstado.".estado_oid =".CYT_ESTADO_SOLICITUD_RECIBIDA." OR ".$tEvaluacionEstado.".estado_oid =".CYT_ESTADO_SOLICITUD_EN_EVALUACION." OR ".$tEvaluacionEstado.".estado_oid =".CYT_ESTADO_SOLICITUD_EVALUADA.")");

			$oCriteria->setExpresion($filter);
			
			$oEvaluacionManager =  ManagerFactory::getEvaluacionManager();
			$oEvaluaciones = $oEvaluacionManager->getEntities($oCriteria);
			$evaluaciones = '';
			foreach ($oEvaluaciones as $oEvaluacion) {
				$evaluaciones .= $oEvaluacion->getSolicitud()->getOid().',';
			}
			
			if (($evaluaciones!='')) {
				
				$evaluaciones = substr( $evaluaciones, 0, strlen($evaluaciones)-1); //se le quita la última , (coma)
			}
			else{
				$evaluaciones = 0;
			}
			
			$tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
			$filter = new CdtSimpleExpression( "$tSolicitud.cd_solicitud IN (".$evaluaciones.")");

			$criteria->setExpresion($filter);
        	
        }
        if (($oUser->getCd_usergroup()==CYT_CD_GROUP_COORDINADOR)||($oUser->getCd_usergroup()==CYT_CD_GROUP_EVALUADOR)) {
        	$oPeriodoManager = CYTSecureManagerFactory::getPeriodoManager();
			$oPerioActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
        	$criteria->addFilter("cd_periodo", $oPerioActual->getOid(), "=" );
        }
		
		if ($oUser->getCd_usergroup()==9) {
			$userManager = CYTSecureManagerFactory::getUserManager();
			$oUsuario = $userManager->getObjectByCode($oUser->getCd_user());
			//print_r($oUsuario);
			
			$criteria->addFilter("cd_facultadPlanilla", $oUsuario->getFacultad()->getOid(), "=");
			
			
        }
        
        
		
		$criteria->addNull('fechaHasta');
			
		
		
	}




	

	

	

   

	public function getSolicitante()
	{
	    return $this->solicitante;
	}

	public function setSolicitante($solicitante)
	{
	    $this->solicitante = $solicitante;
	}

	public function getMotivo()
	{
	    return $this->motivo;
	}

	public function setMotivo($motivo)
	{
	    $this->motivo = $motivo;
	}

	public function getFacultad()
	{
	    return $this->facultad;
	}

	public function setFacultad($facultad)
	{
	    $this->facultad = $facultad;
	}

	public function getPeriodo()
	{
	    return $this->periodo;
	}

	public function setPeriodo($periodo)
	{
	    $this->periodo = $periodo;
	}

	public function getCat()
	{
	    return $this->cat;
	}

	public function setCat($cat)
	{
	    $this->cat = $cat;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	public function getBl_otorgada()
	{
	    return $this->bl_otorgada;
	}

	public function setBl_otorgada($bl_otorgada)
	{
	    $this->bl_otorgada = $bl_otorgada;
	}
}