<?php

/**
 * Factory para Motivo
 *  
 * @author Marcos
 * @since 13-11-2013
 */
class MotivoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('Motivo');
        $motivo = parent::build($next);
        if(array_key_exists('cd_motivo',$next)){
        	$motivo->setOid( $next["cd_motivo"] );
        }

        return $motivo;
    }

}
?>
