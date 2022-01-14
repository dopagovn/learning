<?php 
        session_start();
        if(!isset($_SESSION['idUser'])){
                header('location: index.php');
        }
        else{
                require_once('backend/mysql_config.php');
                $idUser = $_SESSION['idUser'];
                // get name user
                $query = "SELECT * FROM users WHERE id = $idUser";
                $userTable = getDataByQuery($query);
                // if($userTable[0]['Gender'] == 1){
                //         $userTable[0]['Gender'] = 'Nam';
                // }else {
                //         $userTable[0]['Gender'] = 'Nữ';
                // }
                
                if(isset($_POST['update'])){
                        $idUser = $_SESSION['idUser'];
                        require_once('backend/mysql_config.php');
                        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
                        $newPassWord = md5($_POST['Password']);
                        $query = "UPDATE `users` SET FirstName = '$_POST[FirstName]', LastName = '$_POST[LastName]', Gender = '$_POST[gender]', Phone = '$_POST[Phone]', Email = '$_POST[Email]', BirthDay = '$_POST[BirthDay]', `Password` = '$newPassWord' WHERE id = $idUser";
                        

                        $result = mysqli_query($connect, $query);
                        if($result){
                                echo '<script type="text/javascript">alert("Đã update thành công")</script>';
                        }else {
                                echo '<script type="text/javascript">alert("Update thất bại")</script>';
                        }
                }
        }
?>
<?php 
    require('./backend/web_config.php');
    load_top();
?>
<link rel='stylesheet' href='./frontend/profile.css'>

<div class='container'>
    <div class="col-md-3">
        <h3 align="center">Thông tin tài khoản</h3>

        <div class="form-control">
            <span>Họ và tên</span>
            <input class="form-control" type="text"
                placeholder="<?php echo $userTable[0]['FirstName'] . ' ' . $userTable[0]['LastName'] ?>"
                aria-label="Disabled input example" disabled>
        </div>
        <div class="form-control">
            <span>Email</span>
            <input class="form-control" type="text" placeholder="<?php echo $userTable[0]['Email']?>"
                aria-label="Disabled input example" disabled>
        </div>
        <div class="form-control">
            <span>Số điện thoại</span>
            <input class="form-control" type="text" placeholder="<?php echo $userTable[0]['Phone']?>"
                aria-label="Disabled input example" disabled>
        </div>
        <div class="form-control">
            <span>Giới tính</span>
            <input class="form-control" type="text" placeholder="<?php
             if($userTable[0]['Gender'] == 0){
                echo 'Nữ';
                }else{
                echo 'Nam';
                }  
            ?>" aria-label="Disabled input example" disabled>
        </div>
        <div class="form-control">
            <span>Ngày tháng năm sinh</span>
            <input class="form-control" type="text" placeholder="<?php echo $userTable[0]['BirthDay']?>"
                aria-label="Disabled input example" disabled>
        </div><br />
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Chỉnh sửa thông tin
        </button>
    </div>
    <!-- Modal Edit Profile -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa thông tin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-control">
                            <span>Họ và tên</span>
                            <input class="form-control" name="FirstName" type="text" placeholder="Nhập tên"
                                aria-label="Disabled input example"><br />
                            <input class="form-control" name="LastName" type="text" placeholder="Nhập họ"
                                aria-label="Disabled input example"><br />
                        </div>
                        <div class="form-control">
                            <span>Email</span>
                            <input class="form-control" name="Email" type="text"
                                placeholder="<?php echo $userTable[0]['Email']?>" aria-label="Disabled input example">
                            <br />
                        </div>
                        <div class="form-control">
                            <span>Số điện thoại</span>
                            <input class="form-control" name="Phone" type="text"
                                placeholder="<?php echo $userTable[0]['Phone']?>"
                                aria-label="Disabled input example"><br />
                        </div>
                        <div class="form-control">
                            <span>Giới tính</span>
                            <p>

                                <input type="radio" name="gender" value="1" <?php
                                     if($userTable[0]['Gender'] == 1){
                                        echo 'checked';
                                     }   
                                ?>>
                                <span>Nam</span>
                            </p>
                            <p>
                                <input type="radio" name="gender" value="0" <?php
                                     if($userTable[0]['Gender'] == 0){
                                        echo 'checked';
                                     }   
                                ?>>
                                <span>Nữ</span>
                            </p>
                        </div>
                        <div class="form-control">
                            <span>Ngày tháng năm sinh</span>
                            <input class="form-control" name="BirthDay" type="text"
                                placeholder="<?php echo $userTable[0]['BirthDay']?>"
                                aria-label="Disabled input example"><br />
                        </div>
                        <div class="form-control">
                            <span>Mật khẩu</span>
                            <input class="form-control" name="Password" type="text" placeholder="Nhập mật khẩu mới"
                                aria-label="Disabled input example"><br />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" name="update" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php load_footer(); ?>