<?php

/**
 * Factory para PuntajePlan
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PuntajePlanFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('PuntajePlan');
        $puntajeplan = parent::build($next);
        if(array_key_exists('cd_puntajeplan',$next)){
        	$puntajeplan->setOid( $next["cd_puntajeplan"] );
        }

        return $puntajeplan;
    }

}
?>
