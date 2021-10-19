<?php

require ("Connection.php");
require ("EntityCategory.php");
//Contains database related code for the Category page.
class CategoryModel{
	//Get all Categories types from the database and return them in an array.
	function GetAllCategories() {
		
        require 'Connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		
        $query = "SELECT * FROM t_category";
        $result = $conn->query($query);
		$CategoriesArray = array();

        //Get data from database.
		while ($row = $result->fetch_assoc()) {
			$CategoryID = $row["CategoryID"];
            $CategoryName = $row["CategoryName"];
            $Description = $row["Description"];
            $Image = $row["Image"];

            //Create Category objects and store them in an array.
            $Category = new EntityCategory($CategoryID, $CategoryName, $Description, $Image);
            array_push($CategoriesArray, $Category);
        }
        //Close connection and return result
		$conn->close();
        return $CategoriesArray;
    }

	
}

?>