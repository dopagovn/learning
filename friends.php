<?php 
    require_once("./backend/lib-relations.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bạn bè</title>
    <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }
    </style>
</head>
<body>
    <h1>Tìm kiếm</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <input name="txtSearch" type="text" placeholder="Nhập Email cần tìm kiếm">
    <button name="btnSearch" type="submit">Tìm kiếm</button>
    </form>

    <?php 
    if(isset($_POST['btnSearch'])){
        $txtSearch = $_POST['txtSearch'];
        finduser($txtSearch);
    }
    ?>
    
</body>
</html>