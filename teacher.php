<?php
//necessary
require_once "includes/db-connect.php";
require_once "includes/functions.php"; 

$_COOKIE['show'] = FALSE;
//var_dump($_COOKIE['user']);

sec_session_start();

//Note an SSL connection is required to prevent network sniffing
if(isset($_SESSION['username']))
	$user = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $_SESSION['username']); //XSS Security

	
if(isUserLoggedIn($username,$conn)=="true")
	header('Location: ./membersArea.php');


//Error handling
$error=null;
if(isset($_GET["error"])){
	if(!is_numeric($_GET["error"])){
		$error="Dont not edit the URL GET var, thanks.";
	}else{
		$error = errorLogging($_GET["error"]);
	}
}

if(isset($_REQUEST['submit']))
{
	try
	{
			//textbox name "txt_name"
			
        $image_file	= $_FILES["file"]["name"];
        $name	= $_POST['filename'];
        $image_desc = $_POST['filedesc'];
        $image_title= $_POST['filetitle'];
		$type		= $_FILES["file"]["type"];	//file name "txt_file"	
		$size		= $_FILES["file"]["size"];
        $temp		= $_FILES["file"]["tmp_name"];

		
		$path="upload/".$image_file; //set upload folder path
		
		if(empty($name)){
			$errorMsg="Please Enter Name";
		}
		else if(empty($image_file)){
			$errorMsg="Please Select Image";
		}
		else if($type=="image/jpg" || $type=='image/jpeg' || $type=='image/png' || $type=='image/gif') //check file extension
		{	
			if(!file_exists($path)) //check file not exist in your upload folder path
			{
				if($size < 5000000) //check file size 5MB
				{
					move_uploaded_file($temp, "upload/" .$image_file); //move upload file temperory directory to your upload folder
				}
				else
				{
					$errorMsg="Your File To large Please Upload 5MB Size"; //error message file size not large than 5MB
				}
			}
			else
			{	
				$errorMsg="File Already Exists...Check Upload Folder"; //error message file not exists your upload folder path
			}
		}
		else
		{
			$errorMsg="Upload JPG , JPEG , PNG & GIF File Formate.....CHECK FILE EXTENSION"; //error message file extension
		}
		
		if(!isset($errorMsg))
		{
          
            
            $exec = $conn->prepare('SELECT * FROM gallery');
            $exec->execute();
            
            
            $rowCount = $exec->rowCount();
              $setImageOrder = $_COOKIE['user'];
                $sql = "INSERT INTO gallery(titleGallery,descGallery,imgFullNameGallery, orderGallery) VALUES('$image_title','$image_desc','$image_file', $setImageOrder)";
                $conn->exec($sql);

                
                $insertMsg="File Upload Successfully........"; //execute query success message
                $_COOKIE['show'] = TRUE;
                echo $_COOKIE['show'];
               
                
		}
		
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}


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
<html>   
  <head>
    <meta charset="utf-8">
    <title>My Portfolio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900|Cormorant+Garamond:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/gallerystyles.css">
  <style>
      img#x {
  position: absolute;
  top: 105px;
  left: 201px;
}

.cases-links {
  overflow: hidden;
  margin-bottom: 20px;
}

.cases-links h2 {
  font-family: Catamaran;
  font-size: 28px;
  font-weight: 600;
  color: #111;
  text-transform: uppercase;
}

.cases-links .cases-link {
  float: left;
  width: 230px;
  height: 230px;
  margin: 20px 10px 0px;
  background-color: #e3e3e3;
}

.cases-links .cases-link p {
  padding-top: 45%;
  font-family: Catamaran;
  font-size: 24px;
  font-weight: 600;
  color: #111;
  text-align: center;
  text-transform: uppercase;
}

  </style>
</head>
  <body>
  
  <header>
    <p href="index.php" class="header-brand"><?php echo ucfirst(decrypt($user['username'])); ?></p>
    <nav>
      <ul>
        <li><a  id="active" href="./teacherhome.php">Home</a></li>
        <li> <a  href="./teachergallery.php">Gallery</a></li>
        <li> <a href="./teacheraccount.php">Account</a></li>
      </ul>
      <a href="./logout.php" class="header-cases" id="log">Logout</a>
    </nav>
  </header>
    <main>

      <section class="gallery-links">
          
        <div class="wrapper">
         

          <div class="gallery-container">
          
                                    
                                        
          <?php



                                    

                                    $stmt = $conn->prepare("SELECT * FROM gallery ");
                                    $stmt->execute();
                                    $rowCount = $stmt->rowCount();
                                    if( $rowCount > 0){
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <a href="?delete_id=<?php echo $row['idGallery']; ?>">
                                                  <div style="background-image: url(upload/<?php echo $row["imgFullNameGallery"]?>);"></div>
                                                  <h3><?php echo $row["titleGallery"]?></h3>
                                                  <p><?php echo $row["descGallery"] ?></p>
                                                  
                                                
                                                </a>
                                            <?php
                                            }
                                            ?>
                                     <?php       
                                    }
                                    
                                    else{
                                     ?>     
                                      <a href="case1.html">
                                        <div class="cases-link">
                                            <img height="200px" width="200px" src="assets/grey.jpeg">
                                          <p>Image 1</p>
                                        </div>
                                      </a>
                                      <a href="case1.html">
                                        <div class="cases-link">
                                        <img height="200px" width="200px" src="assets/grey.jpeg">
                                          <p>Image 2</p>
                                        </div>
                                      </a>
                                      <a href="case1.html">
                                        <div class="cases-link">
                                        <img height="200px" width="200px" src="assets/grey.jpeg">
                                          <p>Image 3</p>
                                        </div>
                                      </a>
                                      <a href="case1.html">
                                        <div class="cases-link">
                                        <img height="200px" width="200px" src="assets/grey.jpeg">
                                          <p>Image 4</p>
                                        </div>
                                      </a>
                                      <a href="case1.html">
                                        <div class="cases-link">
                                        <img height="200px" width="200px" src="assets/grey.jpeg">
                                          <p>Image 5</p>
                                        </div>
                                      </a>
                                    <?php
                                    }
                                    ?>
                                    
                                   
                                   

          <?php
          
            echo '<div class="gallery-upload">
              <h2>Upload</h2>
              <form method="post" enctype="multipart/form-data">
                <input type="text" name="filename" placeholder="File name...">
                <input type="text" name="filetitle" placeholder="Image title...">
                <input type="text" name="filedesc" placeholder="Image description...">
                <input type="file" name="file">
                <button type="submit" name="submit">UPLOAD</button>
              </form>
            </div>';
          
          ?>

        </div>
      </section>

    </main>
  </body>
</html>