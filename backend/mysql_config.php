<?php

        //Cấu hình database:
        $hostname = ''; // Thêm hostname
        $user     = ''; // thêm user
        $pass     = ''; // thêm pass
        $db       = ''; // thêm Database name
        

        //Kết nối CSDL
        $conn = mysqli_connect($hostname, $user , $pass , $db);
        //Thiết kế bảng mã kết nối
        mysqli_connect($conn, "SET NAMES 'utf8'");

        
?>
