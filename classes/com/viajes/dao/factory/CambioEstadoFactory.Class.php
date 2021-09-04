<?php

/**
 * Factory para CambioEstado
 *  
 * @author Marcos
 * @since 08-06-2015
 */
class CambioEstadoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('CambioEstado');
        $cambioEstado = parent::build($next);
        
    	$factory = new EstadoFactory();
        $factory->setAlias( CYT_TABLE_ESTADO. "_" );
        $cambioEstado->setEstado( $factory->build($next) );
        
        $factory = new CambioFactory();
        $factory->setAlias( CYT_TABLE_SOLICITUD. "_" );
        $cambioEstado->setCambio( $factory->build($next) );
        
        

        return $cambioEstado;
    }

}
?>
