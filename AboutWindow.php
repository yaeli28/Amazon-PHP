<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
}

.about-section {
  padding: 50px;
  text-align: center;
  background-color: #474e5d;
  color: white;
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}

@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}
</style>
</head>
<body>
<?php
require ('UserModel.php');
$UserModel=new UserModel();
$AdminUserArray=$UserModel->GetAdminUser();//GetAdminUser();
$title = "Products";
$content="
<div class='about-section'>
  <h1>About Us - Amazon</h1>
  <p>We are a special team workers</p>
  <p>enjoy using our site. it's intuitive web that made with hard work</p>
</div>";
//show the admin users from database
foreach ($AdminUserArray as $key => $Admin) {
	 $content=$content. 
	 "<div class='column'>
		<div class='card'>
		  <img src='Images\user.jpg' alt=$Admin->FirstName style='width:50%'>
		  <div class='container'>
			<h2>$Admin->FirstName $Admin->LastName</h2>
			<p class='title'>Art Director</p>
			<p>Some text that describes me lorem ipsum ipsum lorem.</p>
			<p>$Admin->Email</p>
			<p><button name=$Admin->Email class='button'>content</button></p>
		  </div>
		</div>
	</div>";
}

$active_page="about";
include 'mainWindow.php';
?>
</body>
</html>
