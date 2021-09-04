<?php

/**
 * Utilidades para el sistema.
 *
 * @author Marcos
 * @since 13-11-2013
 */
class CYTUtils {
	

	public static function getMotivosItems() {

		return CYTSecureUtils::getFilterOptionItems( ManagerFactory::getMotivoManager(), "oid", "ds_letra","","","","cd_motivo");

	}
	
	public static function getMotivosDescripcionItems() {

		return CYTSecureUtils::getFilterOptionItems( ManagerFactory::getMotivoManager(), "oid", "ds_motivo","","","","cd_motivo");

	}
	
	
	
	
}
