<?php

/**
 * AcciÃ³n para inicializar el contexto
 * para editar una evaluaciÃ³n.
 *
 * @author Marcos
 * @since 21-05-2014
 *
 */

class EvaluarSolicitudInitAction extends UpdateEntityInitAction {

	
	protected function getEntity(){

		//$entity = parent::getEntity();
		$oUser = CdtSecureUtils::getUserLogged();
		
		$solicitud_oid = CdtUtils::getParam('id');
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_solicitud', $solicitud_oid, '=');
		$oCriteria->addFilter('cd_usuario', $oUser->getCd_user(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerEvaluacion =  ManagerFactory::getEvaluacionManager();
		$entity = $managerEvaluacion->getEntity($oCriteria);

		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('evaluacion_oid', $entity->getOid(), '=');
		$oCriteria->addNull('fechaHasta');
		$managerEvaluacionEstado =  CYTSecureManagerFactory::getEvaluacionEstadoManager();
		$oEvaluacionEstado = $managerEvaluacionEstado->getEntity($oCriteria);
		if (($oEvaluacionEstado->getEstado()->getOid()==CYT_ESTADO_SOLICITUD_EVALUADA)) {
			
			throw new GenericException( CYT_MSG_EVALUACION_MODIFICAR_PROHIBIDO);
		}
		if (($oEvaluacionEstado->getEstado()->getOid()==CYT_ESTADO_SOLICITUD_RECIBIDA)) {
			
			throw new GenericException( CYT_MSG_EVALUACION_EVALUAR_PROHIBIDO);
		}
			
		$oSolicitudManager =  ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($solicitud_oid);
				
		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getObjectByCode($oSolicitud->getDocente()->getOid());
		
		$entity->setDs_investigador($oDocente->getDs_apellido().', '.$oDocente->getDs_nombre());
		
		
		$oFacultadManager =  CYTSecureManagerFactory::getFacultadManager();
		$oFacultad = $oFacultadManager->getObjectByCode($oSolicitud->getFacultadplanilla()->getOid());
        
		$entity->setDs_facultad($oFacultad->getDs_facultad());
		
		
		
		$oPeriodoManager = CYTSecureManagerFactory::getPeriodoManager();
		$oPerioActual = $oPeriodoManager->getPeriodoActual(CYT_PERIODO_YEAR);
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_periodo', $oPerioActual->getOid(), '=');
		$oCriteria->addFilter('cd_motivo', $oSolicitud->getMotivo()->getOid(), '=');
		$oCriteria->addFilter('cd_tipoinvestigador', $oSolicitud->getTipoInvestigador()->getOid(), '=');
		$managerModeloPlanilla =  ManagerFactory::getModeloPlanillaManager();
		$oModeloPlanilla = $managerModeloPlanilla->getEntity($oCriteria);
		
		//print_r($oModeloPlanilla);

		$entity->setModeloPlanilla_oid($oModeloPlanilla->getOid()); 
		
		$entity->setNu_max($oModeloPlanilla->getNu_max()); 
		
		$html = '';
		$entity->setDs_motivo($oModeloPlanilla->getDs_motivo());
		
		
		$html .='<table style="width:100%; border-style: solid; border-width: 1px;  border-color: #666 ;margin-bottom:5px"><tr style="border-style: solid; border-width: 1px; border-color: #666">';
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $oModeloPlanilla->getOid(), '=');
		$oCategoriaMaximoManager =  ManagerFactory::getCategoriaMaximoManager();
		$categorias = $oCategoriaMaximoManager->getEntities($oCriteria);
		
		/*$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_evaluacion', $entity->getOid(), '=');
		$oPuntajeCategoriaManager =  ManagerFactory::getPuntajeCategoriaManager();
		$oPuntajecategoria = $oPuntajeCategoriaManager->getEntity($oCriteria);
		if (empty($oPuntajecategoria)) {*/
			$cd_categoria = ($oSolicitud->getCategoria()->getOid() == 11)?1:$oSolicitud->getCategoria()->getOid();
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_modeloplanilla', $oModeloPlanilla->getOid(), '=');
			$oCriteria->addFilter('cd_categoria', $cd_categoria, '=');
			$oCategoriaMaximoManager =  ManagerFactory::getCategoriaMaximoManager();
			$oCategoriaMaximo = $oCategoriaMaximoManager->getEntity($oCriteria);
			$oPuntajecategoria = new PuntajeCategoria();
			$oPuntajecategoria->setCategoriaMaximo($oCategoriaMaximo);
		//}
		
		$html .= '<td style="background-color: #eee;color:#333; width:80px">'.CYT_MSG_EVALUACION_CATEGORIA.'<br><strong>'.CYT_MSG_EVALUACION_MAX.' '.$categorias->getObjectByIndex(1)->getNu_max().CYT_MSG_EVALUACION_PT.'</strong></td>';
		
		for($i = 0; $i < $categorias->size(); $i ++) {	
			
			$checked = (($oPuntajecategoria)&&($oPuntajecategoria->getCategoriaMaximo()->getOid()==$categorias->getObjectByIndex($i)->getOid()))?' CHECKED ':'';
			$html .='<td style="background-color: #fff;color:#333;"><input name="cd_categoriamaximo" id="cd_categoriamaximo" type="radio" value="'.$categorias->getObjectByIndex($i)->getOid().'-'.$categorias->getObjectByIndex($i)->getNu_max().'" onclick="sumar_total(this);"'.$checked.' DISABLED />'.$categorias->getObjectByIndex($i)->getCategoria()->getDs_categoria().' ('.$categorias->getObjectByIndex($i)->getNu_max().'pt.)</td>';
			
			
			
		
		}	
		$html .='<td style="background-color: #eee;color:#333; width:80px"><div align="right"><span id="spanCategoria"></span></div></td>';
		
         $html .='</tr>
	                </table>';
		
		$html .='<table style="width:100%; border-style: solid; border-width: 1px;  border-color: #666;margin-bottom:5px"><tr style="border-style: solid; border-width: 1px; border-color: #666">';
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $oModeloPlanilla->getOid(), '=');
		$oCargoMaximoManager =  ManagerFactory::getCargoMaximoManager();
		$cargos = $oCargoMaximoManager->getEntities($oCriteria);
		
		/*$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_evaluacion', $entity->getOid(), '=');
		$oPuntajeCargoManager =  ManagerFactory::getPuntajeCargoManager();
		$oPuntajecargo = $oPuntajeCargoManager->getEntity($oCriteria);
		
		
		 if (empty($oPuntajecargo)) {*/
			$cd_cargo=0;
			
			switch ($oSolicitud->getCargo()->getOid()) {
				case '1':
					$cd_cargo = 1;
				break;
				case '2':
					$cd_cargo = 5;
				break;
				case '3':
					$cd_cargo = 3;
				break;
				case '4':
					$cd_cargo = 7;
				break;
				case '5':
					$cd_cargo = 9;
				break;
				case '7':
					$cd_cargo = 2;
				break;
				case '8':
					$cd_cargo = 6;
				break;
				case '9':
					$cd_cargo = 4;
				break;
				case '10':
					$cd_cargo = 8;
				break;
				case '11':
					$cd_cargo = 10;
				break;
			}
			
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_modeloplanilla', $oModeloPlanilla->getOid(), '=');
			$oCriteria->addFilter('cd_cargoplanilla', $cd_cargo, '=');
			$oCargoMaximoManager =  ManagerFactory::getCargoMaximoManager();
			$oCargoMaximo = $oCargoMaximoManager->getEntity($oCriteria);
			$oPuntajecargo = new PuntajeCargo();
			$oPuntajecargo->setCargoMaximo($oCargoMaximo);
			
		//}
		 $html .= '<td style="background-color: #eee;color:#333; width:80px">'.CYT_MSG_EVALUACION_CARGO.' '.CYT_MSG_EVALUACION_CARGO_ACTUAL.'<br /><strong>'.CYT_MSG_EVALUACION_MAX.' '.$cargos->getObjectByIndex(0)->getNu_max().CYT_MSG_EVALUACION_PT.'</strong></td>';
		 
		 $html .= '<td><table style="width:100%">';
		for($i = 0; $i < $cargos->size(); $i ++) {	
			$html .= '<tr>';
			for($j = 0; $j < 2; $j ++) {	
				$checked = (($oPuntajecargo)&&($oPuntajecargo->getCargoMaximo()->getOid()==$cargos->getObjectByIndex($i+$j)->getOid()))?' CHECKED ':'';
				$html .='<td style="background-color: #fff;color:#333;"><input name="cd_cargomaximo" id="cd_cargomaximo" type="radio" value="'.$cargos->getObjectByIndex($i+$j)->getOid().'-'.$cargos->getObjectByIndex($i+$j)->getNu_max().'" onclick="sumar_total(this);"'.$checked.' DISABLED/>'.$cargos->getObjectByIndex($i+$j)->getCargoPlanilla()->getDs_cargoplanilla().' ('.$cargos->getObjectByIndex($i+$j)->getNu_max().'pt.)</td>';
				
			}
			$i++;
			$html .= '</tr>';
		}	
	                        
	    $html .='</table></td><td style="background-color: #eee;color:#333; width:80px"><div align="right"><span id="spanCargo"></span></div></td>';
		
		
        $html .='</tr>
	                </table>';
        
        $html .='<table style="width:100%"><tr></tr><tr ><td style="width:80px">&nbsp;</td><td><div align="right">'.CYT_MSG_EVALUACION_CANT.'</div></td><td style="width:80px">&nbsp;</td></tr></table><table style="width:100%; border-style: solid; border-width: 1px;  border-color: #666;margin-bottom:5px"><tr style="border-style: solid; border-width: 1px; border-color: #666">';
        
        $oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $oModeloPlanilla->getOid(), '=');
		$oCriteria->addOrder('itemplanilla.nu_orden');
		$oCriteria->addOrder('itemplanilla.cd_itemplanilla');
		$oItemMaximoManager =  ManagerFactory::getItemMaximoManager();
		$items = $oItemMaximoManager->getEntities($oCriteria);
		
		
		$ds_titulo=(!in_array($oModeloPlanilla->getOid(),explode(",",CYT_MODELO_PLANILLA_C)))?'':' '.CYT_MSG_EVALUACION_CV_SOLICITANTE;
		
        $iteradores = explode(",",CYT_MODELO_PLANILLA_ITERADORES);
		$arrayIteradores = array();
		foreach ($iteradores as $claveValor) {
			$divisor = explode("=>",$claveValor);
			$arrayIteradores[$divisor[0]]=$divisor[1];
		}
		$itemiterador = $arrayIteradores[$oModeloPlanilla->getOid()];
		
		$iteradores = explode(",",CYT_MODELO_PLANILLA_ITERADORES_2);
		$arrayIteradores = array();
		foreach ($iteradores as $claveValor) {
			$divisor = explode("=>",$claveValor);
			$arrayIteradores[$divisor[0]]=$divisor[1];
		}
		$itemiterador2 = $arrayIteradores[$oModeloPlanilla->getOid()];  

		
		
		$submax=0;
		$max=0;
		$ds_item='<input type="hidden"  name="nu_iterador1" id="nu_iterador1" value="'.$itemiterador.'">';
		$ds_item.='<input type="hidden"  name="nu_iterador2" id="nu_iterador2" value="'.$itemiterador2.'">';
		 for($i = 0; $i < $itemiterador; $i ++) {	
			
			if ($submax!=$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid() ){
				$max +=$items->getObjectByIndex($i)->getPuntajeGrupo()->getNu_max();
				if ($i!=0)
					$ds_item .='<tr style="background-color: #eee;color:#333;""><td></td><td colspan="2"><div align="right"><strong>'.CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')</strong></div><input type="hidden"  name="nu_maxgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" id="nu_maxgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" value="'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().'"></td><td style="text-align:right"><span id="spangrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" ></span><div id="divgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" class="fValidator-a"></div></td></tr>';
				$submax=$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid();
			}
		 	$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_evaluacion', $entity->getOid(), '=');
			$oCriteria->addFilter('cd_itemmaximo', $items->getObjectByIndex($i)->getOid(), '=');
			$oPuntajeItemManager =  ManagerFactory::getPuntajeItemManager();
			$oPuntajeitem = $oPuntajeItemManager->getEntity($oCriteria);
			$nu_cant = (($oPuntajeitem)&&($oPuntajeitem->getNu_cantidad()))?$oPuntajeitem->getNu_cantidad():'';
			$nu_puntaje = (($oPuntajeitem)&&($oPuntajeitem->getNu_puntaje()))?$oPuntajeitem->getNu_puntaje():'';
			$hasta = ($items->getObjectByIndex($i)->getNu_min())?$items->getObjectByIndex($i)->getNu_max():CYT_MSG_EVALUACION_HASTA.' '.$items->getObjectByIndex($i)->getNu_max();
			$ds_item .='<tr style="background-color: #fff;color:#333;"><td style="width:450px;">'.$items->getObjectByIndex($i)->getItemPlanilla()->getDs_itemplanilla().'</td>  <td style="width:120px"><input type="hidden"  name="nu_maxitem'.$i.'" id="nu_maxitem'.$i.'" value="'.$items->getObjectByIndex($i)->getNu_max().'"><input type="hidden"  name="nu_minitem'.$i.'" id="nu_minitem'.$i.'" value="'.$items->getObjectByIndex($i)->getNu_min().'"><input type="hidden"  name="cd_puntajegrupo'.$i.'" id="cd_puntajegrupo'.$i.'" value="'.$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid().'">'.$hasta.' c/u</td><td><input type="text" size="5" name="nu_cantitem'.$items->getObjectByIndex($i)->getOid().'" id="nu_cantitem'.$i.'" value="'.$nu_cant.'" onChange="sumar_total(this);" jval="{valid:function (val) { return isInteger(val,\''.CYT_CMP_FORM_MSG_INVALID_NUMBER.'\');}}"></td><td style="background-color: #eee;color:#333; width:80px"><div align="right">';
			if ($items->getObjectByIndex($i)->getNu_min()==$items->getObjectByIndex($i)->getNu_max()) {
				$ds_item .= '<div id="divnu_puntajeitem'.$i.'"></div><input type="hidden" size="5" name="nu_puntajeitem'.$items->getObjectByIndex($i)->getOid().'" id="nu_puntajeitem'.$i.'" value="'.$nu_puntaje.'" onChange="sumar_total(this);" jval="{valid:function (val) { return number(val,\''.CDT_CMP_FORM_MSG_INVALID_NUMBER.'\');}}"></div><div id="divpuntajeitem'.$i.'" class="fValidator-a"></div></td>';
			}
			else{
			$ds_item .= '<input type="text" size="5" name="nu_puntajeitem'.$items->getObjectByIndex($i)->getOid().'" id="nu_puntajeitem'.$i.'" value="'.$nu_puntaje.'" onChange="sumar_total(this);" jval="{valid:function (val) { return number(val,\''.CDT_CMP_FORM_MSG_INVALID_NUMBER.'\');}}"></div><div id="divpuntajeitem'.$i.'" class="fValidator-a"></div></td>';
			}
			$ds_item .= '</tr>
	                           ';
			
			
		}	

		
	     $ds_item .='<tr style="background-color: #eee;color:#333;""><td></td><td colspan="2"><div align="right"><strong>'.CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')</strong></div><input type="hidden"  name="nu_maxgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" id="nu_maxgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" value="'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().'"></td><td style="text-align:right"><span id="spangrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" ></span><div id="divgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" class="fValidator-a"></div></td></tr>';

	    if($items->getObjectByIndex(0)->getPuntajeGrupo()->getCd_grupopadre()){
			$oPuntajeGrupoManager =  ManagerFactory::getPuntajeGrupoManager();
			$oPuntajeGrupo = $oPuntajeGrupoManager->getObjectByCode($items->getObjectByIndex(0)->getPuntajeGrupo()->getCd_grupopadre());
			$max = $oPuntajeGrupo->getNu_max();
			$ds_item .='<tr style="background-color: #eee;color:#333;""><td colspan="3"><div align="right"><strong>'.CYT_MSG_EVALUACION_SUBTOTAL.' '.CYT_MSG_EVALUACION_PROD_ULTIMOS.' '.CYT_MSG_EVALUACION_5_YEARS.'('.CYT_MSG_EVALUACION_MAX.' '.$max.')</strong></div><input type="hidden"  name="nu_maxgrupoItem" id="nu_maxgrupoItem" value="'.$max.'"></td><td style="text-align:right"><span id="spangrupoItem" ></span><div id="divgrupoItem" class="fValidator-a"></div></td></tr>';
		}

	     
	    $ds_item .= '</table>
	                        </td>';
	    
	    $ds_item1 = '<td style="background-color: #eee;color:#333; width:80px">'.CYT_MSG_EVALUACION_PROD_ULTIMOS.' '.CYT_MSG_EVALUACION_5_YEARS.' '.$ds_titulo.' ('.CYT_MSG_EVALUACION_CONSIDERAR_PUBLICADO.')<br> <strong>'.CYT_MSG_EVALUACION_MAX.' '.$max.'pt</strong></td><td><table style="width:100%">';
		
		
        
        $html .=$ds_item1.$ds_item.'</tr>
	                </table>';
        
        $html .='<table style="width:100%; border-style: solid; border-width: 1px;  border-color: #666;margin-bottom:5px"><tr style="border-style: solid; border-width: 1px; border-color: #666">';
        $submax=0;
		$max=0;
		$ds_item='';
		 for($i = $itemiterador; $i < $itemiterador2; $i ++) {	
			
			if ($submax!=$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid() ){
				$max +=$items->getObjectByIndex($i)->getPuntajeGrupo()->getNu_max();
				if ($i!=$itemiterador)
					$ds_item .='<tr style="background-color: #eee;color:#333;""><td></td><td colspan="2"><div align="right"><strong>'.CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')</strong></div><input type="hidden"  name="nu_maxgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" id="nu_maxgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" value="'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().'"></td><td style="text-align:right"><span id="spangrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" ></span><div id="divgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" class="fValidator-a"></div></td></tr>';
				$submax=$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid();
			}
		 	$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_evaluacion', $entity->getOid(), '=');
			$oCriteria->addFilter('cd_itemmaximo', $items->getObjectByIndex($i)->getOid(), '=');
			$oPuntajeItemManager =  ManagerFactory::getPuntajeItemManager();
			$oPuntajeitem = $oPuntajeItemManager->getEntity($oCriteria);
			$nu_cant = (($oPuntajeitem)&&($oPuntajeitem->getNu_cantidad()))?$oPuntajeitem->getNu_cantidad():'';
			$nu_puntaje = (($oPuntajeitem)&&($oPuntajeitem->getNu_puntaje()))?$oPuntajeitem->getNu_puntaje():'';
			$hasta = ($items->getObjectByIndex($i)->getNu_min())?$items->getObjectByIndex($i)->getNu_max():CYT_MSG_EVALUACION_HASTA.' '.$items->getObjectByIndex($i)->getNu_max();
			//$ds_item .= '<tr>';
			$ds_item .='<tr style="background-color: #fff;color:#333;"><td style="width:450px;">'.$items->getObjectByIndex($i)->getItemPlanilla()->getDs_itemplanilla().'</td>  <td style="width:120px"><input type="hidden"  name="nu_maxitem'.$i.'" id="nu_maxitem'.$i.'" value="'.$items->getObjectByIndex($i)->getNu_max().'"><input type="hidden"  name="nu_minitem'.$i.'" id="nu_minitem'.$i.'" value="'.$items->getObjectByIndex($i)->getNu_min().'"><input type="hidden"  name="cd_puntajegrupo'.$i.'" id="cd_puntajegrupo'.$i.'" value="'.$items->getObjectByIndex($i)->getPuntajeGrupo()->getOid().'">'.$hasta.' c/u</td><td><input type="text" size="5" name="nu_cantitem'.$items->getObjectByIndex($i)->getOid().'" id="nu_cantitem'.$i.'" value="'.$nu_cant.'" onChange="sumar_total(this);" jval="{valid:function (val) { return isInteger(val,\''.CYT_CMP_FORM_MSG_INVALID_NUMBER.'\');}}"></td><td style="background-color: #eee;color:#333; width:80px"><div align="right">';
			if ($items->getObjectByIndex($i)->getNu_min()==$items->getObjectByIndex($i)->getNu_max()) {
				$ds_item .= '<div id="divnu_puntajeitem'.$i.'"></div><input type="hidden" size="5" name="nu_puntajeitem'.$items->getObjectByIndex($i)->getOid().'" id="nu_puntajeitem'.$i.'" value="'.$nu_puntaje.'" onChange="sumar_total(this);" jval="{valid:function (val) { return number(val,\''.CDT_CMP_FORM_MSG_INVALID_NUMBER.'\');}}"></div><div id="divpuntajeitem'.$i.'" class="fValidator-a"></div></td>';
			}
			else{
			$ds_item .= '<input type="text" size="5" name="nu_puntajeitem'.$items->getObjectByIndex($i)->getOid().'" id="nu_puntajeitem'.$i.'" value="'.$nu_puntaje.'" onChange="sumar_total(this);" jval="{valid:function (val) { return number(val,\''.CDT_CMP_FORM_MSG_INVALID_NUMBER.'\');}}"></div><div id="divpuntajeitem'.$i.'" class="fValidator-a"></div></td>';
			}
			$ds_item .= '</tr>
	                           ';
			
			
		}	
	     $ds_item .='<tr style="background-color: #eee;color:#333;""><td></td><td colspan="2"><div align="right"><strong>'.CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')</strong></div><input type="hidden"  name="nu_maxgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" id="nu_maxgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" value="'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().'"></td><td style="text-align:right"><span id="spangrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" ></span><div id="divgrupo'.$items->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" class="fValidator-a"></div></td></tr>';

		
			$ds_item .='<tr style="background-color: #eee;color:#333;""><td colspan="3"><div align="right"><strong>'.CYT_MSG_EVALUACION_SUBTOTAL.' '.CYT_MSG_EVALUACION_FORMACION.' '.CYT_MSG_EVALUACION_RR_HH.'('.CYT_MSG_EVALUACION_MAX.' '.$max.')</strong></div><input type="hidden"  name="nu_maxgrupoItem2" id="nu_maxgrupoItem2" value="'.$max.'"></td><td style="text-align:right"><span id="spangrupoItem2" ></span><div id="divgrupoItem2" class="fValidator-a"></div></td></tr>';
		
	     
	     
	    $ds_item .= '</table>
	                        </td>';
	    
	     $ds_item1 = '<td style="background-color: #eee;color:#333; width:80px">'.CYT_MSG_EVALUACION_FORMACION.' '.CYT_MSG_EVALUACION_RR_HH.'<br> <strong>'.CYT_MSG_EVALUACION_MAX.' '.$max.'pt</strong></td><td><table style="width:100%">';
		             

         $html .=$ds_item1.$ds_item.'</tr>
	                </table>';
		
         if (!in_array($oModeloPlanilla->getOid(),explode(",",CYT_MODELO_PLANILLA_A))){
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_modeloplanilla', $oModeloPlanilla->getOid(), '=');
			$oPlanMaximoManager =  ManagerFactory::getPlanMaximoManager();
			$plans = $oPlanMaximoManager->getEntities($oCriteria);
						
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_evaluacion', $entity->getOid(), '=');
			$oPuntajePlanManager =  ManagerFactory::getPuntajePlanManager();
			$oPuntajeplan = $oPuntajePlanManager->getEntity($oCriteria);
			$nu_puntaje = ($oPuntajeplan && $oPuntajeplan->getNu_puntaje())?$oPuntajeplan->getNu_puntaje():'';
			
		
			$ds_descripcion=(!in_array($oModeloPlanilla->getOid(),explode(",",CYT_MODELO_PLANILLA_C)))?CYT_MSG_EVALUACION_PLAN_TRABAJO.'<br><strong>'.CYT_MSG_EVALUACION_MAX.' '.$plans->getObjectByIndex(0)->getNu_max().CYT_MSG_EVALUACION_PT.'</strong>':CYT_MSG_EVALUACION_PLAN_TRABAJO.' '.CYT_MSG_EVALUACION_CV_VISITANTE.'<br><strong>'.CYT_MSG_EVALUACION_MAX.' '.$plans->getObjectByIndex(0)->getNu_max().CYT_MSG_EVALUACION_PT.'</strong>';
			$ds_descripcion_anexo=(!in_array($oModeloPlanilla->getOid(),explode(",",CYT_MODELO_PLANILLA_C)))?CYT_MSG_EVALUACION_PLAN_TRABAJO_ANEXO:'';
			$html .= '<table style="width:100%; border-style: solid; border-width: 1px;  border-color: #666 ;margin-bottom:5px"><tr style="border-style: solid; border-width: 1px; border-color: #666"><td style="background-color: #eee;color:#333; width:80px">'.$ds_descripcion.'</strong></td>';
			
			for($i = 0; $i < $plans->size(); $i ++) {	
				$html .='<td style="background-color: #fff;color:#333; text-align:left;" colspan="4">'.$ds_descripcion_anexo.'<input type="hidden"  name="nu_maxplan'.$i.'" id="nu_maxplan'.$i.'" value="'.$plans->getObjectByIndex($i)->getNu_max().'"></td><td style="background-color: #eee;color:#333; width:80px"><div align="right"><input type="text" size="5" name="nu_puntajeplan'.$i.'" id="nu_puntajeplan'.$i.'" value="'.$nu_puntaje.'" onChange="sumar_total(this);"  jval="{valid:function (val) { return number(val,\''.CDT_CMP_FORM_MSG_INVALID_NUMBER.'\');}}" </div><div id="divpuntajeplan'.$i.'" class="fValidator-a"></div></td>';
		
			}	
			$ds_justificacionplan = ($oPuntajeplan && $oPuntajeplan->getDs_justificacion())?$oPuntajeplan->getDs_justificacion():'';
			 $html .='<tr style="border-style: solid; border-width: 1px; border-color: #666"><td style="background-color: #eee;color:#333; width:80px">'.CYT_MSG_EVALUACION_PLAN_TRABAJO_JUSTIFICACION.'</strong></td>
			 <td style="background-color: #fff;color:#333; text-align:left;" colspan="5"><textarea name="ds_justificacionplan" id="ds_justificacionplan" style="width:650px" rows="3">'.$ds_justificacionplan.'</textarea></td>
			 </tr>
	                </table>';
			
             
		
		} 
          $html .='<table style="width:100%; border-style: solid; border-width: 1px;  border-color: #666;margin-bottom:5px"><tr style="border-style: solid; border-width: 1px; border-color: #666">';
		
		 
        $oCriteria = new CdtSearchCriteria();
		$tUnidadAprobada = CYTSecureDAOFactory::getUnidadAprobadaDAO()->getTableName();
		$oCriteria->addFilter("$tUnidadAprobada.cd_periodo", $oPerioActual->getOid(), '=');
		$oCriteria->addFilter("$tUnidadAprobada.cd_unidad", $oSolicitud->getLugarTrabajo()->getOid(), '=');
		
		$checkedUnidad='';
		$oUnidadAprobadaManager =  CYTSecureManagerFactory::getUnidadAprobadaManager();
		$oUnidadAprobada = $oUnidadAprobadaManager->getEntity($oCriteria);
		if ($oUnidadAprobada) {
			$checkedUnidad = ' CHECKED ';
		}
		elseif ($oSolicitud->getLugarTrabajoCarrera()->getOid()) {
			$oCriteria = new CdtSearchCriteria();
			$tUnidadAprobada = CYTSecureDAOFactory::getUnidadAprobadaDAO()->getTableName();
			$oCriteria->addFilter("$tUnidadAprobada.cd_periodo", $oPerioActual->getOid(), '=');
			$oCriteria->addFilter("$tUnidadAprobada.cd_unidad", $oSolicitud->getLugarTrabajoCarrera()->getOid(), '=');
			$oUnidadAprobadaManager =  CYTSecureManagerFactory::getUnidadAprobadaManager();
			$oUnidadAprobada = $oUnidadAprobadaManager->getEntity($oCriteria);
			if ($oUnidadAprobada) {
				$checkedUnidad = ' CHECKED ';
			}
		} 
		if (($checkedUnidad != ' CHECKED ')&&($oSolicitud->getLugarTrabajoBeca()->getOid())) {
			$oCriteria = new CdtSearchCriteria();
			$tUnidadAprobada = CYTSecureDAOFactory::getUnidadAprobadaDAO()->getTableName();
			$oCriteria->addFilter("$tUnidadAprobada.cd_periodo", $oPerioActual->getOid(), '=');
			$oCriteria->addFilter("$tUnidadAprobada.cd_unidad", $oSolicitud->getLugarTrabajoBeca()->getOid(), '=');
			$oUnidadAprobadaManager =  CYTSecureManagerFactory::getUnidadAprobadaManager();
			$oUnidadAprobada = $oUnidadAprobadaManager->getEntity($oCriteria);
			if ($oUnidadAprobada) {
				$checkedUnidad = ' CHECKED ';
			}
		} 
		
		
		$oCriteria = new CdtSearchCriteria();
		$oCriteria->addFilter('cd_modeloplanilla', $oModeloPlanilla->getOid(), '=');
		$oCriteria->addOrder('eventoplanilla.nu_orden');
		$oCriteria->addOrder('eventoplanilla.cd_eventoplanilla');
		$oEventoMaximoManager =  ManagerFactory::getEventoMaximoManager();
		$eventos = $oEventoMaximoManager->getEntities($oCriteria);       

		$submax=0;
		$max=0;
		$ds_evento='<input type="hidden"  name="nu_cantevento" id="nu_cantevento" value="'.$eventos->size().'">';
		 for($i = 0; $i < $eventos->size(); $i ++) {	
			
			if ($submax!=$eventos->getObjectByIndex($i)->getPuntajeGrupo()->getOid() ){
				$max +=$eventos->getObjectByIndex($i)->getPuntajeGrupo()->getNu_max();
				if ($i!=0)
					$ds_evento .='<tr style="background-color: #eee;color:#333;""><td></td><td colspan="3"><div align="right"><strong>'.CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')</strong></div><input type="hidden"  name="nu_maxgrupoevento'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" id="nu_maxgrupoevento'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" value="'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().'"><div id="divgrupo'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" class="fValidator-a"></td></tr>';
				$submax=$eventos->getObjectByIndex($i)->getPuntajeGrupo()->getOid();
			}
			$oCriteria = new CdtSearchCriteria();
			$oCriteria->addFilter('cd_evaluacion', $entity->getOid(), '=');
			$oCriteria->addFilter('cd_eventomaximo', $eventos->getObjectByIndex($i)->getOid(), '=');
			$oPuntajeEventoManager =  ManagerFactory::getPuntajeEventoManager();
			$oPuntajeevento = $oPuntajeEventoManager->getEntity($oCriteria);
			$nu_puntaje = (!empty($oPuntajeevento))?$oPuntajeevento->getNu_puntaje():'';
			$ds_justificacion = (!empty($oPuntajeevento))?$oPuntajeevento->getDs_justificacion():'';
			$hasta = ($eventos->getObjectByIndex($i)->getNu_min())?$eventos->getObjectByIndex($i)->getNu_max():CYT_MSG_EVALUACION_HASTA.' '.$eventos->getObjectByIndex($i)->getNu_max();
		 	
		 	$checked = (($oPuntajeevento)&&($eventos->getObjectByIndex($i)->getNu_min())&&($oPuntajeevento->getOid())&&($oPuntajeevento->getEventoMaximo()->getOid()==$eventos->getObjectByIndex($i)->getOid()))?' CHECKED ':'';
		 	$disabled ='';
		 	if ($i==$eventos->size()-1) {//OJOOO!!! estÃ¡ harcodeado segÃºn el Ã­tem del evento (si se agragan mÃ¡s Ã­tem deja de funcionar), es la parte de lugares de trabajos aprobados
		 		$checked = $checkedUnidad;
		 		$disabled=' DISABLED ';
		 	}
		 	$input = ($eventos->getObjectByIndex($i)->getNu_min())?'<input type="checkbox" size="5" name="nu_puntajeevento'.$eventos->getObjectByIndex($i)->getOid().'" id="nu_puntajeevento'.$i.'" value="'.$eventos->getObjectByIndex($i)->getNu_max().'"'.$checked.$disabled.' onclick="sumar_total(this);">':'<input type="text" size="5" name="nu_puntajeevento'.$eventos->getObjectByIndex($i)->getOid().'" id="nu_puntajeevento'.$i.'" value="'.$nu_puntaje.'" onChange="sumar_total(this);" jval="{valid:function (val) { return number(val,\''.CDT_CMP_FORM_MSG_INVALID_NUMBER.'\');}}">';
		 	if ((strchr($eventos->getObjectByIndex($i)->getEventoPlanilla()->getDs_eventoplanilla(),'Evento'))&&($oSolicitud->getPeriodo()->getOid()<CYT_SOLICITUD_PERIODO_2013)) {
		 		$checked = (($oPuntajeevento)&&($oPuntajeevento->getOid())&&($oPuntajeevento->getEventoMaximo()->getOid()==$eventos->getObjectByIndex($i)->getOid()))?' CHECKED ':'';
		 		
		 		$input ='<input type="radio" name="nu_puntajeevento" id="nu_puntajeevento'.$i.'" value="'.$eventos->getObjectByIndex($i)->getOid().'" onclick="sumar_total(this);"'.$checked.'>';
		 	}
		 	
			$ds_evento .='<td style="width:450px">'.$eventos->getObjectByIndex($i)->getEventoPlanilla()->getDs_eventoplanilla().'</td>  <td style="width:120px"><input type="hidden"  name="nu_maxevento'.$i.'" id="nu_maxevento'.$i.'" value="'.$eventos->getObjectByIndex($i)->getNu_max().'"><input type="hidden"  name="nu_minevento'.$i.'" id="nu_minevento'.$i.'" value="'.$eventos->getObjectByIndex($i)->getNu_min().'"><input type="hidden"  name="cd_puntajegrupoevento'.$i.'" id="cd_puntajegrupoevento'.$i.'" value="'.$eventos->getObjectByIndex($i)->getPuntajeGrupo()->getOid().'">'.$hasta.'</td><td></td><td style="background-color: #eee;color:#333; width:80px"><div align="right">'.$input.'</div><div id="divpuntajeevento'.$i.'" class="fValidator-a"></div></td>';
			
			$ds_evento .= '</tr>
	                           ';
			if (!$eventos->getObjectByIndex($i)->getNu_min()) {
				$ds_evento .='<tr><td colspan="4">'.CYT_MSG_EVALUACION_EVENTO_JUSTIFICACION.'</td><tr>';
				$ds_evento .='<tr><td colspan="4"><textarea name="ds_justificacionevento'.$eventos->getObjectByIndex($i)->getOid().'" id="ds_justificacionplan'.$i.'" style="width:650px" rows="3">'.$ds_justificacion.'</textarea></td><tr>';
			}
			
			
			
		}	
	     $ds_evento .='<tr style="background-color: #eee;color:#333;""><td></td><td colspan="2"><div align="right"><strong>'.CYT_MSG_EVALUACION_SUBTOTAL.' ('.CYT_MSG_EVALUACION_MAX.' '.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().')</strong></div><input type="hidden"  name="nu_maxgrupoevento'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" id="nu_maxgrupoevento'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" value="'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getNu_max().'"></td><td style="text-align:right"><span id="spangrupo'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" ></span><div id="divgrupo'.$eventos->getObjectByIndex($i-1)->getPuntajeGrupo()->getOid().'" class="fValidator-a"></td></tr>';
				
	    $ds_evento .= '</table>
	                        </td>';
	    $ds_evento1 = '<td style="background-color: #eee;color:#333; width:80px">Max. '.$max.'pt</td><td><table style="width:100%">';
          $html .=$ds_evento1.$ds_evento.'</tr>
	                </table>';
         
		$entity->setDs_contenido($html);
		
		
		//CYTSecureUtils::logObject($entity);
		return $entity;
	}
	
	protected function parseEntity($entity, XTemplate $xtpl) {

			
		
		parent::parseEntity($entity, $xtpl);
		
	}
	
	protected function getEntityManager(){
		//return ManagerFactory::getEvaluacionManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewFormInstance()
	 */
	public function getNewFormInstance($action){
		$form = new CMPEvaluacionForm($action);
		return $form;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityInitAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$oEvaluacion = new Evaluacion();
		return $oEvaluacion;
	}


	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getOutputTitle();
	 */
	protected function getOutputTitle(){
		return CYT_MSG_SOLICITUD_TITLE_EVALUAR;
	}

	/**
	 * retorna el action para el submit.
	 * @return string
	 */
	protected function getSubmitAction(){
		return "evaluar_solicitud";
	}


}