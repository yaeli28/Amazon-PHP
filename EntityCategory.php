<?php

class EntityCategory
{
	public $CategoryID;
	public $CategoryName;
	public $Description;
	public $Image;

    
    function __construct($CategoryID ,$CategoryName ,$Description ,$Image ){
       
		$this->CategoryID = $CategoryID ;
		$this->CategoryName = $CategoryName ;
		$this->Description  = $Description ;
		$this->Image  = $Image ;
    }

}
?>