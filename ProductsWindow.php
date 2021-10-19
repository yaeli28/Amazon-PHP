<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

</style>
</head>
<body>
<?php

require_once 'ProductController.php';

$productController = new ProductController();
if(!empty($_GET["action"])) {
	switch($_GET["action"]) {
		case "view": 
		$CategoryName = $_GET["code"];
		$title = "Products";
		$content = $productController->GetProductsCategory($CategoryName);	
		$sidenav=$productController->get_subcategories($CategoryName);
		break;
		case "all": 
		$productTables = $productController->CreateProductTables();
		$title = "Products";
		$content = $productTables;
		break;
		case "find":
		$ProductName=$_GET["PN"];
		$title = "Products";
		$content = $productController->GetProductByName($ProductName);	
		break;
		case "filter":
		$scn=$_GET["scn"];
		$title = "Products";
		$content = $productController->GetProductBysubcat($subCategoryID);	
		break;
		case "add":
		$title = "Products";
		$content = $productController->add_product();	
		break;
		case "update":
		$pid=$_GET["pid"];
		$ProductName=$_GET["pname"];
		$productDescription=$_GET["pdesc"];
		$subCategoryID=$_GET["scid"];
		$quantityPerUnit=$_GET["qpu"];
		$unitPrice=$_GET["up"];
		$productWeight=$_GET["pw"];
		$supplierID=$_GET["sid"];
		$shopID=$_GET["shop"];
		$active=$_GET["active"];
		$title = "Products";
		$content = $productController->update_product($pid,$ProductName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$shopID,$active);	
		break;
		case "delete":
		$ProductID=$_GET["pid"];
		echo '<script>alert("Are you sure you want to delete the product?")</script>';
		$content = $productController->DeleteP($ProductID);	
		$content.=$productController->CreateProductTablesAdmin();
		break;
		case "deletes":
		$ShopID=$_GET["shopID"];
		echo '<script>alert("Are you sure you want to delete the shop?")</script>';
		$content = $productController->DeleteS($ShopID);	
		$content.=$productController->CreateProductTablesAdmin();
		break;
		case "addshop": 
		$content = $productController->add_shop();
		$title = "Products";
		break;
		case "deleteshop": 
		$content = $productController->delete_shop();
		$title = "Products";
		break;
	}
}

if(!empty($_GET["search"])){
		$ProductName=$_GET["search"];
		$title = "Products";
		$content = $productController->GetProductByName($ProductName);	
}
if(!empty($_GET["add"])){
	switch($_GET["add"]) {
	case "add":
		$ProductName=$_GET["productName"];
		$productDescription=$_GET["productDescription"];
		$subCategoryID=$_GET["subCategoryID"];
		$quantityPerUnit=$_GET["quantityPerUnit"];
		$unitPrice=$_GET["unitPrice"];
		$productWeight=$_GET["productWeight"];
		$supplierID=$_GET["supplierID"];
		$shopID=$_GET["shopID"];
		if(!empty($_GET["active"]))
			$active=1;
		else
			$active=0;
		$title = "Products";
		$content=$productController->Insert($ProductName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$shopID,$active);	
		$content.=$productController->CreateProductTablesAdmin();
		break;
	case "addshop":
		$shopName=$_GET["shopName"];
		$title = "Products";
		$content=$productController->Insert_shop($shopName);	
		$content.=$productController->CreateProductTablesAdmin();
		break;
	}
}

if(!empty($_GET["update"])){
		$productID=$_GET["update"];
		$productName=$_GET["productName"];
		$productDescription=$_GET["productDescription"];
		$subCategoryID=$_GET["subCategoryID"];
		$quantityPerUnit=$_GET["quantityPerUnit"];
		$unitPrice=$_GET["unitPrice"];
		$productWeight=$_GET["productWeight"];
		$supplierID=$_GET["supplierID"];
		if(!empty($_GET["active"]))
			$active=1;
		else
			$active=0;
		$content=$productController->update($productID,$productName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$active);	
		$content.=$productController->CreateProductTablesAdmin();
}

$active_page="categories";
include 'mainWindow.php';
//include 'menu.php';
?>

</body>
</html>