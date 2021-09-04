<?php

/**
 * Acción para listar estados.
 *
 * @author Marcos
 * @since 19-03-2014
 *
 */
class ListCambiosEstadoAction extends CMPEntityGridAction{


	protected function getComponent() {
		return new CMPCambioEstadoGrid();
	}



}
