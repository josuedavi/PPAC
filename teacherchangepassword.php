<?php
include_once 'includes/db-connect.php';
include_once 'includes/functions.php';
include_once 'process-password-update.php';
 
sec_session_start();

if(isset($_SESSION['uid'])){
$uid = preg_replace("/[^0-9]/", "", $_SESSION['uid']); //XSS Security
$user=getUser($uid, $conn);
}

if(isUserLoggedIn($uid,$conn)=="false")
	header('Location: ./index.php');
	
$error=null;
if(isset($_GET["error"])){
	if(!is_numeric($_GET["error"])){
		$error="Dont not edit the URL GET var, thanks.";
	}else{
		$error = errorLogging($_GET["error"]);
	}
}
?>
<!DOCTYPE html>
<html lang="en-US">
<!--
Credit to https://bootsnipp.com/snippets/featured/login-and-register-tabbed-form#comments for the nice bootstrap theme.
-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS --><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="./assets/css/style.css">


<style>
 .card{
	padding: 0px;
	margin: 50px 300px;
  }

  .card input{
	  width: 80%;
  }

</style>
</head>

<body>

	<header>
    <p href="index.php" class="header-brand"><?php echo ucfirst(decrypt($user['username'])); ?></p>
    <nav>
      <ul>
        <li><a   href="./membersArea.php">Home</a></li>
        <li> <a  href="./gallery.php">Gallery</a></li>
        <li> <a id="active" href="./account.php">Account</a></li>
      </ul>
      <a href="./logout.php" class="header-cases" id="log">Logout</a>
    </nav>
  </header>
  
	
				
				<main>
			
							

				<div class="card">
					<div class="card-header">
					<h3><b>What Would You Like To Change Your Password To <?php echo decrypt($user['username']); ?>?</h3></b>
					</div>
					<div class="card-body">
					
					<a href="account.php">&larr; View Your Info.</a>
					<br>
					<br>
					<?php echo $error;?>
					<br>
					
					<form action="includes/process-password-update.php" method="post">
						
						<h5 class="card-title">Enter New Password</h5>
						<!--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->
						
						<input type="text" class="form-control"  name="password" placeholder="New Password">
						<br>
						<br>
						<input type="text" class="form-control"  name="passwordConfirm" placeholder="Confirm New Password">
						<br>
						<br>
						<button type="submit" name="submit" class="btn btn-primary">Change Password</button>
					</form>
					</div>
				</div>
</main>
			


</body>
</html>