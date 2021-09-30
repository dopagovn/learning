<?php
        $username = $_POST['username'];
        $password = $_POST['password'];

        //Cấu hình database:
        $hostname = ''; // Thêm hostname
        $user     = ''; // thêm user
        $pass     = ''; // thêm pass
        $db       = ''; // thêm Database name
        

        //Kết nối CSDL
        $conn = mysqli_connect($hostname, $user , $pass , $db);



        
?>
