<?php
include_once 'includes/db-connect.php';
include_once 'includes/functions.php';
 
sec_session_start();


$user = $_COOKIE['user'];
   
    $stmt=$conn->prepare("SELECT uid, username, password, email, dob  FROM users WHERE uid = $user"); //sql insert query					
			  //bind all parameter 
		
     $stmt->execute();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
           
              
              <h1><?php $username = $row["username"];?></h1>
             
              <h1><?php $email = decrypt($row["email"]);?></h1>
              <h1><?php $dob = decrypt($row["dob"]);?></h1>
              
            
        <?php
        }
        ?>

<?php
$user=null;


	$user=getUserFromEmail($email,$conn);
	generateResetToken($conn, $user['uid']);
	$email=filter_var($email, FILTER_VALIDATE_EMAIL);


$token = getResetToken($user['uid'],$conn);

//Error handling
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
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="./assets/css/style.css">
<title>Login System</title>
</head>

<body>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-login">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12">
							<a href="./register.php" class="active" id="register-form-link">Forgot Password Reset</a>
						</div>
					</div>
					<hr>
				</div>
				<div class="panel-body">
				<nav class="navbar navbar-default">
				<div class="container-fluid">
					<ul class="nav navbar-nav">
					<li><a  href="./index.php">Home</a></li>
					<li><a  href="./index.php">Login</a></li>
					</ul>
				</div>
				</nav>
					<div class="row">
						<div class="col-lg-12">
							<?php echo $error;?>

						
								<br/>
							
							<form id="register-form" action="./includes/process-forgot-password.php" method="post" role="form">

								<div class="form-group">
									<input type="text" name="token" id="token" tabindex="2" class="form-control" placeholder="Paste reset token here">
								</div>
								<div class="form-group">
								<input type="text" name="email" id="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Please use aplhanumeric charaters only." tabindex="1" class="form-control" placeholder="test@test.com">
								</div>
								<div class="form-group">
									<input type="text" id="dob" required class="form-control" data-format="DD-MM-YYYY" data-template="DD-MMM-YYYY" name="dob" placeholder="DD-MM-YYYY">
								</div>
								<div class="form-group">
									<input type="password" name="newPassword" id="newPassword" tabindex="2" class="form-control" placeholder="New Password">
								</div>
								<div class="form-group">
									<input type="password" name="passwordConfirm" id="passwordConfirm" tabindex="2" class="form-control" placeholder="Confirm New Password">
								</div>
								<input type="hidden" name="username" id="username" tabindex="1" class="form-control" value="<?php echo $user['username']?>">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Update Password">
										</div>
									</div>
								</div>
							</form>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>