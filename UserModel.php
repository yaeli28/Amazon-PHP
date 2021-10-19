<?php

require_once ("EntityUser.php");
require_once ("connection.php");

//Contains database related code for the User page.
class UserModel {
	
    //Get all AdminUsers types from the database and return them in an array.
	function GetAdminUser(){
		require 'Connection.php';
		//Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}	

        $query = "SELECT * FROM users where users.GroupID='2' and users.userID!='1' ";
        $result = $conn->query($query);
        $userArray = array();

        //Get data from database.
		while ($row = $result->fetch_assoc()) {
			$UserID = $row["UserID"];
            $FirstName = $row["FirstName"];
            $LastName = $row["LastName"];
            $Email = $row["Email"];
            $PhonNumber = $row["PhonNumber"];
			$City = $row["City"];  
			$ZipCode = $row["ZipCode"];
		    $Street = $row["Street"];
		    $HouseNumber = $row["HouseNumber"];
			$DepartmentNumber = $row["DepartmentNumber"];
			$HashedPassword = $row["HashedPassword"];
			$CreatedDate = $row["CreatedDate"];
			$Birthday = $row["Birthday"];
			$GroupID=$row["GroupID"];

            //Create User objects and store them in an array.
            $user = new EntityUser($UserID, $FirstName, $LastName, $Email, $PhonNumber,$City,$ZipCode,$Street,$HouseNumber,$DepartmentNumber,$HashedPassword,$CreatedDate,$Birthday,$GroupID);
            array_push($userArray, $user);
        }
        //Close connection and return result.
        $conn->close();
		
        return $userArray;
	}
	
	//Get all users from database
	function GetAllUsers() {
		
        require 'connection.php';

        //Open connection and Select database.     
        $conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}	

        $query = "SELECT * FROM users";
        $result = $conn->query($query);
		$userArray = array();

        //Get data from database.
		while ($row = $result->fetch_assoc()) {
		$UserID = $row["UserID"];
            $FirstName = $row["FirstName"];
            $LastName = $row["LastName"];
            $Email = $row["Email"];
            $PhonNumber = $row["PhonNumber"];
			$City = $row["City"];  
			$ZipCode = $row["ZipCode"];
		    $Street = $row["Street"];
		    $HouseNumber = $row["HouseNumber"];
			$DepartmentNumber = $row["DepartmentNumber"];
			$HashedPassword = $row["HashedPassword"];
			$CreatedDate = $row["CreatedDate"];
			$Birthday = $row["Birthday"];
			$GroupID=$row["GroupID"];

            //Create User objects and store them in an array.
            $user = new EntityUser($UserID, $FirstName, $LastName, $Email, $PhonNumber,$City,$ZipCode,$Street,$HouseNumber,$DepartmentNumber,$HashedPassword,$CreatedDate,$Birthday,$GroupID);
            array_push($userArray, $user);
        }
        //Close connection and return result
		$conn->close();
        return $userArray;
    }
	
	//Add user to database
	function addUser($FirstName, $LastName, $Email, $PhonNumber,$City,$Country,$Street,$HouseNumber,$DepartmentNumber,$ZipCode,$HashedPassword,$Birthday)
	{
	require 'connection.php';
		
		require 'connection.php';
		//Open connection and Select database.     
		$conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		
		//Check if email is exist
		$query = "SELECT exists(select * FROM users where users.Email='$Email')as uex";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$exists=$row["uex"];

		}
		//if user not exist- insert him to database
		if($exists==0){
			$CreatedDate=date("Y-m-d H:i:s");
			$GroupID='1';
			
			$stmt = $conn->prepare("call insertUser(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$stmt->bind_param("ssssssssssssss", $FirstName, $LastName, $Email, $PhonNumber,$City,$Country,$Street,$HouseNumber,$DepartmentNumber,$ZipCode,$HashedPassword,$CreatedDate,$Birthday,$GroupID);
			$result=$stmt->execute();
			$result='1';
		}
		else{
			$result='0';//the user exist
			}

		$conn->close();
		return $result;
	}
	
	//log in user
	function LogIn($email,$pass)
	{
	require 'connection.php';
		
		//Open connection and Select database.     
		$conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		$userModel=new UserModel();
		$stmt = $conn->prepare("call CheckLogIn(?)");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result=$stmt->get_result();
		while ($row = $result->fetch_assoc())
		{
			$user_exist=$row["user_exist"];
		}
		if($user_exist==1)//The user exists
		{
			$validPass=$userModel->checkPassword($email, $pass);
			if($validPass==0)
				$result= 0;//The password invalid
			else
			{
				$result =1;//The password valid
				
				//write to userlog
				
				$event='2';
				$UserModel=new UserModel();
				$user_id=$UserModel->user_id($email);
				$e_data=date("Y-m-d H:i:s"); 
				$UserModel->write_log($event,$user_id,$e_data);
			}
		}
		else{
			$result= -1;//The user not exists
		}	
		$conn->close();
		return $result;
	}
	
	function write_log($event,$user_id,$e_data){
		require 'connection.php';
			
		//Open connection and Select database.     
		$conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		$stmt = $conn->prepare("INSERT INTO t_userlog (EventID, UserID, EventDate)
		VALUES (?,?,?)");
		$stmt->bind_param("sss",$event,$user_id,$e_data);
		$stmt->execute();

		$conn->close();
	}
	
	//return user id by email
	function user_id($email)
	{
	  require 'connection.php';
		//Open connection and Select database.     
		$conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		$stmt = $conn->prepare("select UserID from users where Email=?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result=$stmt->get_result();
		while ($row = $result->fetch_assoc())
		{
			$id=$row["UserID"];
		}

		$conn->close();
		return $id;
	}
	
	//return if is valid password
	function checkPassword($Email,$HashedPassword)
	{
	require 'connection.php';
		//Open connection and Select database.     
		$conn = new mysqli($servername, $username, $password, $dbname);
		//check connection
		if($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		$stmt = $conn->prepare("call checkPassword(?,?)");
		$stmt->bind_param("ss", $Email,$HashedPassword);
		$stmt->execute();
		$result=$stmt->get_result();
		while ($row = $result->fetch_assoc())
		{
			$validPass=$row["validpass"];

		}
		return $validPass;
	}
    
}

?>
