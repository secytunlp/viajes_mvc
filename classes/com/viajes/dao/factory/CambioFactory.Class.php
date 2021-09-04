<?php

/**
 * Factory para Cambio
 *  
 * @author Marcos
 * @since 08-06-2013
 */
class CambioFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('Cambio');
        $cambio = parent::build($next);
    	if(array_key_exists('cd_cambio',$next)){
        	$cambio->setOid( $next["cd_cambio"] );
        }
        
    	$factory = new EstadoFactory();
        $factory->setAlias( CYT_TABLE_ESTADO. "_" );
        $cambio->setEstado( $factory->build($next) );
        
        $factory = new SolicitudFactory();
        $factory->setAlias( CYT_TABLE_SOLICITUD. "_" );
        $cambio->setSolicitud( $factory->build($next) );
        
        

        return $cambio;
    }

}
?>
