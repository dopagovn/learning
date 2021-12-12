<?php 
    require_once("./backend/lib-relations.php");
    require_once("./backend/web_config.php");
?>

<?php 
    load_top(); 
    ch_title("Tìm bạn bè")
?>

<script src="./frontend/friends.js"></script>
<link rel="stylesheet" href="./frontend/chat.css">

<link rel="stylesheet" href="./frontend/friends.css">
<body>
        <h1 align="center">Tìm kiếm</h1>
    
        <form align="center" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <input name="txtSearch" id="input-data" class="input-data form-control" type="text" placeholder="Nhập Email cần tìm kiếm">
        </form>
    
       <table align="center" class="table table-hover table-bordered ">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên</th>
                <th scope="col">Họ</th>
                <th scope="col">Giới tính</th>
                </tr>
            </thead>
            <tbody class="list">
                <?php 
                    $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
                    $sql = "SELECT * FROM users";
                    $query = mysqli_query($connect, $sql);
                    $num = mysqli_num_rows($query);

                    if($num > 0){
                        while($row = mysqli_fetch_array($query)){

                            if($row['Gender'] == 1)
                                $row['Gender'] = "Nam";
                                else{
                                    $row['Gender'] = "Nữ";
                                }
                        
                ?>
                <!-- <tr>
                    <th scope="row"><?php echo $row['id'];?></th>
                    <td><?php echo $row['FirstName'];?></td>
                    <td><?php echo $row['LastName'];?></td>
                    <td><?php echo $row['Gender'];?></td>
                    </tr>
                <tr> -->
                <?php 
                        }
                    }
                ?>
            </tbody>
        </table>


    
<?php load_footer(); ?>