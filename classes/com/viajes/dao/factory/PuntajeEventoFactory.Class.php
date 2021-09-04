<?php

/**
 * Factory para PuntajeEvento
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class PuntajeEventoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('PuntajeEvento');
        $puntajeevento = parent::build($next);
        if(array_key_exists('cd_puntajeevento',$next)){
        	$puntajeevento->setOid( $next["cd_puntajeevento"] );
        }
        
        $factory = new EventoMaximoFactory();
        $factory->setAlias( CYT_TABLE_EVENTO_MAXIMO . "_" );
        $puntajeevento->setEventoMaximo( $factory->build($next) );

        return $puntajeevento;
    }

}
?>
