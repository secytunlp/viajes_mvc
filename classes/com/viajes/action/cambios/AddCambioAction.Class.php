<?php

/**
 * Acción para dar de alta una cambio
 *
 * @author Marcos
 * @since 09-06-2015
 *
 */
class AddCambioAction extends AddEntityAction{

	
	protected function getEntity() {
		
		$entity =  parent::getEntity();
		
		$oSolicitudManager =  ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode($entity->getSolicitud()->getOid());
		
		$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
		$oDocente = $oDocenteManager->getObjectByCode($oSolicitud->getDocente()->getOid());
		
		$error = '';
		$dir = CYT_PATH_PDFS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oSolicitud->getPeriodo()->getDs_periodo().'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oDocente->getNu_documento().'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$dir .= PATH_CAMBIOS.'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		
		$entity->setDt_fecha(date(DB_DEFAULT_DATETIME_FORMAT));
		if(isset($_SESSION['archivos'])){
			$archivos = unserialize( $_SESSION['archivos'] );
			
			foreach ($archivos as $key => $archivo) {
				//CdtUtils::log("FILE: "   . $key.' - '.$archivo['name']);
				switch ($key) {
            		case 'ds_archivo':
            		$nombre = CYT_LBL_CAMBIO_A_ARCHIVO;
            		$sigla = CYT_LBL_CAMBIO_A_CURRICULUM_SIGLA;
            		
            		break;
            		
        
            	}
				$explode_name = explode('.', $archivo['name']);
	            //Se valida así y no con el mime type porque este no funciona par algunos programas
	            $pos_ext = count($explode_name) - 1;
	            if (in_array(strtolower($explode_name[$pos_ext]), explode(",",CYT_EXTENSIONES_PERMITIDAS))) {
	            	/*CdtUtils::log("FILE: "   . $key.' - '.$archivo['name']);
	            	if (is_file($dir.$archivo['nuevo'])){

	            		rename ($dir.$archivo['nuevo'],$dir.str_replace('TMP_'.$sigla, $sigla, $archivo['nuevo'])); 
	            		
	            	}
	            	CdtReflectionUtils::doSetter( $entity, $key, str_replace('TMP_'.$sigla, $sigla, $archivo['nuevo']) );*/
	            }
	            else {
	            	
	            	$error .=CYT_MSG_FORMATO_INVALIDO.$nombre.'<br />';
	            }
			}
		}
		unset($_SESSION['archivos']);
		/*$handle=opendir($dir);
		while ($archivo = readdir($handle)){
	        if ((is_file($dir.$archivo))&&(strchr($archivo,'TMP_'))){
	         	unlink($dir.$archivo);
			}
		}
		closedir($handle);*/
		if ($error) {
			throw new GenericException( $error );
		}
		//agregamos los ambitos relacionados a la cambio.
		
		//ambitos.
		$ambitosManager = new AmbitoSessionManager();
		$entity->setAmbitos( $ambitosManager->getEntities(new CdtSearchCriteria()) );
		
		
		
		//presupuestos.
		$presupuestosManager = new PresupuestoSessionManager();
		$entity->setPresupuestos( $presupuestosManager->getEntities(new CdtSearchCriteria()) );
		
		
		return $entity;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewFormInstance()
	 */
	public function getNewFormInstance(){
		$form = new CMPCambioForm();
		return $form;
	}

	/**
	 * (non-PHPdoc)
	 * @see classes/com/gestion/action/entities/EditEntityAction::getNewEntityInstance()
	 */
	public function getNewEntityInstance(){
		$oCambio = new Cambio();
		
		return $oCambio;
	}

	protected function getEntityManager(){
		return ManagerFactory::getCambioManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see CdtEditAction::getForwardSuccess();
	 */
	protected function getForwardSuccess(){
		return 'add_cambio_success';
	
	}
	


}
