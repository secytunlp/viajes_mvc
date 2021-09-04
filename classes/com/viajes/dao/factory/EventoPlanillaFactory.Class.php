<?php

/**
 * Factory para EventoPlanilla
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class EventoPlanillaFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('EventoPlanilla');
        $eventoplanilla = parent::build($next);
        if(array_key_exists('cd_eventoplanilla',$next)){
        	$eventoplanilla->setOid( $next["cd_eventoplanilla"] );
        }

        return $eventoplanilla;
    }

}
?>
