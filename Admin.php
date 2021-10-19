
<html>
<style>
<?php include 'CSS/enter.css'; ?>
</style>
<?php
$content='
<div id="admin">
<form action="EnterWindow.php" >
<label>enter password </label>
       <input type="password" placeholder="Enter Password" name="apsw" autocomplete="" required></br>
	   
        <button type="submit" name="action" value="admin" class="signupbtn" href="Admin.php" ><i class="fa fa-fw fa-user-secret"></i>enter</button>
		
		<button type="button" href="CategoryWindow.php" class="cancelbtn">Cancel</button>
		</form>
		</div>';
$active_page="backendAdmin";
include 'mainWindow.php';

?>
</html>
		
<?php
		
		
require_once 'UserController.php';

$UserController = new UserController();

if(!empty($_GET["action"])) {
	switch($_GET["action"]) {//check if the admin password is correct
	case "admin":
	$APassword=$_GET["apsw"];
	$UserController=new UserController();
	$email='Admin@gmail.com';
    $content=$UserController->checkPassword($email,$APassword);
	$active_page="backendAdmin";
	break;
	}
}	
?>		
