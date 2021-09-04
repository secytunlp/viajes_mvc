<?php

/**
 * Factory para PuntajeCategoria
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class PuntajeCategoriaFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('PuntajeCategoria');
        $puntajecategoria = parent::build($next);
        if(array_key_exists('cd_puntajecategoria',$next)){
        	$puntajecategoria->setOid( $next["cd_puntajecategoria"] );
        }
        
        $factory = new CategoriaMaximoFactory();
        $factory->setAlias( CYT_TABLE_CATEGORIA_MAXIMO . "_" );
        $puntajecategoria->setCategoriaMaximo( $factory->build($next) );

        return $puntajecategoria;
    }

}
?>
