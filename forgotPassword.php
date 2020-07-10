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
  

$user=null;


	$user=getUserFromEmail($email,$conn);
	generateResetToken($conn, $user['uid']);
	


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
  <html lang="en-us">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

 <!-- external stylesheet -->
      <link rel="stylesheet" type="text/css" href="assets/css/changepass.css">
    <title>Login System</title>
    </head>
  <body>
<div id="particles-js">
    
     <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-3 bg-company-red">
        <div class="container">
           
   <a href="index.php" class="display-5"><?php echo ucfirst(decrypt($user['username'])); ?></a>
          
    
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                
           
                
                 <div class="navbar-nav mr-auto">
             
      </div>

  <div class="mx-auto order-0">
       <a class="navbar-brand disp active mx-5" href="index.php">Home</a>
         
              <a class="navbar-brand disp mx-5" href="gallery.php">Gallery</a>
       
      <a class="navbar-brand disp mx-5"  href="account.php">Account</a>
                
             
  </div>

      <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <a class="navbar-brand  active " href="../logout.php">Logout</a>
          </li>
      </ul>
            </div>
        </div>
    </nav>

    
    
    		
						<div class="card mt-4">
        					<div class="card-header">
        					<h3><b>Change Password Form</b></h3>
        					</div>
        					<div class="go-back">
        					    <a href="account.php">< Account Info.</a>
        					</div>
        					<div class="card-body">
        						<form id="register-form" action="./includes/process-forgot-password.php" method="post" role="form">
                                <?php echo $error;?>
								<div class="form-group">
									<input type="hidden" name="token" id="token" tabindex="2" class="form-control" value="<?php echo $token; ?>">
								</div>
								<div class="form-group">
								    <label>Email:</label>
								<input type="text" name="email" id="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Please use aplhanumeric charaters only." tabindex="1" class="form-control" placeholder="test@test.com">
								</div>
								<div class="form-group">
								     <label>Date of Birth:</label>
									<input type="text" id="dob" required class="form-control" data-format="DD-MM-YYYY" data-template="DD-MMM-YYYY" name="dob" placeholder="DD-MM-YYYY">
								</div>
								<div class="form-group">
								     <label>New Password:</label>
									<input type="password" name="newPassword" id="newPassword" tabindex="2" class="form-control" placeholder="New Password">
								</div>
								<div class="form-group mb-5">
								     <label>Confirm New Password:</label>
									<input type="password" name="passwordConfirm" id="passwordConfirm" tabindex="2" class="form-control" placeholder="Confirm New Password">
								</div>
								<input type="hidden" name="username" id="username" tabindex="1" class="form-control" value="<?php echo $user['username']?>">
								<div class="form-group text-center">
									<div class="text-center">
									    <Button type="submit" class="btn" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register">Update Password</Button>
									</div>
											
										</div>
									</div>
								</div>
							</form>
        					</div>
        				</div>
    
    
       
    
    </div>
    
    
    
    
    
            
    
    
    
    <!-- scripts -->
    <script src="particles.js"></script>
    <script src="assets/js/app.js"></script>
    
    
    <script>
      var count_particles, stats, update;
      stats = new Stats;
      stats.setMode(0);
      stats.domElement.style.position = 'absolute';
      stats.domElement.style.left = '0px';
      stats.domElement.style.top = '0px';
      document.body.appendChild(stats.domElement);
      count_particles = document.querySelector('.js-count-particles');
      update = function() {
        stats.begin();
        stats.end();
        if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
          count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
        }
        requestAnimationFrame(update);
      };
      requestAnimationFrame(update);
    </script>
    
    </body>
</html>