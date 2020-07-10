<?php

        $host="localhost"; 
        $root="username"; 
        $root_password="Seme_olvido1"; 

        $db="Project3"; 

        $dbh = new PDO("mysql:host=$host", $root, $root_password);
        $dbh->exec("CREATE DATABASE `$db`;");

        $conn = new PDO("mysql:host=$host;dbname=$db", $root, $root_password);
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->exec("CREATE TABLE `login_attempts` (
            `field` int(11) NOT NULL,
            `uid` int(255) NOT NULL,
            `time` varchar(30) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


        $conn->exec("CREATE TABLE `reset_tokens` (
            `uid` int(11) NOT NULL,
            `token` varchar(255) NOT NULL,
            `tokenCreatedTimestamp` varchar(255) NOT NULL,
            `tokenExpired` int(1) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

        $conn->exec("CREATE TABLE `users` (
            `uid` int(11) NOT NULL,
            `username` varchar(255) NOT NULL,
            `password` char(128) NOT NULL,
            `email` varchar(255) NOT NULL,
            `dob` varchar(255) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

        $conn->exec("ALTER TABLE `login_attempts`
        ADD PRIMARY KEY (`field`);");

        $conn->exec("ALTER TABLE `reset_tokens`
        ADD PRIMARY KEY (`uid`),
        ADD UNIQUE KEY `uid` (`uid`);");

        $conn->exec("ALTER TABLE `users`
        ADD PRIMARY KEY (`uid`);");

        $conn->exec("ALTER TABLE `login_attempts`
        MODIFY `field` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;");     

        $conn->exec("ALTER TABLE `users`
        MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
        COMMIT;");    

        $conn->exec("CREATE TABLE `gallery` (
                      `idGallery` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      `titleGallery` longtext,
                      `descGallery` longtext,
                      `imgFullNameGallery` varchar(200),
                      `orderGallery` longtext
                    ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;");        
      header('Location: ./index.php');
      