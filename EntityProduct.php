<?php

class EntityProduct
{
	public $ProductID;
    public $ProductName;
	public $ProductDescription;
	public $SubCategoryID;
    public $QuantityPerUnit;
    public $UnitPrice;
    public $ProductWeight;
    public $SupplierID;
    public $Active;
    public $Image;
	
   

    
    function __construct($ProductID, $ProductName, $ProductDescription, $SubCategoryID, $QuantityPerUnit, $UnitPrice, $ProductWeight, $SupplierID, $Active, $Image) {
     
		$this-> ProductID = $ProductID;
		$this-> ProductName=$ProductName;
		$this-> ProductDescription=$ProductDescription;
		$this-> SubCategoryID=$SubCategoryID;
		$this-> QuantityPerUnit= $QuantityPerUnit;
		$this-> UnitPrice= $UnitPrice;
		$this-> ProductWeight= $ProductWeight;
		$this-> SupplierID=$SupplierID;
		$this-> Active=$Active;
		$this-> Image=$Image;
		

    }
}

?>