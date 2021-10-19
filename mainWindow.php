<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
<?php include 'CSS/main.css'; ?>
</style>
</head>
<body style="font-family: sans-serif">

<div class="header">
  <img src="images/images.png" alt="Forest" style="width:35%">
</div>

<div id="navbar">
  
  <a id="start" <?php echo($active_page=="categories")?"class='active'":''?> href="CategoryWindow.php"><i class="fa fa-fw fa-shopping-bag"></i> Categories</a>  
  <div class="dropdown">
  <i class="fa fa-fw fa-user" style="color:white;font-size:18px;margin-left:10px;margin-top:9px;"></i>
	<button class="dropbtn">User 
	  <i class="fa fa-caret-down"></i>
	</button>
	<div class="dropdown-content">
	  <a id="ddd00" href="EnterWindow.php?">Log in</a>
	  <a id="ddd00" href="EnterWindow.php?">Log out</a>
	  <a href="EnterWindow.php">Sign up</a>
	  <a href="EnterWindow.php">Update User</a>
	</div>
  </div>
  
  <a id="admin_backend" <?php echo($active_page=="backendAdmin")?"class='active'":''?> href="Admin.php"><i class="fa fa-fw fa-cloud"></i> backendAdmin</a>
  <a <?php echo($active_page=="about")?"class='active'":''?> href="AboutWindow.php"><i class="fa fa-fw fa-superpowers"></i> about</a>
  <div class="search-container" >
    <form action='ProductsWindow.php?action=find&PN=$product->ProductName'>
      <div class="search"><input type="text" placeholder="Search.." name="search"></div>
      <button id="sr" type="submit" href="ProductsWindow.php"><i class="fa fa-fw fa-search"></i> Search</button>
    </form>
  </div>
</div>
<script>

window.onscroll = function() {myFunction()};
var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

</script>

<div class="content" id="main">
	<?php
		echo $content;
	?>
	
</div>


</body>
</html>
