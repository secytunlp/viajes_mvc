<?php


/**
 * Caracter 
 *  
 * @author Marcos
 * @since 27-12-2013
 */

class Caracter {
    
      
    private static $items = array(  
    								   CYT_CD_NACIONAL=> CYT_DS_NACIONAL,
    								   CYT_CD_INTERNACIONAL=> CYT_DS_INTERNACIONAL,
    								   );
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}
					   
}
?>
