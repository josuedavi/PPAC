<?php
$servername = "localhost";
$username = "username";
$password = "Seme_olvido1";
$db = "Project3";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
   // echo "success";
    }
catch(PDOException $e)
    {
    // echo "no success";
    }
    
?> 