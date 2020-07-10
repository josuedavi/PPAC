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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <link rel="stylesheet" href="thumbnail-gallery.css">

      <!-- external stylesheet -->
      <link rel="stylesheet" type="text/css" href="assets/css/membersArea.css">
   
   
      
    </head>

    <body>
<div id="particles-js">

   <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-3 bg-company-red">
        <div class="container">
           
   <a href="teacherhome.php" class="display-5"><?php echo ucfirst(decrypt($user['username'])); ?></a>
          
    
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                
           
                
                 <div class="navbar-nav mr-auto">
             
      </div>

  <div class="mx-auto order-0">
       <a class="navbar-brand disp active mx-5" href="teacherhome.php">Home</a>
         
              <a class="navbar-brand disp mx-5" href="teachergallery.php">Gallery</a>
       
      <a class="navbar-brand disp mx-5"  href="teacheraccount.php">Account</a>
                
             
  </div>

      <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <a class="navbar-brand  active " href="../logout.php">Logout</a>
          </li>
      </ul>
            </div>
        </div>
    </nav>

  
    <div class="jumbotron text-center ">
    
        <h1 class="display-4">Welcome To The Gallery For Creatives</h1>
  <p class="lead">View PPAC Student's Artwork</p>


  <a class="btn btn-primary btn-lg mt-3" href="#ue" role="button">View Gallery</a>
    </div>
  


</div>
  

</div>

<!-- photos need to be 800px x 600px -->

<div class="container gallery-container mh-0">

   
    

 <h1 id="ue">Creative Gallery</h1>

    <p id="click" class="page-description text-center">Click On Images To Enlarge</p>
    <div class="tz-gallery mh-0">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <a class="lightbox" href="assets/park.jpg">
                    <img src="assets/park.jpg" alt="Park">
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a class="lightbox" href="assets/bridge.jpg">
                    <img src="assets/bridge.jpg" alt="Bridge">
                </a>
            </div>
            <div class="col-sm-12 col-md-4">
                <a class="lightbox" href="assets/tunnel.jpg">
                    <img src="assets/tunnel.jpg" alt="Tunnel">
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a class="lightbox" href="assets/coast.jpg">
                    <img src="assets/coast.jpg" alt="Coast">
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a class="lightbox" href="assets/rails.jpg">
                    <img src="assets/rails.jpg" alt="Rails">
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a class="lightbox" href="assets/traffic.jpg">
                    <img src="assets/traffic.jpg" alt="Traffic">
                </a>
            </div>
           
            </div>
        </div>

    </div>

</div>


<div class="container gallery-containers">

    <h1 id="ue">Upcoming Events</h1>

    <p id="click" class="page-descriptions text-centers">Click On Images For More Information</p>
    
    <div class="tz-gallerys">

        <div class="row">

            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a class="lightbox" href="https://www.philaphotoarts.org/programs/oh-snap/">
                        <img class="mx-auto d-block" src="https://www.philaphotoarts.org/wp-content/uploads/2020/02/ohsnap-214x160.jpg" alt="Park">
                    </a>
                    <div class="caption ">
                        <h3>Oh, Snap!</h3>
                        <p id="click">February 15 – June 20</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a class="lightbox " href="https://www.philaphotoarts.org/event/ten-years/">
                        <img class="mx-auto d-block" src="https://www.philaphotoarts.org/wp-content/uploads/2020/01/Photo-4-214x160.jpg" alt="Bridge">
                    </a>
                    <div class="caption">
                        <h3>Ten Years</h3>
                        <p id="click">March 12 – May 2</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a class="lightbox" href="https://www.philaphotoarts.org/event/thursday-night-photo-talk/">
                        <img class="mx-auto d-block" src="https://www.philaphotoarts.org/wp-content/uploads/2020/03/flag_v3-214x160.jpg" alt="Tunnel">
                    </a>
                    <div class="caption">
                        <h3>Thursday Night Photo Talk 4/9</h3>
                        <p id="click">April 9th</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a class="lightbox" href="https://www.philaphotoarts.org/wp-content/uploads/2020/03/portrait-04-214x160.jpg">
                        <img class="mx-auto d-block" src="https://www.philaphotoarts.org/wp-content/uploads/2020/03/portrait-04-214x160.jpg" alt="Coast">
                    </a>
                    <div class="caption">
                        <h3>Thursday Night Photo Talk 4/16</h3>
                        <p id="click">April 16th</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a class="lightbox" href="https://www.philaphotoarts.org/wp-content/uploads/2020/02/NicholasMuellner_MakingDoubles-02295-1-214x160.jpg">
                        <img class="mx-auto d-block" src="https://www.philaphotoarts.org/wp-content/uploads/2020/02/NicholasMuellner_MakingDoubles-02295-1-214x160.jpg" alt="Rails">
                    </a>
                    <div class="caption">
                        <h3>Thursday Night Photo Talk 4/23</h3>
                        <p id="click">April 23rd</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a class="lightbox" href="https://www.philaphotoarts.org/wp-content/uploads/2020/03/PetePin_talk-214x160.jpg">
                        <img class="mx-auto d-block" src="https://www.philaphotoarts.org/wp-content/uploads/2020/03/PetePin_talk-214x160.jpg" alt="Traffic">
                    </a>
                    <div class="caption">
                        <h3>Thursday Night Photo Talk 4/30</h3>
                        <p id="click">April 30th</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>





         

    <footer>
                  <div class="row justify-content-center">
                    <div class="col-md-12">
                        <p id="name">Copyright &copy; 2020</p>
                        <p id="name">Josue Castillo</p>
                  </div>
              </footer>


<!-- scripts -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>
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
