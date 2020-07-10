<?php
include_once 'includes/db-connect.php';
include_once 'includes/functions.php';
 
//TODO:x Can enter blank username on login and maybe other forms

sec_session_start();


//Note an SSL connection is required to prevent network sniffing
if(isset($_SESSION['uid'])){
	$uid = preg_replace("/[^0-9]/", "", $_SESSION['uid']); //XSS Security
	if(isUserLoggedIn($uid,$conn)=="true"){
		header('Location: ./membersArea.php');
	}
}



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
 <link rel="stylesheet" type="text/css" href="assets/css/index.css">
<title>Login System</title>
</head>

<body>

<div id="particles-js">

<div class="container">
  
    <div class="row">
      <div class="d-flex justify-content-lg-center align-items-center vh-100">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-login">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-4">
                <a href="#" id="login-form-link">Home</a>
              </div>
              <div class="col-xs-4">
                <a href="index.php" class="active" id="login-form-link">Login</a>
              </div>
              <div class="col-xs-4">
                <a href="register.php"  id="register-form-link">Register</a>
              </div>
            </div>
            <hr>
          </div>
         
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
              
                <form id="login-form" action="./includes/process-login.php" method="post" role="form" style="display: block;">
                  <div class="form-group">
                    <input type="text" name="username" id="username" required pattern="[a-zA-Z0-9]+" title="Please use aplhanumeric charaters only." tabindex="1" class="form-control" placeholder="Username" value="">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
				  </div>
				  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="text-center">
                          <a href="forgotPassword.php" tabindex="5" class="forgot-password">Forgot Password?</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
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