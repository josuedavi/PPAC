<?php
include_once 'includes/db-connect.php';
include_once 'includes/functions.php';

 
sec_session_start();

if(isset($_SESSION['uid'])){
$uid = preg_replace("/[^0-9]/", "", $_SESSION['uid']); //XSS Security
$user=getUser($uid, $conn);
}

if(isUserLoggedIn($uid,$conn)=="false"){
	header('Location: ./index.php');
}

$expire=time()+3600;
$username = $_SESSION['uid'];
setcookie("user", $username, $expire, "/","josuedcastillo.com");


?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <title>Members Area</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta charset="utf-8">
      
      
    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
   

      <!-- external stylesheet -->
      <link rel="stylesheet" type="text/css" href="assets/css/account.css">
   
   
      
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

   
			<div class="card">
					<div class="card-header">
					<h3><b>All Your Personal Info.</b></h3>
					</div>
					<div class="card-body">
						<h5 class="card-title">Here Is Your Account Info:</h5>
                        <p class="card-text"><b>Your Username: </b><?php echo decrypt($user['username']);?></p>
                        <br>
						
                        <p class="card-text"><b>Your Email: </b><?php echo decrypt($user['email']);?></p>
                        <br>
						
                        <p class="card-text"><b>Your Date of Birth: </b><?php echo decrypt($user['dob']);?></p>
						<br>
						<br>
						<br>
						<a href="forgotPassword.php"><button type="button" class="btn btn-primary">Change Password</button></a>
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
