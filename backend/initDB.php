<?php 
    require_once('mysql_config.php');
    createDataBase(); //tao bang
    createTableUsers();
    initDataUsers();
    createTableUserActive();
    initDataUserActive();
    createTableConversation();
    createTableMessages();
    createTableParticipatants();
    initDataConversation();
    initDataMessages();
    initDataParticipatants();
    createTableRelationship();
    initDataRelationshipTable();
    echo "
        <script>
            var check = alert('Khởi tạo DATABASE thành công');
            document.location = '../';
        </script>
    ";
?>
1