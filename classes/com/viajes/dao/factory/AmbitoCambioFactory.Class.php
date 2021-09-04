<?php

/**
 * Factory para AmbitoCambio
 *  
 * @author Marcos
 * @since 09-06-2015
 */
class AmbitoCambioFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('AmbitoCambio');
        $ambito = parent::build($next);
        
        $factory = new CambioFactory();
        $factory->setAlias( CYT_TABLE_CAMBIO. "_" );
        $ambito->setCambio( $factory->build($next) );
        
        

        return $ambito;
    }

}
?>
