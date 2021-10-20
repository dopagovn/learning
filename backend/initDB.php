<?php 
    require_once('mysql_config.php');
    createDataBase();
    createTableUsers();
    initDataUsers();
    createTableUserActive();
    initDataUserActive();
    echo "
        <script>
            var check = alert('Khởi tạo DATABASE thành công');
            document.location = '../';
        </script>
    ";
?>
1