<?php

/**
 * Factory para PuntajeItem
 *  
 * @author Marcos
 * @since 06-12-2013
 */
class PuntajeItemFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('PuntajeItem');
        $puntajeitem = parent::build($next);
        if(array_key_exists('cd_puntajeitem',$next)){
        	$puntajeitem->setOid( $next["cd_puntajeitem"] );
        }
        
        $factory = new ItemMaximoFactory();
        $factory->setAlias( CYT_TABLE_ITEM_MAXIMO . "_" );
        $puntajeitem->setItemMaximo( $factory->build($next) );

        return $puntajeitem;
    }

}
?>
