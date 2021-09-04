<?php

/**
 * Factory para PresupuestoCambio
 *  
 * @author Marcos
 * @since 09-06-2015
 */
class PresupuestoCambioFactory extends CdtGenericFactory {

    public function build($next) {

        $this->setClassName('PresupuestoCambio');
        $presupuesto = parent::build($next);
        $presupuesto->setNu_montopresupuesto($next['nu_monto']);
        $presupuestoArray = explode('|', $presupuesto->getDs_presupuesto());
        $presupuesto->setDs_presupuesto($presupuestoArray[0]);
    	switch ($presupuesto->getDs_presupuesto()) {
				case CYT_CD_VIATICO:
				$presupuesto->setDs_dias($presupuestoArray[1]);
				$presupuesto->setDs_lugar($presupuestoArray[2]);
				break;
				
				case CYT_DS_PASAJE:
				
				$presupuesto->setDs_pasajes($presupuestoArray[1]);
				$presupuesto->setDs_destino($presupuestoArray[2]);
				break;
				
				case CYT_CD_INSCRIPCION:
				$presupuesto->setDs_inscripcion($presupuestoArray[1]);
				break;
			}
                
        $factory = new CambioFactory();
        $factory->setAlias( CYT_TABLE_CAMBIO. "_" );
        $presupuesto->setCambio( $factory->build($next) );
        
        

        return $presupuesto;
    }

}
?>
