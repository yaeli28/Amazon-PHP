<?php

require ("UserModel.php");
require_once ("mainWindow.php");


//Contains non-database related function for the Product page
class UserController {
	//enter user if exist and the email and password are correct
	function enterUser($email,$psw)
	{
		$user = new userModel();
		$exist=$user->LogIn($email,$psw);
		$content="";
		if($exist==1)//correct
		{
			require 'ProductController.php';
			echo "<script> document.getElementById('id01').style.display='none'</script>";
			echo "<script> document.getElementById('admin_backend').style.display='none'</script>";
			
			$productController = new ProductController();
			$content=$productController->CreateProductTables();
		}
		else if($exist==0)//exist but wor password
		{	
			echo '<script>alert("wrong password")</script>';
		}
		else if ($exist==-1)//user doesn't exist- open signUp window
		{
			echo "<script> document.getElementById('id01').style.display='none'</script>";
			echo "<script> document.getElementById('id02').style.display='block'</script>";
		echo '<script>alert("User not exist")</script>';
		}
		return $content;
	}
	//sign up user
	function signUp($first_name,$last_name,$email,$phone_number,$city,$country,$street,$house_number,$department_number,$zip_code,$psw,$birthday)
	{
		
		$user = new userModel();
		$success=$user->AddUser($first_name,$last_name,$email,$phone_number,$city,$country,$street,$house_number,$department_number,$zip_code,$psw,$birthday);
		if($success==0)
			echo '<script>alert("The user already exist")</script>';
		$content="";
		
	}
	//check the password are correct to admin password
	function checkPassword($email,$apsw)
	{
		$user = new userModel();
		$pasw=$user->checkPassword($email,$apsw);
		
		require_once 'ProductController.php';
		$productController= new ProductController();
		echo "<script> document.getElementById('id01').style.display='none'</script>";
		$content="";
		if($pasw==0){
			echo '<script>alert("Wrong password.Are you sure you are admin?")</script>';
			$content= $productController->CreateProductTables();
		}
		else
		{
			$content=$productController->CreateProductTablesAdmin();
		}
		return $content;
	} 
}


