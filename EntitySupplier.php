<?php

class EntitySupplier
{
	public $SuppliersID;
	public $SuppliersName;
	
    
    function __construct($SuppliersID ,$SuppliersName ){
       
		$this->SuppliersID = $SuppliersID ;
		$this->SuppliersName = $SuppliersName ;
		
    }

}
?>