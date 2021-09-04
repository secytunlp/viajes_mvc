<?php

/**
 * Factory para Ambito
 *  
 * @author Marcos
 * @since 17-11-2013
 */
class AmbitoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('Ambito');
        $ambito = parent::build($next);
        
        $factory = new SolicitudFactory();
        $factory->setAlias( CYT_TABLE_SOLICITUD. "_" );
        $ambito->setSolicitud( $factory->build($next) );
        
        

        return $ambito;
    }

}
?>
