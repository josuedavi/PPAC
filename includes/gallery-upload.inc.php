<?php

require_once "db-connect.php";


$_COOKIE['show'] = FALSE;


if(isset($_REQUEST['submit']))
{
	try
	{
	    
        function imageResize($imageResourceId,$width,$height) {
        
        
            $targetWidth =800;
            $targetHeight =600;
        
        
            $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
            imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
        
        
            return $targetLayer;
        }


        $file = $_FILES["file"]["tmp_name"];
        $image_file	= $_FILES["file"]["name"];
       $name	= $_POST['filename'];
       $image_desc = $_POST['filedesc'];
       $image_title= $_POST['filetitle'];
       $type = $_FILES["file"]["type"];	//file name "txt_file"	
       $size = $_FILES["file"]["size"];

        
        $sourceProperties = getimagesize($file);
        $fileNewName = time();
        $folderPath = "upload/";
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $imageType = $sourceProperties[2];

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
		
    
    
        switch ($imageType) {


            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($file);
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagepng($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;


            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($file);
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagegif($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;


            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($file);
                $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                imagejpeg($targetLayer,$folderPath. $fileNewName. "_thump.". $ext);
                break;


            default:
                echo "Invalid Image type.";
                exit;
                break;
                }
        
        
              $img =  move_uploaded_file($file, $folderPath. $fileNewName. ".". $ext);
        
        
           // echo $fileNewName."_resize.jpg";
        
           // echo $fileNewName."_thump.".$ext;
 

              $dbFile = $folderPath.$fileNewName."_thump.".$ext;                   
         
    if(!isset($errorMsg))
		{
            $exec = $conn->prepare('SELECT * FROM gallery');
            $exec->execute();
            
            
            $rowCount = $exec->rowCount();
              $setImageOrder = $_COOKIE['user'];
              $sql = "INSERT INTO gallery(titleGallery,descGallery,imgFullNameGallery, orderGallery) VALUES('$image_title','$image_desc','$dbFile', $setImageOrder)";
                $conn->exec($sql);

                
                $insertMsg="File Upload Successfully........"; //execute query success message
                $_COOKIE['show'] = TRUE;
                //echo $_COOKIE['show'];
                header("location: ../gallery.php");
               
		}    

		
		
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
?>

?>

