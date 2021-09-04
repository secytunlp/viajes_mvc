<?php

/**
 * Formato para renderizar los archivos en las grillas
 *
 * @author Marcos
 * @since 10-06-2015
 *
 */
class GridFilesCambioValueFormat extends GridValueFormat {

	public function __construct() {

		parent::__construct();
	}

	public function format($value, $item=null) {

		$oManagerCambio = ManagerFactory::getCambioManager();
		$oCambio = $oManagerCambio->getObjectByCode($value);
		
		$oManagerSolicitud = ManagerFactory::getSolicitudManager();
		$oSolicitud = $oManagerSolicitud->getObjectByCode($oCambio->getSolicitud()->getOid());
		$adjuntos = '';
		$dir = APP_PATH.'pdfs/'.$oSolicitud->getPeriodo()->getDs_periodo().'/'.$oSolicitud->getDocente()->getNu_documento().'/'.PATH_CAMBIOS.'/';
		$dirREL = WEB_PATH.'pdfs/'.$oSolicitud->getPeriodo()->getDs_periodo().'/'.$oSolicitud->getDocente()->getNu_documento().'/'.PATH_CAMBIOS.'/';
		CdtUtils::log($dir);
		if (file_exists($dir)){
				
		      
		     $handle=opendir($dir);
				while ($archivo = readdir($handle))
				{
			        if ((is_file($dir.$archivo))&&(!strchr($archivo,CYT_MSG_CAMBIO_ARCHIVO_NOMBRE)))
			         {
			         	$adjuntos .='<a href="'.$dirREL.$archivo.'" target="_blank"><img class="hrefImg" src="'.WEB_PATH.'css/images/file.jpg" title="'.$archivo.'" /></a>';
			         	
			         	}
						
				}
				closedir($handle);
			}
		
		$documento = str_pad($oSolicitud->getDocente()->getNu_documento(), 8, "0", STR_PAD_LEFT);
		if (substr($documento,0,1)==0) {
			$dir = APP_PATH.'pdfs/'.$oSolicitud->getPeriodo()->getDs_periodo().'/'.$documento.'/'.PATH_CAMBIOS.'/';
			$dirREL = WEB_PATH.'pdfs/'.$oSolicitud->getPeriodo()->getDs_periodo().'/'.$documento.'/'.PATH_CAMBIOS.'/';
			
			if (file_exists($dir)){
					
			     
			     $handle=opendir($dir);
					while ($archivo = readdir($handle))
					{
				        if ((is_file($dir.$archivo))&&(!strchr($archivo,CYT_MSG_CAMBIO_ARCHIVO_NOMBRE)))
				         {
				         	$adjuntos .='<a href="'.$dirREL.$archivo.'" target="_blank"><img class="hrefImg" src="'.WEB_PATH.'css/images/file.jpg" title="'.$archivo.'" /></a>';
				         	
				         	}
							
					}
					closedir($handle);
			}
		}
		
		 
		return $adjuntos ;
	}

}