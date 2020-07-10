<?php
//Credit to https://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL for this login handing structure (Hihgly Modified)
include_once 'db-connect.php';
include_once 'functions.php';
include_once '../changepassword.php';



if (TRUE) {

     generateResetToken($conn, $_COOKIE['user']);
    $token = getResetToken($_COOKIE['user'], $conn);//working

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
 
    echo "username: " .$username;
    $newPassword = $_POST['password']; //working
    echo "password: ".$newPassword;
    $passwordConfirm = $_POST['passwordConfirm']; //working
    echo "password confirm: ".$passwordConfirm;
   
    echo "email: " .$email;
   
    echo "date of birth: ".$dob;
    echo "<br>";
      
    if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) ==0){
        header("location: ../changepassword.php");
    } else if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) == 5){
        // register failed 
        header('Location: ../changepassword.php?error=5');
    } else if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) == 6){
        // register failed 
        header('Location: ../changepassword.php?error=6');
    }else if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) == 7){
        // register failed 
        header('Location: ../changepassword.php?error=7');
    }else if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) == 8){
        // register failed 
        header('Location: ../changepassword.php?error=8');
    }else if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) == 13){
        // register failed 
        header('Location: ../changepassword.php?error=13');
    } else if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) == 14){
        // register failed 
        header('Location: ../changepassword.php?error=14');
    }else if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) == 15){
        // register failed 
        header('Location: ../changepassword.php?error=15');
    }  else if(updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn) == 16){
        // register failed 
        header('Location: ../changepassword.php?error=16');
    } else{
    echo 'Invalid Request';
    //echo updatePassword($username, $email, $dob, $newPassword, $passwordConfirm, $token, $conn);
    }
}
?>