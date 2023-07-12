<?php

/**
 * AcciÃ³n para inicializar el contexto
 * para editar una solicitud.
 *
 * @author Marcos
 * @since 11-12-2013
 *
 */

class AddSolicitudInitAction extends EditEntityInitAction {

    /**
     * (non-PHPdoc)
     * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
     */
    public function getNewFormInstance($action){
        $form = new CMPSolicitudForm($action);
        $bl_notificacion = $form->getInput("bl_notificacion");
        $bl_notificacion->setIsChecked(true);
        return $form;

    }



    /**
     * (non-PHPdoc)
     * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
     */
    public function getNewEntityInstance(){
        if (date('Y-m-d')>CYT_FECHA_CIERRE) {
            throw new GenericException( CYT_MSG_FIN_PERIODO );
        }
        $oSolicitud = new Solicitud();
        $oUser = CdtSecureUtils::getUserLogged();

        if ($oUser->getCd_usergroup()==CYT_CD_GROUP_SOLICITANTE) {
            $separarCUIL = explode('-',trim($oUser->getDs_username()));
            $oCriteria = new CdtSearchCriteria();
            $oCriteria->addFilter('nu_documento', $separarCUIL[1], '=');

            $oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
            $oDocente = $oDocenteManager->getEntity($oCriteria);

            $oCriteria = new CdtSearchCriteria();
            $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
            $oCriteria->addFilter("$tDocente.cd_docente", $oDocente->getOid(), '=');

            $oPeriodoManager = CYTSecureManagerFactory::getPeriodoManager();
            $oPerioActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
            $tPeriodo = CYTSecureDAOFactory::getPeriodoDAO()->getTableName();
            $oCriteria->addFilter("$tPeriodo.cd_periodo", $oPerioActual->getOid(), '=');

            $oSolicitudManager =  ManagerFactory::getSolicitudManager();
            $oSolicitudAux = $oSolicitudManager->getEntity($oCriteria);

            if(!empty($oSolicitudAux)){
                throw new GenericException( CYT_MSG_SOLICITUD_CREADA );
            }

            $error = '';

            $oCriteria = new CdtSearchCriteria();
            $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
            $oCriteria->addFilter("$tDocente.nu_documento", $oDocente->getNu_documento(), '=');

            $oNoRendidasManager =  CYTSecureManagerFactory::getNoRendidasManager();
            $oNoRendidas = $oNoRendidasManager->getEntities($oCriteria);
            foreach ($oNoRendidas as $oNoRendida) {
                $error .= CYT_MSG_SOLICITUD_NO_RENDIDAS.$oNoRendida->getNu_year()."<br>";
            }

            $twoYear = intval(CYT_PERIODO_YEAR)-2;

            for ($i = $twoYear; $i > CYT_PERIODO_INICIAL; $i--) {

                $oCriteria = new CdtSearchCriteria();
                $oCriteria->addFilter("ds_periodo", $i, "=", new CdtCriteriaFormatStringValue());
                $oPeriodoManager = CYTSecureManagerFactory::getPeriodoManager();
                $oPeriodoAnterior = $oPeriodoManager->getEntity($oCriteria);

                if ($oPeriodoAnterior) {
                    $oCriteria = new CdtSearchCriteria();
                    $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
                    $oCriteria->addFilter("$tDocente.cd_docente", $oDocente->getOid(), '=');


                    $tPeriodo = CYTSecureDAOFactory::getPeriodoDAO()->getTableName();
                    $oCriteria->addFilter("$tPeriodo.cd_periodo", $oPeriodoAnterior->getOid(), '=');

                    $oSolicitudManager =  ManagerFactory::getSolicitudManager();
                    $oSolicitudAnterior = $oSolicitudManager->getEntity($oCriteria);

                    if ($oSolicitudAnterior) {
                        $oCriteria = new CdtSearchCriteria();
                        $oCriteria->addFilter('solicitud_oid', $oSolicitudAnterior->getOid(), '=');
                        $oCriteria->addNull('fechaHasta');
                        $managerSolicitudEstado =  CYTSecureManagerFactory::getSolicitudEstadoManager();
                        $oSolicitudEstado = $managerSolicitudEstado->getEntity($oCriteria);
                        if (($oSolicitudEstado->getEstado()->getOid()==CYT_ESTADO_SOLICITUD_OTORGADA)) {
                            $error .= CYT_MSG_SOLICITUD_NO_RENDIDAS.$i."<br>";

                        }
                    }
                }



            }

            if($error){
                throw new GenericException( $error );
            }

            $oCriteria = new CdtSearchCriteria();
            $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
            $oCriteria->addFilter("$tDocente.cd_docente", $oDocente->getOid(), '=');

            $oPeriodoManager = CYTSecureManagerFactory::getPeriodoManager();
            $oPerioActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
            $tSolicitudEstado = CYTSecureDAOFactory::getSolicitudEstadoDAO()->getTableName();
            $tSolicitud = DAOFactory::getSolicitudDAO()->getTableName();
            $sql = "(";
            for ($i = 0; $i < CYT_PERIODO_ANTERIORES_OTORGADOS; $i++) {
                $periodoAnt = $oPerioActual->getOid()-($i+1);
                $sql .= "((".$tSolicitudEstado.".estado_oid = ".CYT_ESTADO_SOLICITUD_OTORGADA." OR ".$tSolicitudEstado.".estado_oid = ".CYT_ESTADO_SOLICITUD_RENDIDA." OR ".$tSolicitudEstado.".estado_oid = ".CYT_ESTADO_SOLICITUD_RENUNCIADA." OR ".$tSolicitudEstado.".estado_oid = ".CYT_ESTADO_SOLICITUD_DEVUELTA.") AND ".$tSolicitudEstado.".fechaHasta is NULL AND ".$tSolicitud.".cd_periodo = ".$periodoAnt.") OR ";
            }
            $sql = substr($sql,0,strlen($sql)-3);
            $sql .= ")";

            $filter = new CdtSimpleExpression($sql);
            $oCriteria->setExpresion($filter);

            $oSolicitudManager =  ManagerFactory::getSolicitudManager();
            $oSolicitudesOtorgadas = $oSolicitudManager->getEntities($oCriteria);

            if($oSolicitudesOtorgadas->size()==CYT_PERIODO_ANTERIORES_OTORGADOS){
                throw new GenericException( CYT_MSG_SOLICITUD_ANTERIORES_OTORGADAS );
            }

            $oSolicitud->setDs_investigador($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre());
            $oSolicitud->setNu_cuil($oUser->getDs_username());
            $oSolicitud->setDs_calle($oDocente->getDs_calle());
            $oSolicitud->setNu_nro($oDocente->getNu_nro());
            $oSolicitud->setNu_piso($oDocente->getNu_piso());
            $oSolicitud->setDs_depto($oDocente->getDs_depto());
            $oSolicitud->setNu_cp($oDocente->getNu_cp());
            $oSolicitud->setDs_mail($oDocente->getDs_mail());
            $oSolicitud->setNu_telefono($oDocente->getNu_telefono());

            /*$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_titulo', $oDocente->getTitulo()->getOid(), '=');
            $oTituloManager =  CYTSecureManagerFactory::getTituloManager();
			$oTitulo = $oTituloManager->getEntity($oCriteria);
			$oSolicitud->setDs_titulogrado($oTitulo->getDs_titulo());*/
            $oSolicitud->setTitulo($oDocente->getTitulo());


            if ($oDocente->getLugarTrabajo()->getOid()) {
                $oCriteria = new CdtSearchCriteria();
                $oCriteria->addFilter('cd_unidad', $oDocente->getLugarTrabajo()->getOid(), '=');
                $oLugarTrabajoManager =  CYTSecureManagerFactory::getLugarTrabajoManager();
                $oLugarTrabajo = $oLugarTrabajoManager->getEntity($oCriteria);
                $oSolicitud->setLugarTrabajo($oDocente->getLugarTrabajo());
                $oSolicitud->setDs_direccion($oLugarTrabajo->getDs_direccion());
                $oSolicitud->setDs_telefono($oLugarTrabajo->getDs_telefono());
            }


            $oSolicitud->setCargo($oDocente->getCargo());
            $oSolicitud->setDeddoc($oDocente->getDeddoc());
            $oSolicitud->setFacultad($oDocente->getFacultad());
            $oSolicitud->setCategoria($oDocente->getCategoria());

            $oCriteria = new CdtSearchCriteria();
            $oCriteria->addFilter('cd_docente', $oDocente->getOid(), '=');
            $oCriteria->addFilter('dt_hasta', CYT_FECHA_CIERRE, '>', new CdtCriteriaFormatStringValue());
            $oBecaManager =  CYTSecureManagerFactory::getBecaManager();
            $oBeca = $oBecaManager->getEntity($oCriteria);
            if (!empty($oBeca)) {
                $oSolicitud->setBl_unlp(($oBeca->getBl_unlp()?1:0));
                $oSolicitud->setDs_orgbeca(($oBeca->getBl_unlp()?'U.N.L.P.':''));
                $oSolicitud->setDs_tipobeca($oBeca->getDs_tipobeca());
                $dt_becadesde=CYTSecureUtils::formatDateToView($oBeca->getDt_desde());
                $dt_becahasta=CYTSecureUtils::formatDateToView($oBeca->getDt_hasta());
                $oSolicitud->setDs_periodobeca($dt_becadesde.'-'.$dt_becahasta);
            }
            $oSolicitud->setOrganismo($oDocente->getOrganismo());
            $oSolicitud->setCarrerainv($oDocente->getCarrerainv());

            $YearAgo = intval(CYT_PERIODO_YEAR)-1;

            $oCriteria = new CdtSearchCriteria();
            $tDocente = CYTSecureDAOFactory::getDocenteDAO()->getTableName();
            $tIntegrante = CYTSecureDAOFactory::getIntegranteDAO()->getTableName();
            $tProyecto = CYTSecureDAOFactory::getProyectoDAO()->getTableName();
            $oCriteria->addFilter("$tDocente.cd_docente", $oDocente->getOid(), '=');
            $oCriteria->addFilter('DIR.cd_tipoinvestigador', CYT_INTEGRANTE_DIRECTOR, '=');
            $oCriteria->addFilter("$tIntegrante.cd_tipoinvestigador", CYT_INTEGRANTE_COLABORADOR, '<>');

            //$filter = new CdtSimpleExpression("(".$tIntegrante.".dt_baja > '".date('Y-m-d')."' OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");
            /*$filter = new CdtSimpleExpression("(".$tProyecto.".cd_estado =".CYT_ESTADO_PROYECTO_ADMITIDO." OR ".$tProyecto.".cd_estado=".CYT_ESTADO_PROYECTO_ACREDITADO." OR ".$tProyecto.".cd_estado=".CYT_ESTADO_PROYECTO_EN_EVALUACION." OR ".$tProyecto.".cd_estado=".CYT_ESTADO_PROYECTO_EVALUADO.") AND (".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_ADMITIDO." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_CAMBIO_HS_RECIBIDO." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_RECIBIDO.") AND ((".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." AND ".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." AND ".$tIntegrante.".dt_baja > '".$YearAgo."-12-30') OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");*/
            $filter = new CdtSimpleExpression("(".$tProyecto.".cd_estado=".CYT_ESTADO_PROYECTO_ACREDITADO." OR ".$tProyecto.".cd_estado=".CYT_ESTADO_PROYECTO_EN_EVALUACION.") AND (".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_ADMITIDO." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_CAMBIO_HS_CREADO." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_CAMBIO_HS_RECIBIDO." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_CREADO." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_CAMBIO_TIPO_RECIBIDO.") AND ((".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." AND ".$tIntegrante.".cd_estado != ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." AND ".$tIntegrante.".dt_baja > '".$YearAgo."-12-30') OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_CREADA." OR ".$tIntegrante.".cd_estado = ".CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA." OR ".$tIntegrante.".dt_baja IS NULL OR ".$tIntegrante.".dt_baja = '0000-00-00')");
            $oCriteria->setExpresion($filter);
            $twoYearAgo = intval(CYT_PERIODO_YEAR)-2;
            $oCriteria->addFilter('dt_fin', $twoYearAgo.CYT_DIA_MES_PROYECTO_FIN, '>', new CdtCriteriaFormatStringValue());



            //proyectos.
            $proyectosManager = CYTSecureManagerFactory::getProyectoManager();
            $proyectos = $proyectosManager->getEntities($oCriteria);
            $seleccionado=($proyectos->size()==1)?1:0;
            $proyectosArray = new ItemCollection();
            foreach ($proyectos as $oProyecto) {
                $oCriteriaIntegrante = new CdtSearchCriteria();
                $oCriteriaIntegrante->addFilter("$tDocente.cd_docente", $oDocente->getOid(), '=');
                $oCriteriaIntegrante->addFilter("cd_proyecto", $oProyecto->getOid(), '=');
                $integrantesManager = CYTSecureManagerFactory::getIntegranteManager();
                $oIntegrante = $integrantesManager->getEntity($oCriteriaIntegrante);
                $oProyecto->setDt_ini($oIntegrante->getDt_alta());
                $dt_hasta = (($oIntegrante->getDt_baja()=='0000-00-00')||($oIntegrante->getDt_baja()=='')||(!$oIntegrante->getDt_baja())||($oIntegrante->getCd_estado()==CYT_ESTADO_INTEGRANTE_BAJA_CREADA)||($oIntegrante->getCd_estado()==CYT_ESTADO_INTEGRANTE_BAJA_RECIBIDA))?$oProyecto->getDt_fin():$oIntegrante->getDt_baja();
                $oProyecto->setDt_fin($dt_hasta);
                $oSolicitudProyecto = new SolicitudProyecto();
                $oSolicitudProyecto->setDirector($oProyecto->getDirector()->getDs_apellido().', '.$oProyecto->getDirector()->getDs_nombre());
                $oSolicitudProyecto->setBl_seleccionado($seleccionado);
                $oSolicitudProyecto->setDt_alta($oProyecto->getDt_ini());
                $oSolicitudProyecto->setDt_baja($oProyecto->getDt_fin());
                $oSolicitudProyecto->setEstado($oProyecto->getTipoEstadoProyecto());
                $oSolicitudProyecto->setProyecto($oProyecto);
                $proyectosArray->addItem($oSolicitudProyecto);
            }

            $oSolicitud->setProyectos( $proyectosArray );

            $aYear = 0;
            $proyectoActual = 0;
            foreach ($oSolicitud->getProyectos() as $oProyecto) {

                if ($oProyecto->getDt_alta()<=$YearAgo.CYT_DIA_MES_PROYECTO_FIN) {
                    $aYear=1;
                }
                if ($oProyecto->getDt_baja()>=date('Y-m-d')) {
                    $proyectoActual=1;
                }
            }
            if(!$oSolicitud->getBl_unlp() && !$aYear){
                throw new GenericException( CYT_MSG_SOLICITUD_SIN_YEAR_PROYECTO );
            }

            if(!$oSolicitud->getBl_unlp() && !$proyectoActual){
                throw new GenericException( CYT_MSG_SOLICITUD_SIN_PROYECTO_ACTUAL );
            }

            $manager = new SolicitudProyectoSessionManager();
            $manager->setEntities( $oSolicitud->getProyectos() );

            /*$oTipoInvestigador = new Tipoinvestigador();
            if (in_array($oDocente->getCategoria()->getOid(), explode(",",CYT_CATEGORIA_FORMADOS))) {
                $oTipoInvestigador->setOid(CYT_INTEGRANTE_FORMADO);
            }
            elseif (in_array($oDocente->getCategoria()->getOid(), explode(",",CYT_CATEGORIA_NO_FORMADOS))) {
                $oTipoInvestigador->setOid(CYT_INTEGRANTE_NO_FORMADO);
            }
            else {

            }
            $oSolicitud->setTipoInvestigador($oTipoInvestigador);*/
            $oTipoInvestigador = new Tipoinvestigador();
            if (in_array($oDocente->getCategoria()->getOid(), explode(",",CYT_CATEGORIA_FORMADOS))) {
                $oTipoInvestigador->setOid(CYT_INTEGRANTE_FORMADO);
            }

            else {

            }
            $oSolicitud->setTipoInvestigador($oTipoInvestigador);
            $oSolicitud->setBl_congreso(CYT_CD_CONGRESO);
        }

        return $oSolicitud;
    }

    /**
     * (non-PHPdoc)
     * @see CdtEditAction::getOutputTitle();
     */
    protected function getOutputTitle(){
        return CYT_MSG_SOLICITUD_TITLE_ADD;
    }

    /**
     * (non-PHPdoc)
     * @see classes/com/gestion/action/entities/EditEntityInitAction::getSubmitAction()
     */
    protected function getSubmitAction(){
        return "add_solicitud";
    }


}
