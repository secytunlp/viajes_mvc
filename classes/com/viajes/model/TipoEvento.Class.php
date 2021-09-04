<?php


/**
 * TipoEvento 
 *  
 * @author Marcos
 * @since 27-12-2013
 */

class TipoEvento {
    
      
    private static $items = array(  
    								   CYT_CD_CONGRESO=> CYT_DS_CONGRESO,
    								   //CYT_CD_CONFERENCIA=> CYT_DS_CONFERENCIA,
    								   );
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}
					   
}
?>
