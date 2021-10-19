
<html>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

/* Add a background color when the inputs get focus */
input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: #474e5d;
  padding-top: 50px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* Style the horizontal ruler */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}
 
/* The Close Button (x) */
.close {
  position: absolute;
  right: 35px;
  top: 15px;
  font-size: 40px;
  font-weight: bold;
  color: #f1f1f1;
}

.close:hover,
.close:focus {
  color: #f44336;
  cursor: pointer;
}

/* Clear floats */
.clearfix::after {
  content: '';
  clear: both;
  display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }
}
</style>
<body>
<?php  
require_once 'productController.php';
$p= new productController();?>
<script>
<?php $p->CreateProductTablesAdmin();?>
</script>
<button onclick='AddProduct()' style='width:auto;'>Add product</button>
<button onclick='DeleteProduct()' style='width:auto;'>delete product</button>
<button onclick='UpdateProduct()' style='width:auto;'>update product</button>

<button onclick='AddShope()' style='width:auto;'>Add shop</button>
<button onclick='DeleteShope()' style='width:auto;'>delete shop</button>


<button onclick='AddProductINShope()' style='width:auto;'>Add product in shop</button>
<button onclick='DeleteProductFromShop()' style='width:auto;'>delete product from shop</button>
</div>

<div id='AddandUpdateProduct' class='modal'>
  <span onclick='document.getElementById('AddandUpdateProduct').style.display='none'' class='close' title='Close Modal'>&times;</span>
  <form class='modal-content' action='ProductsWindow.php'>
    <div class='container' >
           
      <label for='productName'><b>ProductName</b></label>
      <input type='number_format' placeholder='Enter Product Name' name='productName' required>

      <label for='productDescription'><b>ProductDescription</b></label>
      <input type='text' placeholder='Enter product Description' name='productDescription' required>

      <label for='subCategoryID'><b>SubCategoryID</b></label>
	  <select name='subCategoryID'>";
		<?php require_once ('backendAdminModel.php');
	  $backendAdminModel=new backendAdminModel();
	  $subCategoryID=$backendAdminModel->subCategoryID();
	  foreach ($subCategoryID as $key => $category) 
        {
			<option value='$category->SubCategoryID'>$category->SubCategoryName</option>;
		}
		?>
		</select>
 
      <label for='quantityPerUnit'><b>QuantityPerUnit</b></label>
      <input type='number_format'  name='quantityPerUnit' required>
 
      <label for='unitPrice'><b>UnitPrice</b></label>
      <input type='float' placeholder='Enter Unit Price' name='unitPrice' required>
 
      <label for='productWeight'><b>ProductWeight</b></label>
      <input type='float' placeholder='Enter product Weight' name='productWeight' required>
 
      
      <label for='supplierID'><b>SupplierID</b></label>
      <select name='supplierID'>";
	<?php 	require_once ('backendAdminModel.php');
	  $backendAdminModel=new backendAdminModel();
	  $supplierID=$backendAdminModel->supplierID();
	  foreach ($supplierID as $key => $supplier) 
        {
			<option value='$supplier->SuppliersID'>$supplier->SuppliersName</option>;
		}
		?>
		</select>
 
 
      <label for='active'><b>Active</b></label>
      <input type='active' placeholder='Enter active' name='active' required>
	
       
    <div class='clearfix'  >
        <button type='button' onclick='document.getElementById('AddandUpdateProduct').style.display='none'' class='cancelbtn'>Cancel</button>
        <button type='submit' name='add' value='add' class='signupbtn'>Add</button>
      </div>
    </div>
  </form>
</div>
<div id='DeleteProduct' class='modal'>
  <span onclick='document.getElementById('DeleteProduct').style.display='none'' class='close' title='Close Modal'>&times;</span>
  <form class='modal-content' action='ProductsWindow.php'>
    <div class='container'>
     
      <label for='productid'><b>Product ID</b></label>
      <input type='number_format' placeholder='Enter productId' name='productId' required>

             
    <div class='clearfix'>

        <button type='button' onclick='document.getElementById('DeleteProduct').style.display='none'' class='cancelbtn'>Cancel</button>
        <button type='submit' class='signupbtn'>delete</button>

      </div>
    </div>
  </form>
</div>
<div id='Deleteshop' class='modal'>
  <span onclick='document.getElementById('Deleteshop').style.display='none'' class='close' title='Close Modal'>&times;</span>
  <form class='modal-content' >
    <div class='container'>
     
      <label for='shopName'><b>Shop Name</b></label>
      <input type='shopName' placeholder='Enter shop Name' name='shopName' required>

             
    <div class='clearfix'>

        <button type='button' onclick='document.getElementById('Deleteshop').style.display='none'' class='cancelbtn'>Cancel</button>
        <button type='submit' class='signupbtn'>delete</button>

      </div>
    </div>
  </form>
</div>
<div id='Addshop' class='modal'>
  <span onclick='document.getElementById('Addshop').style.display='none''  class='close' title='Close Modal'>&times;</span>
  <form class='modal-content' action='/action_page.php'>
    <div class='container'>
     
      <label for='shopName'><b>Shop Name</b></label>
      <input type='shopName' placeholder='Enter shop Name' name='shopName' required>

             
    <div class='clearfix'>

        <button type='button' onclick='document.getElementById('Addshop').style.display='none'' class='cancelbtn'>Cancel</button>
        <button type='submit' class='signupbtn'>Add</button>

      </div>
    </div>
  </form>
</div>
<div id='DeleteProductInShop' class='modal'>
  <span onclick='document.getElementById('DeleteProductInShop').style.display='none'' class='close' title='Close Modal'>&times;</span>
  <form class='modal-content' action='/action_page.php'>
    <div class='container'>
     
      <label for='shopID'><b>Shop ID</b></label>
      <input type='shopID' placeholder='Enter Product ID' name='productID' required>
 <label for='productID'><b>Product ID</b></label>
      <input type='productID' placeholder='Enter product ID' name='productID' required>

             
    <div class='clearfix'>

        <button type='button' onclick='document.getElementById('DeleteProductInShop').style.display='none'' class='cancelbtn'>Cancel</button>
        <button type='submit' class='signupbtn'>Add</button>

      </div>
    </div>
  </form>
</div>
<div id='AddProductInShop' class='modal'>
  <span onclick='document.getElementById('AddProductInShop').style.display='none'' class='close' title='Close Modal'>&times;</span>
  <form class='modal-content' action='/action_page.php'>
    <div class='container'>
     
      <label for='shop id'><b>Shop ID</b></label>
      <input type='shop id' placeholder='Enter shop id' name='shop id' required>
 <label for='product id'><b>product ID</b></label>
      <input type='product id' placeholder='Enter product id' name='product id' required>

             
    <div class='clearfix'>

        <button type='button' onclick='document.getElementById('AddProductInShop').style.display='none'' class='cancelbtn'>Cancel</button>
        <button type='submit' class='signupbtn'>Add</button>

      </div>
    </div>
  </form>
</div>
<div id='DeleteProductFromShop' class='modal'>
  <span onclick='document.getElementById('DeleteProductFromShop').style.display='none'' class='close' title='Close Modal'>&times;</span>
  <form class='modal-content' action='/action_page.php'>
    <div class='container'>
     
      <label for='shopId'><b>Shop ID</b></label>
      <input type='shopId' placeholder='Enter shopId' name='shopId' required>
 <label for='productId'><b>product ID</b></label>
      <input type='productId' placeholder='Enter productId' name='productId' required>

             
    <div class='clearfix'>

        <button type='button' onclick='document.getElementById('DeleteProductFromShop').style.display='none'' class='cancelbtn'>Cancel</button>
        <button type='submit' class='signupbtn'>delete</button>

      </div>
    </div>
  </form>
</div>
";
$active_page="backendAdmin";
include "mainWindow.php";

?>

</body>

<script>
// Get the modal
var modal = document.getElementById('AddandUpdateProduct');
var modal2 = document.getElementById('AddandUpdateProduct');
var modal3 = document.getElementById('DeleteProduct');
var modal4 = document.getElementById('Addshop');
var modal5 = document.getElementById('DeleteShope');
var modal6 = document.getElementById('AddProductInShop');
var modal7 = document.getElementById('DeleteProductFromShop');
function AddProduct()
{
	document.getElementById('AddandUpdateProduct').style.display='block';
}
function UpdateProduct()
{
	document.getElementById('AddandUpdateProduct').style.display='block';
}
function DeleteProduct()
{
	document.getElementById('DeleteProduct').style.display='block';
}
function AddShope()
{
	document.getElementById('Addshop').style.display='block';
}
function DeleteShope()
{
	document.getElementById('DeleteShope').style.display='block';
}
function AddProductINShope()
{
	document.getElementById('AddProductInShop').style.display='block';
}
function DeleteProductInShop()
{
	document.getElementById('DeleteProductFromShop').style.display='block';

}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }if (event.target == modal2) {
    modal2.style.display = "none";
  }if (event.target == modal3) {
    modal3.style.display = "none";
  }if (event.target == modal4) {
    modal4.style.display = "none";
  }if (event.target == modal5) {
    modal5.style.display = "none";
  }if (event.target == modal6) {
    modal6.style.display = "none";
  }if (event.target == modal7) {
    modal7.style.display = "none";
  }
}
</script>
</html>