<?php

/**
 * Factory para Monto
 *  
 * @author Marcos
 * @since 21-11-2013
 */
class MontoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('Monto');
        $monto = parent::build($next);
        
        $factory = new SolicitudFactory();
        $factory->setAlias( CYT_TABLE_SOLICITUD. "_" );
        $monto->setSolicitud( $factory->build($next) );
        
        

        return $monto;
    }

}
?>
