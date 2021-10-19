<?php

require ("Connection.php");
require_once ("EntityProduct.php");
//Contains database related code for the Product page.
class ProductModel {
	//Get all Products types from the database and return them in an array.
	function GetProductsInCategory($CategoryName){
		require 'Connection.php';
		// Create connection
		//Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		// prepare and bind
		$stmt = $conn->prepare("call GetProductsInCategory(?)");
		$stmt->bind_param("s",$CategoryName);
		$stmt->execute();
		$result = $stmt->get_result();
        $productsArray = array();
        //Get data from database.
		while ($row = $result->fetch_assoc()) {
			$ProductID = $row["ProductID"];
            $ProductName = $row["ProductName"];
            $ProductDescription = $row["ProductDescription"];
            $SubCategoryID = $row["SubCategoryID"];
            $QuantityPerUnit = $row["QuantityPerUnit"];
            $UnitPrice = $row["UnitPrice"];
            $ProductWeight = $row["ProductWeight"];
            $SupplierID = $row["SupplierID"];
            $Active = $row["Active"];
            $Image = $row["Image"];
           //Create Product objects and store them in an array.
           $product = new EntityProduct($ProductID, $ProductName, $ProductDescription, $SubCategoryID, $QuantityPerUnit, $UnitPrice, $ProductWeight, $SupplierID, $Active, $Image);
           array_push($productsArray, $product);
        }
        //Close connection and return result
		mysqli_close($conn);
        return $productsArray;

	}
	//return products by name from database 
	function GetProductByName($ProductName){
		require 'Connection.php';
		
		// Create connection
		//Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		// prepare and bind
		$stmt = $conn->prepare("call GetProductByName(?)");
		$stmt->bind_param("s",$ProductName);
		$stmt->execute();
		$result = $stmt->get_result();	
		  
        $productsArray = array();

        //Get data from database.
		while ($row = $result->fetch_assoc()) {
			$ProductID = $row["ProductID"];
            $ProductName = $row["ProductName"];
            $ProductDescription = $row["ProductDescription"];
            $SubCategoryID = $row["SubCategoryID"];
            $QuantityPerUnit = $row["QuantityPerUnit"];
            $UnitPrice = $row["UnitPrice"];
            $ProductWeight = $row["ProductWeight"];
            $SupplierID = $row["SupplierID"];
            $Active = $row["Active"];
            $Image = $row["Image"];
           //Create Product objects and store them in an array.
           $product = new EntityProduct($ProductID, $ProductName, $ProductDescription, $SubCategoryID, $QuantityPerUnit, $UnitPrice, $ProductWeight, $SupplierID, $Active, $Image);
           array_push($productsArray, $product);
        }
        //Close connection and return result
		mysqli_close($conn);
        return $productsArray;

	}
	
	//Get all products types from the database and return them in an array.
	function GetAllProducts() {
		
        require 'Connection.php';
        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}	

        $query = "SELECT * FROM t_product";
        //$result = mysql_query($query) or die(mysql_error());
        $result = $conn->query($query);
		$productsArray = array();

        //Get data from database.
        //while ($row = mysql_fetch_array($result)) {
		while ($row = $result->fetch_assoc()) {
			$ProductID = $row["ProductID"];
            $ProductName = $row["ProductName"];
            $ProductDescription = $row["ProductDescription"];
            $SubCategoryID = $row["SubCategoryID"];
            $QuantityPerUnit = $row["QuantityPerUnit"];
            $UnitPrice = $row["UnitPrice"];
            $ProductWeight = $row["ProductWeight"];
            $SupplierID = $row["SupplierID"];
            $Active = $row["Active"];
            $Image = $row["Image"];			

            //Create Product objects and store them in an array.
            $product = new EntityProduct($ProductID, $ProductName, $ProductDescription, $SubCategoryID, $QuantityPerUnit, $UnitPrice, $ProductWeight, $SupplierID, $Active, $Image);
            array_push($productsArray, $product);
        }
        //Close connection and return result
		$conn->close();
        return $productsArray;
    }
	
	//connection to database and insert product
	function Insert($ProductName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$shopID,$active){
		 require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		$productModel=new ProductModel();		
		$ex=$productModel->IsExists($ProductName,$productDescription);
		if(!$ex)//if the product doesn't exist insert him to database
		{
			//search category of product
		$cn=$productModel->ItsCategory($subCategoryID);
		$Image='Images\Products\\'.$cn .'\\'.$ProductName.'.png';
		
		$stmt = $conn->prepare("INSERT INTO t_product
		( ProductName, ProductDescription, subCategoryID, QuantityPerUnit, UnitPrice, ProductWeight,SupplierID, active,Image)
		VALUES(?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param("sssssssss", $ProductName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$active,$Image);
        $result=$stmt->execute();
		$uis='80';
		$productID=$productModel->GetPID($ProductName,$productDescription);
		$productModel->addProductInShop($productID,$shopID,$uis);
		}
		else//The product is exist
		{
			//not insert
			$result=0;
		}
		
		$conn->close();
		return $result;
	}
	//return the product ID from database
	function GetPID($pname,$pdesc){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
	    //prepare and bind
		$stmt = $conn->prepare("SELECT ProductID FROM t_product WHERE ProductName=? and ProductDescription=?");
		$stmt->bind_param("ss", $pname,$pdesc);
		$stmt->execute();
		$result=$stmt->get_result();
		while ($row = $result->fetch_assoc()) {
		$pid = $row["ProductID"];}
	
		$conn->close();
		return $pid;
	}
	//insert to tabel productInShop the product and the shopID
	function addProductInShop($productID,$shopID,$unitInStock){
		require 'Connection.php';
        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
	    //prepare and bind
		$stmt = $conn->prepare("INSERT INTO t_productinshop (ProductID,ShopID,UnitInStock) VALUES(?,?,?)");
		$stmt->bind_param("sss", $productID,$shopID,$unitInStock);
		$result=$stmt->execute();
		
		$conn->close();
		return $result;
	}
	//return all subCategories from database
	function Getsubcategories($CategoryName){
		 require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
				
		// prepare and bind
		//get subCategories by category
		$stmt1 = $conn->prepare("call subCategoriesBycategory(?)");
		$stmt1->bind_param("s",$CategoryName);
		$stmt1->execute();
		$catName = $stmt1->get_result();
		$subCategories="";
		while ($row = $catName->fetch_assoc()) {
			
		$cn = $row["subCategoryName"];
		$subCategories=$subCategories."<a href='#'>$cn</a>";}
		$conn->close();
		return $subCategories;
	}
	
	//check if the product is already exist
	function IsExists($ProductName,$productDescription){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		$stmt = $conn->prepare("call IsExists(?, ?)");
		$stmt->bind_param("ss",$ProductName,$productDescription);
		$stmt->execute();
		$exists = $stmt->get_result();
		while ($row = $exists->fetch_assoc()) {
		$ex = $row["ex"];}
		
		$conn->close();
		return $ex;
	
	}
	
	//return category by subCategory
	function ItsCategory($subCategoryID){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
	    //prepare and bind
		//get category of subCategoryID
		$stmt = $conn->prepare("call ItsCategory(?)");
		$stmt->bind_param("s",$subCategoryID);
		$stmt->execute();
		$catName = $stmt->get_result();
		while ($row = $catName->fetch_assoc()) {
		$cn = $row["CategoryName"];}
		
		$conn->close();
		return $cn;
	}
	
	//delete product from database
	function DeleteP($productID){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
	    //prepare and bind
		$stmt = $conn->prepare("DELETE FROM t_product WHERE ProductID=?");
		$stmt->bind_param("s", $pid);
		$result=$stmt->execute();
		
		$conn->close();
		return $result;
	}
	
	//delete shop from database
	function DeleteS($sid){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
	    //prepare and bind
		$stmt = $conn->prepare("DELETE FROM t_shops WHERE ShopID=?");
		$stmt->bind_param("s", $sid);
		$result=$stmt->execute();
		
		$conn->close();
		return $result;
	}
	
	//update product in database
	function update($pid,$productName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$active){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		
		//concatenate the image by the subCategory check and the new name
		$productModel=new ProductModel();
		$cn=$productModel->ItsCategory($subCategoryID);
		$Image='Images\Products\\'.$cn .'\\'.$productName.'.png';
	    //prepare and bind
		$stmt = $conn->prepare("UPDATE t_product SET
		ProductName=?, ProductDescription=?, subCategoryID=?, QuantityPerUnit=?, UnitPrice=?, ProductWeight=?,SupplierID=?, active=?,Image=?
		WHERE ProductID=?");
		$stmt->bind_param("ssssssssss", $productName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$active,$Image,$pid);
		$result=$stmt->execute();
		
		$conn->close();
		return $result;
	}
	//insert shop to database if the shop name dosn't exist
	function InsertS($shopN){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		$productModel=new ProductModel();
		$ex=$productModel->IsShopExist($shopN);
		if($ex==0){
	    //prepare and bind
		$stmt = $conn->prepare("INSERT INTO t_shops (ShopName) VALUES(?)");
		$stmt->bind_param("s", $shopN);
		$result=$stmt->execute();
		$result=1;
		}
		else if ($ex==1){
			$result=0;
		}
		
		$conn->close();
		return $result;
	}
	//check if the shop exist
	function IsShopExist($shopN){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		
	    //prepare and bind
		$stmt1 = $conn->prepare("SELECT exists(SELECT * FROM t_shops WHERE ShopName=?) as ex");
		$stmt1->bind_param("s", $shopN);
		$stmt1->execute();
		$exists=$stmt1->get_result();
		while ($row = $exists->fetch_assoc()) {
		$ex = $row["ex"];}
		$conn->close();
		return $ex;
	}
	
	//return the shop of product by productID
	function shopOfProduct($pid){
		require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		
	    //prepare and bind
		$stmt1 = $conn->prepare("SELECT ShopID FROM t_productinshop WHERE ProductID=?");
		$stmt1->bind_param("s", $pid);
		$stmt1->execute();
		$exists=$stmt1->get_result();
		while ($row = $exists->fetch_assoc()) {
		$sid = $row["ShopID"];}
		$conn->close();
		return $sid;
	}
}

?>
