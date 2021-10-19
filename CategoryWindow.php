<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial;
  font-size: 17px;
}

.row .coulmn .container {
  display:inline-block;
  position: relative;
  max-width: 800px;
  margin: 15px auto;
}

.container input {vertical-align: middle;}

.row .coulmn .container .content {
  position: absolute;
  bottom: 0;
  background: rgb(0, 0, 0); /* Fallback color */
  background: rgba(0, 0, 0, 0.5); /* Black background with 0.5 opacity */
  color: #f1f1f1;
  width: 100%;
  padding: 20px;
}

.row {
  display: -ms-flexbox; /* IE 10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE 10 */
  flex-wrap: wrap;
  padding: 15px 4px;
}

/* Create two equal columns that sits next to each other */
.row .column {
  -ms-flex: 50%; /* IE 10 */
  flex: 50%;
  padding: 0 4px;

}

.column input {
  margin-top: 8px;
  vertical-align: middle;
}

</style>
<?php

require 'CategoryController.php';

$CategoryController = new CategoryController();

if(!empty($_GET["action"])) {
	switch($_GET["action"]) {
	case "view": 
		$CategoryName = $_GET["code"];
		$productContoller = new productContoller();
		$productContoller->GetProductsInCategory($CategoryName);	
		break;
	}
}

$categoryTable = $CategoryController->CreateCategoryTables();
$title = "Category";
$content = $categoryTable;
$active_page='categories';
include 'mainWindow.php';
?>
</body>
</html>