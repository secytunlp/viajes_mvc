<?php

/**
 * GridModel para Cambio
 *
 * @author Marcos
 * @since 08-06-2015
 */
class CambioGridModel extends GridModel {

	public function __construct() {

		parent::__construct();
		$this->initModel();
	}

	protected function initModel() {

		
		
		$column = GridModelBuilder::buildColumn( "oid", CYT_LBL_ENTITY_OID, 20, CDT_CMP_GRID_TEXTALIGN_RIGHT );
		$this->addColumn( $column );
		
		
		$column = GridModelBuilder::buildColumn( "dt_fecha", CYT_LBL_SOLICITUD_FECHA, 30, CDT_CMP_GRID_TEXTALIGN_CENTER, null, new GridDateValueFormat(CYT_DATETIME_FORMAT) ); 
		$this->addColumn( $column );
		
		$tEstado = CYTSecureDAOFactory::getEstadoDAO()->getTableName();
        $column = GridModelBuilder::buildColumn( "estado.ds_estado", CYT_LBL_ESTADO, 40, CDT_CMP_GRID_TEXTALIGN_LEFT, "$tEstado.ds_estado" );
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "ds_observacion", CYT_LBL_EVALUACION_OBSERVACIONES, 20, CDT_CMP_GRID_TEXTALIGN_LEFT, "ds_observacion");
		$this->addColumn( $column );
		
		$column = GridModelBuilder::buildColumn( "oid", CYT_LBL_SOLICITUD_ARCHIVOS, 60, CDT_CMP_GRID_TEXTALIGN_RIGHT,"",new GridFilesCambioValueFormat() ) ;
		$this->addColumn( $column );
		//acciones sobre la lista
		$this->buildAction("add_cambio_init", "add_cambio_init", CYT_MSG_CAMBIO_TITLE_ADD, "image", "add");
		
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getTitle();
	 */
	function getTitle() {
		return CYT_MSG_CAMBIO_TITLE_LIST;
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getEntityManager();
	 */
	public function getEntityManager() {
		return ManagerFactory::getCambioManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see GridModel::getRowActionsModel( $item );
	 */
	public function getRowActionsModel($item) {
		//return $this->getDefaultRowActions($item, "evaluacion", CYT_LBL_EVALUACION, true, true, true, false, 500, 750);
		$actions = new ItemCollection();
	
		
		$action =  $this->buildDeleteAction( $item, "cambio", CYT_LBL_CAMBIO, $this->getMsgConfirmDelete( $item ), false ) ;
		$actions->addItem( $action );
		
		$action = $this->buildRowAction( "view_cambio_pdf", "view_cambio_pdf", CDT_UI_LBL_EXPORT_PDF, CDT_UI_IMG_SEARCH, "view") ;
		$action->setBl_targetblank(true);
		$actions->addItem( $action );
		/*$action = $this->buildRowAction( "update_cambio_init", "update_cambio_init", CDT_CMP_GRID_MSG_EDIT . " ".CYT_LBL_CAMBIO, CDT_UI_IMG_EDIT, "edit") ;
		$actions->addItem( $action );*/
		
		$oUser = CdtSecureUtils::getUserLogged();
		
		if (CdtSecureUtils::hasPermission ( $oUser, CYT_FUNCTION_ENVIAR_SOLICITUD )) {
			$action =  $this->buildRowAction( "send_cambio", "send_cambio", CYT_LBL_ENVIAR, CDT_UI_IMG_SEARCH, "view", "delete_items('send_cambio')", false, $this->getMsgConfirmSend(CYT_MSG_CAMBIO_ENVIAR_PREGUNTA)) ;
			$actions->addItem( $action );
		}
		
		
		if (CdtSecureUtils::hasPermission ( $oUser, CYT_FUNCTION_LISTAR_ESTADO )) {
			
			$action = $this->buildRowAction("list_cambiosEstado", "list_cambiosEstado", CYT_MSG_SOLICITUD_ESTADO_TITLE_LIST, CDT_CMP_GRID_MSG_VIEWCDT_UI_IMG_SEARCH, "attach" ) ;
			$actions->addItem( $action );
			
		}
		
		
		return $actions;
	}


	protected function getMsgConfirmSend( $msg ){
		
		return CdtFormatUtils::quitarEnters($msg);
	}
}
?>