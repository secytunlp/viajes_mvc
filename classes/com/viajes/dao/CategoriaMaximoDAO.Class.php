<?php

/**
 * DAO para CategoriaMaximo
 *  
 * @author Marcos
 * @since 05-12-2013
 */
class CategoriaMaximoDAO extends EntityDAO {

	public function getTableName(){
		return CYT_TABLE_CATEGORIA_MAXIMO;
	}
	
	public function getEntityFactory(){
		return new CategoriaMaximoFactory();
	}
	
	public function getFieldsToAdd($entity){
		
		
	}
	
	
	
	public function getIdFieldName(){
		return "cd_categoriamaximo";
	}
	
	public function getFromToSelect(){
		$tCategoriaMaximo = $this->getTableName();
		$tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
		
		$sql  = parent::getFromToSelect();
		
		$sql .= " LEFT JOIN " . $tCategoria . " ON($tCategoriaMaximo.cd_categoria = $tCategoria.cd_categoria)";
		
		 return $sql;
	}
	
	public function getFieldsToSelect(){
		
		$fields = parent::getFieldsToSelect();
		
		$tCategoria = CYTSecureDAOFactory::getCategoriaDAO()->getTableName();
        $fields[] = "$tCategoria.cd_categoria as " . $tCategoria . "_oid ";
        $fields[] = "$tCategoria.ds_categoria as " . $tCategoria . "_ds_categoria ";
        
         return $fields;
	}
	

	
	
}
?>