<?php

class EntitySubCategory
{
	public $subCategoryID;
    public $subCategoryName;
	public $Category;
    
    function __construct($subCategoryID, $subCategoryName, $Category) {
       
		$this->subCategoryID = $subCategoryID;
 	    $this->subCategoryName = $subCategoryName;
		$this->Category = $Category;	
    }

}
?>