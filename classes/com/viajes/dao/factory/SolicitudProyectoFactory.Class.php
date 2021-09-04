<?php

/**
 * Factory para Solicitud Proyecto
 *  
 * @author Marcos
 * @since 20-11-2013
 */
class SolicitudProyectoFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('SolicitudProyecto');
        $solicitudProyecto = parent::build($next);

        $factory = new SolicitudFactory();
        $factory->setAlias( CYT_TABLE_SOLICITUD . "_" );
        $solicitudProyecto->setSolicitud( $factory->build($next) );
        
   		$factory = new ProyectoFactory();
        $factory->setAlias( CYT_TABLE_PROYECTO . "_" );
        $solicitudProyecto->setProyecto( $factory->build($next) );
        
        $factory = new DocenteFactory();
        $factory->setAlias("DOCDIR_" );
        $solicitudProyecto->setDirector( $factory->build($next) );
        
        $factory = new TipoEstadoProyectoFactory();
        $factory->setAlias( CYT_TABLE_TIPO_ESTADO_PROYECTO . "_" );
        $solicitudProyecto->setEstado( $factory->build($next) );
        
   		
        
        return $solicitudProyecto;
    }
}
?>
