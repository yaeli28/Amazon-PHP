<?php

class EntitySubCategory
{
	public $SubCategoryID;
    public $SubCategoryName;
	public $Category;
    
   

    
    function __construct($subCategoryID, $subCategoryName, $Category) {
       
		$this->SubCategoryID = $subCategoryID;
 	    $this->SubCategoryName = $subCategoryName;
		$this->Category = $Category;	
    }
}
?>