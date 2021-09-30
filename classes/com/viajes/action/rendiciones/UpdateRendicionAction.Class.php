<?php

/**
 * Acción para actualizar una rendicion
 *
 * @author Marcos
 * @since 04-03-2016
 *
 */
class UpdateRendicionAction extends UpdateEntityAction{

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
		$dir .= PATH_RENDICIONES.'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$entity->setFecha(date(DB_DEFAULT_DATETIME_FORMAT));
		if(isset($_SESSION['archivos'])){
			$archivos = unserialize( $_SESSION['archivos'] );
			
			foreach ($archivos as $key => $archivo) {
				//CdtUtils::log("FILE: "   . $key.' - '.$archivo['name']);
				switch ($key) {
            		case 'rendicion':
            		$nombre = CYT_LBL_RENDICION_RENDICION;
            		$sigla = CYT_LBL_RENDICION_RENDICION_SIGLA;
            		break;
            		case 'informe':
            		$nombre = CYT_LBL_RENDICION_INFORME;
            		$sigla = CYT_LBL_RENDICION_INFORME_SIGLA;
            		break;
            		case 'constancia':
            		$nombre = CYT_LBL_RENDICION_CONSTANCIA;
            		$sigla = CYT_LBL_RENDICION_CONSTANCIA_SIGLA;
            		break;
        
            	}
				$explode_name = explode('.', $archivo['name']);
	            //Se valida así y no con el mime type porque este no funciona par algunos programas
	            $pos_ext = count($explode_name) - 1;
	            if (in_array(strtolower($explode_name[$pos_ext]), explode(",",CYT_EXTENSIONES_PERMITIDAS))) {
	            	CdtUtils::log("FILE: "   . $key.' - '.$archivo['name']);
	            	if (is_file($dir.$archivo['nuevo'])){

	            		rename ($dir.$archivo['nuevo'],$dir.str_replace('TMP_'.$sigla, $sigla, $archivo['nuevo'])); 
	            		
	            	}
	            	CdtReflectionUtils::doSetter( $entity, $key, str_replace('TMP_'.$sigla, $sigla, $archivo['nuevo']) );
	            }
	            else {
	            	
	            	$error .=CYT_MSG_FORMATO_INVALIDO.$nombre.'<br />';
	            }
			}
		}
		unset($_SESSION['archivos']);
		$handle=opendir($dir);
		while ($archivo = readdir($handle)){
	        if ((is_file($dir.$archivo))&&(strchr($archivo,'TMP_'))){
	         	unlink($dir.$archivo);
			}
		}
		closedir($handle);
		if ($error) {
			throw new GenericException( $error );
		}
		
		
		
		return $entity;
	}
	
	public function getNewFormInstance(){
		return new CMPRendicionForm();
	}

	public function getNewEntityInstance(){
		$oRendicion = new Rendicion();
		
		return $oRendicion;
	}

	protected function getEntityManager(){
		return CYTSecureManagerFactory::getRendicionManager();
	}



	



}
