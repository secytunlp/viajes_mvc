<?php

/**
 * Acción para listar rendiciones.
 *
 * @author Marcos
 * @since 28-09-2021
 *
 */
class ListRendicionesAction extends CMPEntityGridAction{


	protected function getComponent() {
		return new CMPRendicionGrid();
	}



}
