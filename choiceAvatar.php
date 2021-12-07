<?php
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }

    require_once('backend/mysql_config.php');
    $name = getDataByQuery("SELECT * FROM users WHERE id = {$_SESSION['idUser']}");
    $name = $name[0]['LastName'] . ' ' . $name[0]['FirstName'];

    if(isset($_POST['choiceAvatar'])){
        if(!empty($_FILES['avatar']['name'])){
            $imageName = $_FILES['avatar']['name'];
            $imageTmp = $_FILES['avatar']['tmp_name'];
            $imageExt = explode('.',$imageName);
            $imageExt = $imageExt[array_key_last($imageExt)];
            $imageExt = strtolower($imageExt);
            $allowExt = ['','png','jpeg','jpg','ico'];

            $result = array_search($imageExt, $allowExt);
            if($result){
                $dir = 'backend/avatar/';
                $newFileName = $_SESSION['idUser'] . '.' . $imageExt;
                move_uploaded_file($imageTmp, $dir . $newFileName);
            }        
        }
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="./frontend/choiceAvatar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    </head>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <div id="bg-banhchung">
                <img src="frontend/img/background.jpeg">
            </div>
            <div id="avatar">
                <img id="avatar__img" src="./frontend/img/avatar-default-icon.png" />
                <button type="button" class="btn-camera">
                    <i class="fas fa-camera"></i>
                </button>
                <input type="file" accept="image/*" id="select-file" name="avatar" style="display: none;">  
            </div>
            <div id="name">
                <p><?php echo $name; ?></p>
            </div>
            <div id="start">
                <input type="submit" name="choiceAvatar" value="Bắt đầu">
            </div>
        </form>         
        <script src="./frontend/choiceAvatar.js"></script>
    </body>
</html>




