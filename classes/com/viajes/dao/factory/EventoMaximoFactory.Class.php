<?php

/**
 * Factory para EventoMaximo
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class EventoMaximoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('EventoMaximo');
        $eventomaximo = parent::build($next);
        if(array_key_exists('cd_eventomaximo',$next)){
        	$eventomaximo->setOid( $next["cd_eventomaximo"] );
        }
        
        $factory = new EventoPlanillaFactory();
        $factory->setAlias( CYT_TABLE_EVENTO_PLANILLA. "_" );
        $eventomaximo->setEventoPlanilla( $factory->build($next) );
        
        $factory = new PuntajeGrupoFactory();
        $factory->setAlias( CYT_TABLE_PUNTAJE_GRUPO. "_" );
        $eventomaximo->setPuntajeGrupo( $factory->build($next) );

        return $eventomaximo;
    }

}
?>
