<?php

/**
 * Factory para ItemPlanilla
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class ItemPlanillaFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('ItemPlanilla');
        $itemplanilla = parent::build($next);
        if(array_key_exists('cd_itemplanilla',$next)){
        	$itemplanilla->setOid( $next["cd_itemplanilla"] );
        }

        return $itemplanilla;
    }

}
?>
