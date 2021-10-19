<?php

class EntityUser
{
	public $UserID;
	public $FirstName;
	public $LastName;
	public $Email;
	public $PhonNumber;
	public $City;
	public $ZipCode;
	public $Street;
	public $HouseNumber;
	public $DepartmentNumber;
	public $HashedPassword;
	public $CreatedDate;
	public $Birthday;
	public $GroupID;
   

    
    function __construct($UserID ,$FirstName ,$LastName ,$Email ,$PhonNumber ,$City ,$ZipCode ,$Street,$HouseNumber,$DepartmentNumber,$HashedPassword, $CreatedDate,$Birthday,$GroupID){
       
		$this->UserID = $UserID ;
		$this->FirstName = $FirstName ;
		$this->LastName  = $LastName ;
		$this->Email  = $Email ;
		$this->PhonNumber = $PhonNumber ;
		$this->City  = $City ;
		$this->ZipCode = $ZipCode ;
		$this->Street= $Street;
		$this->HouseNumber= $HouseNumber;
		$this->DepartmentNumber= $DepartmentNumber;
		$this->HashedPassword= $HashedPassword;
		$this->CreatedDate= $CreatedDate;
		$this->Birthday= $Birthday;
		$this->GroupID= $GroupID;

    }

}

?>