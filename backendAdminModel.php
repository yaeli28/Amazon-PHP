<?php

require ("Connection.php");
require ("EntitySubCategory.php");
require ("EntitySupplier.php");
require ("EntityShop.php");
//Contains database related code for backendAdmin page.
class backendAdminModel{
	//Get all subCategories from the database and return them in an array.
	function subCategoryID()
	{
		require 'connection.php';
        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
        $query = "SELECT * FROM t_subCategory";
        $result = $conn->query($query);
		$subCategoriesArray = array();

        //Get data from database.
		while ($row = $result->fetch_assoc()) {
			$SubCategoryID = $row["subCategoryID"];
            $SubCategoryName = $row["subCategoryName"];
            $CategoryID = $row["CategoryID"];

            //Create temp objects and store them in an array.
            $temp = new EntitySubCategory($SubCategoryID, $SubCategoryName, $CategoryID);
            array_push($subCategoriesArray, $temp);
        }
        //Close connection and return result
		$conn->close();
        return $subCategoriesArray;	
	}
	
	//Get all suppliers from the database and return them in an array.
	function supplierID()
	{
		require 'connection.php';
        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
        $query = "SELECT * FROM t_suppliers";
        $result = $conn->query($query);
		$suppliersArray = array();

        //Get data from database.
		while ($row = $result->fetch_assoc()) {
			$SupplierID = $row["SuppliersID"];
            $SupplierName = $row["SuppliersName"];

            //Create temp objects and store them in an array.
            $temp = new EntitySupplier($SupplierID, $SupplierName);
            array_push($suppliersArray, $temp);
        }
        //Close connection and return result
		$conn->close();
        return $suppliersArray;	
	}
	//Get all shops from the database and return them in an array.
	function shopID()
	{
		require 'connection.php';
        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
        $query = "SELECT * FROM t_shops";
        $result = $conn->query($query);
		$shopsArray = array();

        //Get data from database.
		while ($row = $result->fetch_assoc()) {
			$ShopID = $row["ShopID"];
            $ShopName = $row["ShopName"];

            //Create temp objects and store them in an array.
            $temp = new EntityShop($ShopID, $ShopName);
            array_push($shopsArray, $temp);
        }
        //Close connection and return result
		$conn->close();
        return $shopsArray;	
	}
}
?>