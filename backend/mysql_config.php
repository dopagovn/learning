<?php

        //Cấu hình database:
        $hostname = 'localhost'; // Thêm hostname
        $user     = 'root'; // thêm user
        $pass     = 'ilikeMinhChi'; // thêm pass
        $db       = 'chatweb'; // thêm Database name
        

        //Kết nối CSDL
        $conn = mysqli_connect($hostname, $user , $pass , $db);
        //Thiết kế bảng mã kết nối
        mysqli_query($conn, "SET NAME 'UTF8'");
        //Kiểm tra kết nối
        // if(!$conn){
        //         die("Kết nối thất bại! ");
        // }
        // echo    "Kết nối thành công!";
?>
