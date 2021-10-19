<?php

require_once ("ProductModel.php");
class ProductController{
	//Contains non-database related function for the Product page
	
    function CreateProductTables()
    {
        $productModel = new ProductModel();
		$productArray = $productModel->GetAllProducts();
        $result = "";
        //Generate a productTable for each productEntity in array
        foreach ($productArray as $key => $product) 
        {
			$result = $result .'
                    <div style="height: 2px; background-color: black;"></div>
					<table class = "productTable" style="padding-bottom: 10px; padding-top: 10px;">
                        <tr>
                            <th rowspan="8" width = "250px" ><img src = '. $product->Image .' style="height: 25%;"/></th>
                            <th width = "75px" >Name: </th>
							
                            <td>'. $product->ProductName .'</td>

                            <form method="post">
							<th style="padding-left: 50px;">
                                    <input type="quantity" name="quantity$product->ProductID" value="1" size="2" style="font-family: cursive"/>
                            </th>
                            <th style="padding-left: 50px;">
									<input type="submit" value="Add to Cart" style="border: none; font-size: 15px; padding: 10px;10px;cursor: pointer;font-family: cursive">
							</th>
							</form>							
							
                        </tr>
                        <tr>
                            <th>Price: </th>
                            <td>'. $product->UnitPrice .'</td>
                        </tr>
						<tr>
							<th>description of product: </th>
                            <td>'. $product->ProductDescription .'</td>
                        </tr>
						<div style="height: 2px; background-color: black;"></div>
						';
				         
		}		
        return $result;
        
    }
	
	//show product table with admin function like update and delete
	    function CreateProductTablesAdmin()
    {
        $productModel = new ProductModel();
		$productArray = $productModel->GetAllProducts();
        $result = "";
		
        $result=$result."
		<form action='ProductsWindow.php?action=add' method='post'><button style='width:auto;'>Add product</button></form>
		<form action='ProductsWindow.php?action=addshop' method='post'><button onclick='AddShope()' style='width:auto;'>Add shop</button></form>
		<form action='ProductsWindow.php?action=deleteshop' method='post'><button onclick='DeleteShope()' style='width:auto;'>delete shop</button></form>
		";
        //Generate a productTable for each productEntity in array
        foreach ($productArray as $key => $product) 
        {
			$productModel = new ProductModel();
			$shopID= $productModel->shopOfProduct($product->ProductID);
			$result = $result .'
                    <div style="height: 2px; background-color: black;"></div>
					<table class = "productTable" style="padding-bottom: 10px; padding-top: 10px;">
                        <tr>
                            <th rowspan="8" width = "250px" ><img src = '. $product->Image .' style="height: 25%;"/></th>
                            <th width = "75px" >Name: </th>
							
                            <td>'. $product->ProductName .'</td>

							<form action="ProductsWindow.php?action=delete&pid='.$product->ProductID.'" method="post">
                            <th style="padding-left: 50px;">
									<input type="submit" value="delete" name="dalete" style="border: none; font-size: 15px; padding: 10px;10px;cursor: pointer;font-family: cursive">
							</th>
							</form>
							<form action="ProductsWindow.php?action=update&pid='.$product->ProductID.'&pname='.$product->ProductName.'&pdesc='.$product->ProductDescription.'&scid='.$product->SubCategoryID.'&qpu='.$product->QuantityPerUnit.'&up='.$product->UnitPrice.'&pw='.$product->ProductWeight.'&sid='.$product->SupplierID.'&shop='.$shopID.'&active='.$product->Active.'" method="post">
							<th style="padding-left: 50px;" >
								<form action="ProductsWindow.php?action=update&pid=$product->ProductID" method="post"><input type="submit" value="update" name="update" style="border: none; font-size: 15px; padding: 10px;10px;cursor: pointer;font-family: cursive">
							</th>							
							</form>
                        </tr>
                        <tr>
                            <th>Price: </th>
                            <td>'. $product->UnitPrice .'</td>
                        </tr>
						<tr>
							<th>description of product: </th>
                            <td>'. $product->ProductDescription .'</td>
                        </tr>
						<div style="height: 2px; background-color: black;"></div>
						';
				         
		}		
        return $result;
        
    }
	
	
	function GetProductsCategory($CategoryName)
    {
        $ProductModel = new ProductModel();
		$ProductsArray = $ProductModel->GetProductsInCategory($CategoryName);
        $result = "";
		//Generate a productTable of category for each productEntity in array	
		foreach ($ProductsArray as $key => $product) 
        {
			$result = $result .
                    '
					<div style="height: 2px; background-color: black;"></div>
					<table class = "productTable" style="padding-bottom: 10px; padding-top: 10px;">
                        <tr>
                            <th rowspan="8" width = "250px" ><img src = '. $product->Image .' style="height: 25%;"/></th>
                            <th width = "75px" >Name: </th>
							
                            <td>'. $product->ProductName .'</td>

                            <form method="post">
							<th style="padding-left: 50px;">
                                    <input type="quantity" name="quantity$product->ProductID" value="1" size="2" style="font-family: cursive"/>
                            </th>
                            <th style="padding-left: 50px;">
									<input type="submit" value="Add to Cart" style="border: none; font-size: 15px; padding: 10px;10px;cursor: pointer;font-family: cursive">
							</th>
							</form>							
							
                        </tr>
                        <tr>
                            <th>Price: </th>
                            <td>'. $product->UnitPrice .'</td>
                        </tr>
						<tr>
							<th>description of product: </th>
                            <td>'. $product->ProductDescription .'</td>
                        </tr>
						<div style="height: 2px; background-color: black;"></div>
                        
						';					         
					 	 
		}        
        return $result;
        
    }
	
	//insert product
	function Insert($ProductName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$ShopID,$active){
		$productModel = new ProductModel();
		$isInsert=$productModel->Insert($ProductName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$ShopID,$active);	

		if($isInsert==1){
			
			$content='<script>alert("Product successfully added.")</script>';
		}
		else if($isInsert==0){
			$content='<script>alert("The product already exist.")</script>';
		}
		else{		
			$content='<script>alert("Failed to add product. Please try again later.")</script>';
		}
		return $content;
	}
	//for search - return list products according a search
	function GetProductByName($productName)
    {
        $productModel = new ProductModel();
		$productArray = $productModel->GetProductByName($productName);
		if($productArray){
			
        $result = "";
        //Generate a productTable for each productEntity in array
        foreach ($productArray as $key => $product) 
        {
            
			$result = $result .
                    '

					<div style="height: 2px; background-color: black;"></div>
					<table class = "productTable" style="padding-bottom: 10px; padding-top: 10px;">
                        <tr>
                            <th rowspan="8" width = "250px" ><img src = '. $product->Image .' style="height: 25%;"/></th>
                            <th width = "75px" >Name: </th>
							
                            <td>'. $product->ProductName .'</td>

                            <form method="post">
							<th style="padding-left: 50px;">
                                    <input type="quantity" name="quantity$product->ProductID" value="1" size="2" style="font-family: cursive"/>
                            </th>
                            <th style="padding-left: 50px;">
									<input type="submit" value="Add to Cart" style="border: none; font-size: 15px; padding: 10px;10px;cursor: pointer;font-family: cursive">
							</th>
							</form>							
							
                        </tr>
                        <tr>
                            <th>Price: </th>
                            <td>'. $product->UnitPrice .'</td>
                        </tr>
						<tr>
							<th>description of product: </th>
                            <td>'. $product->ProductDescription .'</td>
                        </tr>
						<div style="height: 2px; background-color: black;"></div>
						';	
		}
		}
		else 
		{
			
				$result = "not found";
		}
					        
        return $result;
	}
	//Get sub category by category name
	function get_subcategories($CategoryName){
	$ProductModel = new ProductModel();
	$subCategory = $ProductModel->Getsubcategories($CategoryName);
	return $subCategory;
	}
	
	//window show to update product
	function update_product($productID,$productName,$productDescription,$subCID,$quantityPerUnit,$unitPrice,$productWeight,$suppID,$shopID,$active){
		$productModel = new ProductModel();
		$sname=$productModel->ItsCategory($subCID);
		require_once ('backendAdminModel.php');
		$backendAdminModel=new backendAdminModel();
		$content="<div id='AddandUpdateProduct' class='modal'>
		<form class='modal-content' action='ProductsWindow.php'>
		<div class='container' >
			   
		  <label for='productName'><b>ProductName</b></label>
		  <input type='digits' value='$productName' name='productName' required>

		  <label for='productDescription'><b>ProductDescription</b></label>
		  <input type='text' value='$productDescription' name='productDescription' required>

		  <label for='subCategoryID'><b>SubCategoryID</b></label>
		  <select name='subCategoryID' value=$sname>";
		  //LOV subCategories from database
		  $subCategoryID=$backendAdminModel->subCategoryID();
		  foreach ($subCategoryID as $key => $category) 
			{
				if($category->SubCategoryID==$subCID){
					$content=$content."
				<option value='$category->SubCategoryID' selected>$category->SubCategoryName</option>";
				}
				else{
				$content=$content."
				<option value='$category->SubCategoryID'>$category->SubCategoryName</option>";
				}
			}
			$content=$content."
			</select>

		  <label for='quantityPerUnit'><b>QuantityPerUnit</b></label>
		  <input type='digits'  value= $quantityPerUnit name='quantityPerUnit'  required>

		  <label for='unitPrice'><b>UnitPrice</b></label>
		  <input type='digits' value=$unitPrice name='unitPrice' required>

		  <label for='productWeight'><b>ProductWeight</b></label>
		  <input type='digits' value=$productWeight name='productWeight' required>

		  
		  <label for='supplierID'><b>SupplierID</b></label>
		  <select name='supplierID' value=$suppID>";
		//LOV suppliers from database
		  $supplierID=$backendAdminModel->supplierID();
		  foreach ($supplierID as $key => $supplier) 
			{
				if($supplier->SuppliersID==$suppID){
					$content=$content."
				<option value='$supplier->SuppliersID' selected>$supplier->SuppliersName</option>";
				}
				else {
				$content=$content."
				<option value='$supplier->SuppliersID'>$supplier->SuppliersName</option>";
				}
			}
			$content=$content."
			</select>
			<label for='shop'><b>Shop ID</b></label>
		  <select name='shopID' >";
		  //LOV shops from database
		  $shops=$backendAdminModel->shopID();
		  foreach ($shops as $key => $shop) 
			{
				if($shop->ShopID==$shopID){
					$content=$content."
				<option value='$shop->ShopID' selected>$shop->ShopName</option>";
				}
				else {
				$content=$content."
				<option value='$shop->ShopID'>$shop->ShopName</option>";
				}				
			}
			$content=$content."
			</select>
		  <label for='active'><b>Active</b></label>";
		  if($active==1){//checkbox checked
			  $content=$content."
			<input type='checkbox' checked='checked' name='active' style='margin-bottom:15px'>";
		  }
		  else{//checkbox unchecked
			  $content=$content."
			<input type='checkbox' name='active' style='margin-bottom:15px'>";
		  }
		$content=$content."
		<div class='clearfix'  >
			<button type='button' onclick='document.getElementById('AddandUpdateProduct').style.display='none'' class='cancelbtn'>Cancel</button>
			<button type='submit' name='update' value=$productID class='signupbtn'>Update</button>
		  </div>
		</div>
		</form>
		</div>";
		return $content;
	}
	//window show to add product
	function add_product(){
		$productModel = new ProductModel();
		require_once ('backendAdminModel.php');
		$backendAdminModel=new backendAdminModel();
		$content="<div id='AddandUpdateProduct' class='modal'>
		<form class='modal-content' action='ProductsWindow.php'>
		<div class='container' >
			   
		  <label for='productName'><b>ProductName</b></label>
		  <input type='digits' placeholder='Enter Product Name' name='productName' required>

		  <label for='productDescription'><b>ProductDescription</b></label>
		  <input type='text' placeholder='Enter product Description' name='productDescription' required>

		  <label for='subCategoryID'><b>SubCategoryID</b></label>
		  <select name='subCategoryID' >";
		  //LOV subCategories from database
		  $subCategoryID=$backendAdminModel->subCategoryID();
		  foreach ($subCategoryID as $key => $category) 
			{
				
				$content=$content."
				<option value='$category->SubCategoryID'>$category->SubCategoryName</option>";
				
			}
			$content=$content."
			</select>
	 
		  <label for='quantityPerUnit'><b>QuantityPerUnit</b></label>
		  <input type='digits'  placeholder='Enter quantity Per Unit' name='quantityPerUnit'  required>
	 
		  <label for='unitPrice'><b>UnitPrice</b></label>
		  <input type='digits' placeholder='Enter Unit Price' name='unitPrice' required>
	 
		  <label for='productWeight'><b>ProductWeight</b></label>
		  <input type='digits' placeholder='Enter product Weight' name='productWeight' required>
	 
		  
		  <label for='supplierID'><b>SupplierID</b></label>
		  <select name='supplierID' >";
		  //LOV suppliers from database
		  $supplierID=$backendAdminModel->supplierID();
		  foreach ($supplierID as $key => $supplier) 
			{
				
				$content=$content."
				<option value='$supplier->SuppliersID'>$supplier->SuppliersName</option>";
				
			}
			$content=$content."
			</select>
			<label for='shop'><b>Shop ID</b></label>
		  <select name='shopID' >";
		  //LOV shops from database
		  $shopID=$backendAdminModel->shopID();
		  foreach ($shopID as $key => $shop) 
			{
				
				$content=$content."
				<option value='$shop->ShopID'>$shop->ShopName</option>";
				
			}
			$content=$content."
			</select>
		  <label for='active'><b>Active</b></label>
			<input type='checkbox' checked='checked' name='active' style='margin-bottom:15px'>
		<div class='clearfix'  >
			<button type='button' onclick='document.getElementById('AddandUpdateProduct').style.display='none'' class='cancelbtn'>Cancel</button>
			<button type='submit' name='add' value='add' class='signupbtn'>Add product</button>
		  </div>
		</div>
	  </form>
	</div>";
	return $content;
	}
	
	//Update product
	function update($pid,$productName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$active){
		$ProductModel = new ProductModel();
		$result = $ProductModel->update($pid,$productName,$productDescription,$subCategoryID,$quantityPerUnit,$unitPrice,$productWeight,$supplierID,$active);	
		
		if($result==1){
			$content='<script>alert("Product successfully updated. 
		If you changed the product name, make sure to change the image in : '.$Image.' to new name")</script>';}
		else {
			$content='<script>alert("The update failed. Please try again later."/script>';
		}
		return $content;
	}
	//window show to delete shop
	function delete_shop(){
		require_once ('backendAdminModel.php');
		$backendAdminModel=new backendAdminModel();
		$content="<div id='AddandUpdateProduct' class='modal'>
		<form class='modal-content' action='ProductsWindow.php'>
		<div class='container' 
		  <label for='shops'><b>Shops</b></label>
		  <select name='shopID' >";
		  //LOV- shops to delete
		  $shops=$backendAdminModel->shopID();
		  foreach ($shops as $key => $shop) 
			{
				
				$content=$content."
				<option value='$shop->ShopID'>$shop->ShopName</option>";
				
			}
			$content=$content."
			</select>
			<div class='clearfix'  >
			<button type='button' class='cancelbtn'>Cancel</button>
			<button type='submit' name='action' value='deletes' class='signupbtn'>Delete shop</button>
		  </div>
		</div>
	  </form>
	</div>";
	return $content;
	}
	//delete product from database
	function DeleteP($ProductID){
		$productModel = new ProductModel();
		$result=$productModel->DeleteP($ProductID);
		if($result==1)
			$content='<script>alert("Product deleted successfully.")</script>';
		else{
			$content='<script>alert("Deletion failed. Please try again later.")</script>';
		}
		return $content;
	}
	//delete shop from database
	function DeleteS($ShopID){
		$productModel = new ProductModel();
		$result=$productModel->DeleteS($ShopID);
		if($result==1)
			$content='<script>alert("Shop deleted successfully.")</script>';
		else{
			$content='<script>alert("Deletion failed. Please try again later.")</script>';
		}
		return $content;
	}
	//window show to add shop
	function add_shop(){
		$content="<div id='AddandUpdateProduct' class='modal'>
		<form class='modal-content' action='ProductsWindow.php'>
		<div class='container' >
			   
		  <label for='shopname'><b>Shop name</b></label>
		  <input type='text' placeholder='Enter shop Name' name='shopName' required>
		<div class='clearfix'  >
			<button type='button' class='cancelbtn'>Cancel</button>
			<button type='submit' name='add' value='addshop' class='signupbtn'>Add shop</button>
		  </div>
		</div>
	  </form>
	</div>";
	return $content;	
	}
	
	//insert shop to database
	function insert_shop($shopName){
		$productModel = new ProductModel();
		$isInsert=$productModel->InsertS($shopName);	

		if($isInsert==1){
			
			$content='<script>alert("Shop successfully added.")</script>';
		}
		else if($isInsert==0){
			$content='<script>alert("The Shop already exist.")</script>';
		}
		else{		
			$content='<script>alert("Failed to add shop. Please try again later.")</script>';
		}
		return $content;
	}
}
?>
