<?php

        //Cấu hình database:

        $hostname = 'localhost'; // Thêm hostname
        $user     = 'root'; // thêm user
        $pass     = ''; // thêm pass
        $db       = 'chatweb';
        

        //Kết nối CSDL
        
        $conn = mysqli_connect($hostname, $user , $pass, $db);

        //Thiết kế bảng mã kết nối

        mysqli_query($conn, "SET NAME 'UTF8'");

        if($conn->connect_error){
                die("Không thể kết nối: " . $conn->connect_error);
        }
        
        $sql = "CREATE TABLE users(
                id int PRIMARY KEY AUTO_INCREMENT,
            FirstName VARCHAR(100) charset utf8,
            LastName VARCHAR(100) charset utf8,
            BirthDay date,
            Gender int, -- 1 nam 0 nữ
            Email varchar(100),
            Password varchar(100),
            Phone varchar(13),
            TimeCreated DateTime
        )";
        
        mysqli_query($conn, $sql);


        
?>
