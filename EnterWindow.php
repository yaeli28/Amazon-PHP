<html>
<style>
<?php include 'CSS/enter.css'; ?>
</style>

<!--<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" autofocus>Sign Up</button>-->
<?php $content="";   ?>
<div id="id01" class="modal" >
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal" >&times;</span>
  <form class="modal-content"> 
    <div class="container">
      <h1>Log In</h1>
	    <button id="btn" type="button" onclick="openandclose()" class="signupbtn">Sign Up</button>
      <p>Pleas enter you email and password to log in</p>
      <hr>
      <label for="email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="email" required></br>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" autocomplete="" required></br>
      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>
      <div class="clearfix">
       <!--- <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>-->
        <button  id="btn" type="submit" name="action" value="enter" class="login" onclick="document.getElementById('id01').style.display='none'"><i class="fa fa-fw fa-sign-in"></i>Log In</button>
      </div>
    </div>
  </form>
</div>
<!--EnterWindow.php?action=enter&email=?action=enter&email=yaelc9977@gmail.com&psw=123123&remember=on-->
<div id="id02" class="modal">
  <span onclick="document.getElementById('id02').style.display='block'" class="close" title="Close Modal">&times;</span>
  <form class="modal-content" >  
    <div class="container">
      <h1>Sign up</h1>
	<button id="btn" type="button" onclick="openandclose()" class="signupbtn">sign in</button>
      <p>Please fill in you details to sign up</p>
      <hr>
      <label for="First name"><b>First name</b></label>
      <input type="text" placeholder="Enter First name" name="first_name" required>
	   <label for="Last name"><b>Last name</b></label>
      <input type="text" placeholder="Ente Last name" name="last_name" required></br>
	   <label for="Email"><b>Email</b></label>
      <input type="email" placeholder="Enter Email " name="email" required></br>
	   <label for="Phone number"><b>Phone number</b></label>
      <input type="digits" placeholder="Enter Phone number" name="phone_number" required></br>
	   <label for="City"><b>City</b></label>
      <input type="text" placeholder="Enter City" name="city" required>
	   <label for="country"><b>Country</b></label>
      <input type="text" placeholder="Enter Country" name="country" required>
	   <label for="Zip code"><b>Zip code</b></label>
      <input type="text" placeholder="Enter Zip code" name="zip_code" ></br>
	   <label for="Street"><b>Street</b></label>
      <input type="text" placeholder="Enter Street" name="street" ></br>
	   <label for="House number"><b>House number</b></label>
      <input type="digits" placeholder="Enter House number" name="house_number" ></br>
	   <label for="Department numbe"><b>Department number</b></label>
      <input type="digits" placeholder="Enter Department number" name="department_number" ></br>
	   <label for="Password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required ></br>
	   <label for="Birthday"><b>Birthday</b></label>
      <input type="date" placeholder="Enter Birthday" name="birthday" /></br>
	      <div class="clearfix">
       <!--- <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>-->
        <button id="btn" type="submit" class="signupbtn" name="action" value="signUp"><i class="fa fa-fw fa-user-secret"></i>Sign Up</button>
      </div>
    </div>
  </form>
</div>
<div id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div>
<script>
// Get the modal
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');
     modal1.style.display = "block";
		function openandclose()
		{
			
		if(modal1.style.display=="none")
		{
		modal2.style.display="none";
		modal1.style.display="block";
		}
		else{
				
		modal1.style.display="none";
		modal2.style.display="block";
		}
		}
		
/*document.getElementById('id01').addEventListener('click', function(){
    document.getElementById('id01').click();
});*/
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
	else if(event.target == modal2) {
        modal2.style.display = "none";
		modal1.style.display = "none";
    }
}
</script>

				
<script>
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}


<?php

require 'UserController.php';

$UserController = new UserController();

if(!empty($_GET["action"])) {
	switch($_GET["action"]) {
	case "Add"://open window with products below category 
		$CategoryName = $_GET["code"];
		$productContoller = new productContoller();
		$productContoller->GetProductsInCategory($CategoryName);	
		break;
	case "enter"://enter user
		$email = $_GET["email"];
		$psw =  $_GET["psw"];
		$content=$UserController->enterUser($email, $psw);
		break;
	case "signUp"://sign up user
		require 'ProductController.php';
		$first_name = $_GET["first_name"];
		$last_name = $_GET["last_name"];
		$email = $_GET["email"];
		$phone_number = $_GET["phone_number"];
		$city = $_GET["city"];
		$country = $_GET["country"];
		$zip_code = $_GET["zip_code"];
		$street = $_GET["street"];
		$house_number =  $_GET["house_number"];
		$department_number =  $_GET["department_number"];
		$psw =  $_GET["psw"];
		$birthday =  $_GET["birthday"];
		$UserController->signUp($first_name,$last_name,$email,$phone_number,$city,$country,$street,$house_number,$department_number,$zip_code,$psw,$birthday);
		echo "<script> document.getElementById('id02').style.display='none'</script>";
		echo "<script> document.getElementById('id01').style.display='block'</script>";
		break;
	case "admin"://check if admin password is valid.
		$APassword=$_GET["apsw"];
		$email='Admin@gmail.com';
		$content=$UserController->checkPassword($email,$APassword);
		break;
	}
}
$active_page="user";
include 'mainWindow.php';

?>
</script>
</html>
