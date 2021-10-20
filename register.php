<?php
    if(isset($_POST['register'])){
        // echo $_POST['firstName'] . '<br/>';
        // echo $_POST['lastName'] . '<br/>';
        // echo $_POST['birthDay'] . '<br/>';
        // echo $_POST['gender'] . '<br/>';
        // echo $_POST['email'] . '<br/>';
        // echo $_POST['password'] . '<br/>';
        // echo $_POST['repeatPassword'] . '<br/>';
        // echo $_POST['phone'] . '<br/>';
        // echo $_POST['agreePolicy'] . '<br/>';

        $validations = [];
        if(empty($_POST['lastName'])){
            $validations['lastNameIsEmpty'] = true;
        }
        if(empty($_POST['firstName'])){
            $validations['firstNameIsEmpty'] = true;
        }
        if(empty($_POST['email'])){
            $validations['emailIsEmpty'] = true;
        }
        else if(!preg_match('/^[\w]+@[a-zA-Z0-9]{3,5}\.[a-zA-Z0-9]{2,5}(\.[a-zA-Z0-9]{2,5})?$/',$_POST['email'])){
            $validations['emailInvalid'] = true;
        }
        if(empty($_POST['password'])){
            $validations['passwordIsEmpty'] = true;
        }
        else if(empty($_POST['repeatPassword'])){
            $validations['repeatPasswordIsEmpty'] = true;
        }
        else if($_POST['repeatPassword'] != $_POST['password']){
            $validations['repeatPasswordNotEqualPassword'] = true;
        }

        if(!empty($_POST['phone']) && !preg_match('/^[0-9]{10,13}$/', $_POST['phone'])){
            $validations['phoneInValid'] = true;
        }
        if(!isset($_POST['agreePolicy'])){
            $validations['notAgreePolicy'] = true;
        }

        require_once('backend/mysql_config.php');  
        $usersTable = getDataByQuery("SELECT * FROM users WHERE Email = '{$_POST['email']}'");
        if(count($usersTable) > 0){
            $validations['emailIsExisted'] = true;
        }

        if(count($validations) == 0){
            require_once('backend/mail_config/mail_config.php');         
            $activeCode = uniqid();
            sendMail($_POST['email'], 'Mã kích hoạt của bạn là: ' . $activeCode);

            // save DB
            $password = md5($_POST['password']);
            $birthDay = explode('/' ,$_POST['birthDay']);
            $birthDay = array_reverse($birthDay);
            $birthDay = implode('/', $birthDay);

            $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
            $query = "INSERT INTO Users(FirstName, LastName, BirthDay, Gender, Email, Password, Phone, TimeCreated) 
            VALUES(N'{$_POST['firstName']}', N'{$_POST['lastName']}', '{$birthDay}', 
            {$_POST['gender']}, '{$_POST['email']}', '{$password}', '{$_POST['phone']}', CURRENT_TIMESTAMP())";
            mysqli_query($connect, $query);
            
            $query = "SELECT MAX(id) as MaxId FROM users";
            $result = mysqli_query($connect, $query);
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $maxId = $data[0]['MaxId'];
            $query = "INSERT INTO UserActive VALUES($maxId, '{$activeCode}')";
            $result = mysqli_query($connect, $query);

            mysqli_close($connect);
        }        
    }
    function getPreviousValue($name){
        if(!isset($_POST['register'])){
            echo '';
        }
        else{
            echo $_POST[$name];
        }
    }
?>
<?php
    require('./backend/web_config.php');
    load_top();
?>
<div class="container">
    <link rel="stylesheet" type="text/css" href="./frontend/registerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <p id="login-title"><b>Đăng ký</b></p>
    <form class="register" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off">
        <div class="register__row">
            <div>
                <p class="title">Họ</p>
                <input class="textbox" type="text" name="lastName" value="<?php getPreviousValue('lastName'); ?>">
                <?php 
                    if(isset($validations['lastNameIsEmpty'])){
                        echo '<p class="error">Hãy nhập họ</p>';
                    }
                ?>
            </div>
            <div>
                <p class="title">Tên</p>
                <input class="textbox" type="text" name="firstName" value="<?php getPreviousValue('firstName'); ?>">
                <?php 
                    if(isset($validations['firstNameIsEmpty'])){
                        echo '<p class="error">Hãy nhập tên</p>';
                    }
                ?>
            </div>
        </div>
        <div class="register__row">
            <div>
                <p class="title">Ngày sinh</p>
                <div class="birthday">
                    <input class="textbox" type="text" value="<?php echo (isset($_POST['birthDay'])) ? $_POST['birthDay'] : '1/1/1900';?>" name="birthDay">
                    <input class="textbox" type="text" value="1/1/2000">
                    <p class="birthday__calendar"><i class="far fa-calendar"></i></p> 
                    <div class="date-picker" style="display: none;">
                        <div class="date-picker__choice">
                            <p class="left-arrow">
                                <i class="fas fa-chevron-left"></i>
                            </p>
                            <div class="month-year">
                                <p>Tháng <span>1</span></p>,
                                <p style="margin-left: 5px;">2000</p>
                            </div>
                            <p class="right-arrow">
                                <i class="fas fa-chevron-left" style="transform: rotateZ(180deg);"></i>
                            </p>
                        </div>
                        <div class="date-picker__main">
                            <div class="days">
                                <p>Sun</p>
                                <p>Mon</p>
                                <p>Tue</p>
                                <p>Wed</p>
                                <p>Thu</p>
                                <p>Fri</p>
                                <p>Sat</p>
                            </div>
                            <div class="dates">                               
                            </div>
                            <div class="months">                              
                            </div>
                            <div class="years">                               
                            </div>
                        </div>
                    </div>                      
                </div>              
            </div>
            <div>
                <p class="title">Giới tính</p>
                <div class="gender">
                    <p>
                        <input type="radio" name="gender" value="1" checked> <span>Nam</span>
                    </p>
                    <p>
                        <input type="radio" name="gender" value="0"> <span>Nữ</span>
                    </p>                    
                </div>
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <p class="title">Email</p>
                <input class="textbox" type="text" name="email" value="<?php getPreviousValue('email'); ?>">
                <?php 
                    if(isset($validations['emailIsEmpty'])){
                        echo '<p class="error">Hãy nhập email</p>';
                    }
                    else if(isset($validations['emailInvalid'])){
                        echo '<p class="error">Email không hợp lệ</p>';
                    }
                    else if(isset($validations['emailIsExisted'])){
                        echo '<p class="error">Email đã tồn tại</p>';
                    }
                ?>
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <p class="title">Mật khẩu</p>
                <input class="textbox" type="password" name="password" value="<?php getPreviousValue('password'); ?>">
                <?php 
                    if(isset($validations['passwordIsEmpty'])){
                        echo '<p class="error">Hãy nhập mật khẩu</p>';
                    }
                ?>
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <p class="title">Nhập lại mật khẩu</p>
                <input class="textbox" type="password" name="repeatPassword" value="<?php getPreviousValue('repeatPassword'); ?>">
                <?php 
                    if(isset($validations['repeatPasswordIsEmpty'])){
                        echo '<p class="error">Hãy nhập lại mật khẩu</p>';
                    }
                    else if(isset($validations['repeatPasswordNotEqualPassword'])){
                        echo '<p class="error">Mật khẩu không trùng khớp</p>';
                    }
                ?>
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <p class="title">Số điện thoại</p>
                <input class="textbox" type="text" name="phone" value="<?php getPreviousValue('phone'); ?>">
                <?php 
                    if(isset($validations['phoneInValid'])){
                        echo '<p class="error">Số điện thoại từ 10->13 chữ số</p>';
                    }
                ?>
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <input class="cb-policy" type="checkbox" name="agreePolicy" value="1" <?php echo (isset($_POST['agreePolicy'])) ? 'checked' : '';?> ><span> Tôi đồng ý với <a>điều khoản</a> & <a>chính sách</a></span>
            </div>
        </div>
        <div class="register__row register__row--1">
            <div>
                <button type="submit" class="agree" name="register">Đăng ký</button>
                <?php
                    if(isset($validations['notAgreePolicy'])){
                        echo '<span class="error">Bạn chưa đồng ý với điều khoản sử dụng</span>';
                    }
                ?>
            </div>
        </div>
    </form>
    <script src="./frontend/registerScript.js"></script>   
</div>
<?php load_footer(); ?>