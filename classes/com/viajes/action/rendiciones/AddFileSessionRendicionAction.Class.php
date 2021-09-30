<?php

/**
 * Acción para dar de alta un archivo de rendicion.
 * El alta es sólo en sesión para ir armando la rendicion.
 *
 * @author Marcos
 * @since 28-09-2021
 *
 */
class AddFileSessionRendicionAction extends CdtAction{


	public function getVariableSessionName(){
		return "archivos";
	}

	public function execute(){
		$error='';
		$oSolicitudManager =  ManagerFactory::getSolicitudManager();
		$oSolicitud = $oSolicitudManager->getObjectByCode(CdtUtils::getParam('solicitud_oid'));
		if(isset($_SESSION[$this->getVariableSessionName()]))
			$archivos = unserialize( $_SESSION[$this->getVariableSessionName()] );
		else
			$archivos = array();
		foreach ($_FILES as $key => $value) {
			if ($value["size"]<=CYT_FILE_MAX_SIZE) {
				switch ($key) {
            		case 'ds_rendicion':
                        $nombre = CYT_LBL_RENDICION_RENDICION;
                        $sigla = CYT_LBL_RENDICION_RENDICION_SIGLA;
            		break;
                    case 'ds_informe':
                        $nombre = CYT_LBL_RENDICION_INFORME;
                        $sigla = CYT_LBL_RENDICION_INFORME_SIGLA;
                        break;
                    case 'ds_certificado':
                        $nombre = CYT_LBL_RENDICION_CONSTANCIA;
                        $sigla = CYT_LBL_RENDICION_CONSTANCIA_SIGLA;
                        break;

            	}
				$explode_name = explode('.', $value['name']);
	            //Se valida así y no con el mime type porque este no funciona par algunos programas
	            $pos_ext = count($explode_name) - 1;
	            if (in_array(strtolower($explode_name[$pos_ext]), explode(",",CYT_EXTENSIONES_PERMITIDAS))) {
	            	//CdtUtils::log("FILE: "   . $key.' - '.$value['name']);
	            	$dir = CYT_PATH_PDFS.'/';
					if (!file_exists($dir)) mkdir($dir, 0777);
					$dir .= $oSolicitud->getPeriodo()->getDs_periodo().'/';
					if (!file_exists($dir)) mkdir($dir, 0777);
					/*$oUser = CdtSecureUtils::getUserLogged();
            		$separarCUIL = explode('-',trim($oUser->getDs_username()));*/
					$dir .= str_pad($oSolicitud->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT).'/';
					if (!file_exists($dir)) mkdir($dir, 0777);
					$dir .= PATH_RENDICIONES.'/';
					if (!file_exists($dir)) mkdir($dir, 0777);

					/*$oCriteria = new CdtSearchCriteria();
					$oCriteria->addFilter('nu_documento', $separarCUIL[1], '=');

					$oDocenteManager =  CYTSecureManagerFactory::getDocenteManager();
					$oDocente = $oDocenteManager->getEntity($oCriteria);*/
					$ds_apellido = CYTSecureUtils::stripAccents(stripslashes(str_replace("'","_",$oSolicitud->getDocente()->getDs_apellido())));
					$nuevo='TMP_'.$sigla.'_'.$ds_apellido.".".$explode_name[$pos_ext];

		     		$handle=opendir($dir);
					while ($archivo = readdir($handle))
					{
				        if ((is_file($dir.$archivo))&&((strchr($archivo,'TMP_'.$sigla.'_'))||(strchr($archivo,$sigla.'_'))))
				         {
				         	unlink($dir.$archivo);
						}
					}
					closedir($handle);

					//CdtUtils::log("DIRECTORIO: "   . $dir.$nuevo);
			        if (!move_uploaded_file($value['tmp_name'], $dir.$nuevo)){
						$error .='<span style="color:#FF0000; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_ERROR.$nombre.'</span>';
			        }
			        else{
			        	$error = '<span style="color:#009900; font-weight:bold">'.CYT_MSG_FILE_UPLOAD_EXITO.$value["name"]."(".$value["size"].")".'</span>';
			        }

	            }
	            else {

	            	$error .='<span style="color:#FF0000; font-weight:bold">'.CYT_MSG_FORMATO_INVALIDO.$nombre.'</span>';
	            }
			//CdtUtils::log("FILE: "   . $key.' => '.$value);
			$value['nuevo']=$nuevo;
			$archivos[$key]=$value;
			if ($error) {
				echo $error;
			}
		}
		else {

            	$error .='<span style="color:#FF0000; font-weight:bold">'.$value['name'].CYT_MSG_FILE_MAX_SIZE.'</span>';
            	echo $error;
            }
		}
		$_SESSION[$this->getVariableSessionName()] = serialize($archivos);
		//vamos a retornar por json los presupuestos de la solicitud.

		//usamos el renderer para reutilizar lo que mostramos de los presupuestos.


	}



}
