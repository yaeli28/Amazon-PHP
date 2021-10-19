<?php

class EntityShop
{
	public $ShopID;
	public $ShopName;
	
    
    function __construct($ShopID ,$ShopName ){
       
		$this->ShopID = $ShopID ;
		$this->ShopName = $ShopName ;
		
    }

}
?>