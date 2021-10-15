<?php 
    require_once('mysql_config.php');
    createDataBase();
    createTableUsers();
    initDataUsers();
    echo "
        <script>
            let check = alert('Khởi tạo DATABASE thành công');
            document.location = '/final';
        </script>
    ";
?>