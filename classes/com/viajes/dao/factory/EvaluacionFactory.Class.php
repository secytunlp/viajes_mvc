<?php

/**
 * Factory para Evaluacion
 *  
 * @author Marcos
 * @since 18-11-2013
 */
class EvaluacionFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('Evaluacion');
        $evaluacion = parent::build($next);
    	if(array_key_exists('cd_evaluacion',$next)){
        	$evaluacion->setOid( $next["cd_evaluacion"] );
        }
        
    	$factory = new EstadoFactory();
        $factory->setAlias( CYT_TABLE_ESTADO_EVALUACION. "_" );
        $evaluacion->setEstado( $factory->build($next) );
        
        $factory = new SolicitudFactory();
        $factory->setAlias( CYT_TABLE_SOLICITUD. "_" );
        $evaluacion->setSolicitud( $factory->build($next) );
        
        $factory = new PeriodoFactory();
        $factory->setAlias( CYT_TABLE_PERIODO . "_" );
        $evaluacion->setPeriodo( $factory->build($next) );
        
        $factory = new DocenteFactory();
        $factory->setAlias( CYT_TABLE_DOCENTE . "_" );
        $evaluacion->setDocente( $factory->build($next) );
        
    	$factory = new UserFactory();
        $factory->setAlias( CYT_TABLE_CDT_USER. "_" );
        $evaluacion->setUser( $factory->build($next) );
        

        return $evaluacion;
    }

}
?>
