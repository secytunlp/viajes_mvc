<?php

/**
 * Acción para listar cambios.
 *
 * @author Marcos
 * @since 08-06-2015
 *
 */
class ListCambiosAction extends CMPEntityGridAction{


	protected function getComponent() {
		return new CMPCambioGrid();
	}



}
