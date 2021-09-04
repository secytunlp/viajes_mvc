<?php

/**
 * Factory para ItemMaximo
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class ItemMaximoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('ItemMaximo');
        $itemmaximo = parent::build($next);
        if(array_key_exists('cd_itemmaximo',$next)){
        	$itemmaximo->setOid( $next["cd_itemmaximo"] );
        }
        
        $factory = new ItemPlanillaFactory();
        $factory->setAlias( CYT_TABLE_ITEM_PLANILLA. "_" );
        $itemmaximo->setItemPlanilla( $factory->build($next) );
        
        $factory = new PuntajeGrupoFactory();
        $factory->setAlias( CYT_TABLE_PUNTAJE_GRUPO. "_" );
        $itemmaximo->setPuntajeGrupo( $factory->build($next) );

        return $itemmaximo;
    }

}
?>
