<?php 
    require_once('mysql_config.php');
    createDataBase();
    createTableUsers();
    initDataUsers();
    $DB = DB;
    echo "
        <script>
            var check = alert('Khởi tạo DATABASE thành công');
            document.location = '/final';
        </script>
    ";
?>