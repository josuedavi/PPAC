<?php
//necessary
require_once "includes/db-connect.php";
require_once "includes/functions.php"; 


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



if(isset($_REQUEST['delete_id']))
{
    // select image from db to delete
    $id=$_REQUEST['delete_id'];	//get delete_id and store in $id variable
    
    $select_stmt= $conn->prepare('SELECT * FROM gallery WHERE idGallery =:id');	//sql select query
    $select_stmt->bindParam(':id',$id);
    $select_stmt->execute();
    $row=$select_stmt->fetch(PDO::FETCH_ASSOC);
    unlink("upload/".$row['imgFullNameGallery']); //unlink function permanently remove your file
    
    //delete an orignal record from db
    $delete_stmt = $conn->prepare('DELETE FROM gallery WHERE idGallery =:id');
    $delete_stmt->bindParam(':id',$id);
    $delete_stmt->execute();
    
    header("Location:gallery.php");
    
  
}
?>

<!DOCTYPE html>
  <html lang="en">
    <head>
      <title>Gallery</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta charset="utf-8">
      
<!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>   <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
   

   <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
   

      <!-- external stylesheet -->
      <link rel="stylesheet" type="text/css" href="assets/css/gallery.css">
   
    </head>
 <body>
     
  
   <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-3 bg-company-red">
        <div class="container">
           
   <a href="index.php" class="display-5">Gallery</a>
          
    
            <button type="button" class="navbar-toggler " data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                
           
                
                 <div class="navbar-nav mr-auto">
             
      </div>

  <div class="mx-auto order-0">
       <a class="navbar-brand  active mx-5" href="index.php">Home</a>
         
              <a class="navbar-brand  mx-5" href="gallery.php">Gallery</a>
       
      <a class="navbar-brand  mx-5"  href="account.php">Account</a>
                
             
  </div>

      <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <a class="navbar-brand  active " href="../logout.php">Logout</a>
          </li>
      </ul>
            </div>
        </div>
    </nav>

         <div class="container gallery-container pt-1 ">


    
    
                               
          <?php



                                    $order = $_COOKIE['user'];

                                    $stmt = $conn->prepare("SELECT * FROM gallery WHERE orderGallery=$order");
                                    $stmt->execute();
                                    $rowCount = $stmt->rowCount();
                                   
                                    
                                    if( $rowCount > 0){
        ?>                          
                                   

                                        <h1 class="">Personal Creative Gallery</h1>
                                    
                                        <p class="page-description text-center ">Click On Captions To Delete Image</p>
                                        
                                        <div class="tz-gallery">

                                        <div class="row">
         
         <?php                                
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            
                                            ?>
                                           
                                           <div class="col-sm-6 col-md-4 first">
                                  <a class="lightbox" href="includes/<?php echo $row["imgFullNameGallery"]; ?>">
                                     <img src="includes/<?php echo $row["imgFullNameGallery"]; ?>">
                                  </a>   
                                  <a class="del" href="?delete_id=<?php echo $row['idGallery']; ?>">
                                      <h3><?php echo $row["titleGallery"]?></h3>
                                      <p><?php echo $row["descGallery"] ?></p>
                                  </a>
                              </div>
                                                
                                            <?php
                                            }
                                            ?>
                                     <?php       
                                    }
                                    
                                    else{
                                     ?>     
                                   

                                        <h1 class="">Personal Creative Gallery</h1>
                                    
                                        <p class="page-description text-center">Add Images To Populate Gallery</p>
                                        
                                        <div class="tz-gallery">

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

                                    <?php
                                    }
                                    ?>
                                    
                                          
   </div>
   </div>
   
 


          
              <div class="d-flex justify-content-center align-items-center container ">

                <div class="row ">

            <form action="includes/gallery-upload.inc.php" method="POST" enctype="multipart/form-data">

                <div class="page-header">

                  <h1 class="mt-5" id="ue">UPLOAD</h1>
                  <br/>
                </div>
                <div  class="form-group">
                    <input type="text" class="form-control" name="filename" placeholder="File Name">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="filetitle" placeholder="Image Title">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="filedesc"  placeholder="Image Description">
                  </div>
                  <div class="form-group">
                    <input type="file" class="form-control-file" name="file">
                  </div>
                  <div class="col text-center">
                    <button class="btn btn-primary mb-5" name="submit">SUBMIT</button>
                  </div>
              </form>

            </div>
          </div>
        
        
        </div>
      

    
    
    
    
    <footer>
                  <div class="row justify-content-center mt-5">
                    <div class="col-md-12">
                        <p id="name">Copyright &copy; 2020</p>
                        <p id="name">Josue Castillo</p>
                  </div>
              </footer>
              
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>
  </body>
</html>