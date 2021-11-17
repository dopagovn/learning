<?php
        require './backend/web_config.php';
        load_top();
        load_footer();

?>
<link href="./frontend/profile.css" rel="stylesheet">

<div class="container-profile">
        <form class="f-title">
                <i><h1>Thông tin cá nhân</h1></i>
                <br /> <br /> <br />
                <p>Tên người dùng</p>
                <input type="text" disabled>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-name" aria-expanded="false" aria-controls="collapseExample">Chỉnh sửa</button>
                <div class="collapse" id="edit-name">
                                <div class="card card-body">
                                        <p> 
                                                <lable>Tên Người dùng mới<lable>
                                                <br><input type ="text"></br>
                                                <br><button class="save">Lưu</button></br>
                                        </p>
                                </div>
                </div>

                <p>Mật khẩu</p>
                <input type="text" disabled> 
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-pass" aria-expanded="false" aria-controls="collapseExample">Chỉnh sửa</button>
                <div class="collapse" id="edit-pass">
                                <div class="card card-body">
                                        <p> 
                                                <lable>Mật khẩu cũ<lable><br><input type ="text"></br>
                                                <lable>Mật khẩu mới<lable><br><input type ="text"></br>
                                                <lable>Nhập lại<lable><br><input type ="text"></br>
                                                <br><button class="save">Lưu</button></br>
                                        </p>
                                </div>
                </div>

                <p>Số điện thoại</p>
                <input type = "text" disabled> 
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-phone" aria-expanded="false" aria-controls="collapseExample">Chỉnh sửa</button>
                <div class="collapse" id="edit-phone">
                                        <div class="card card-body">
                                                <p> 
                                                        <lable>Thay đổi số điện thoại (gồm 10 chữ số)<lable><input type ="text">
                                                        <br><button class="save">Lưu</button></br>
                                                </p>
                                        </div>
                                </div>

                <p>Ngày sinh</p>
                <input type = "text" disabled> 
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-born" aria-expanded="false" aria-controls="collapseExample">Chỉnh sửa</button>
                <div class="collapse" id="edit-born">
                                        <div class="card card-body">
                                                <p> 
                                                        <lable>Thay đổi ngày sinh (dd/mm/yyyy)<lable>
                                                                <input type ="text">
                                                        <br><button class="save">Lưu</button></br>
                                                </p>
                                        </div>
                                </div>

                <p>Giới tính</p>
                <input type = "text" disabled> 
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-sex" aria-expanded="false" aria-controls="collapseExample">Chỉnh sửa</button>
                <div class="collapse" id="edit-sex">
                                        <div class="card card-body">
                                                <p> 
                                                        <lable>Thay đổi giới tính<lable>   
                                                                <div class="gender">
                                                                <input type="radio" name="gender" value="male" checked> <span>Nam</span>
                                                                <input type="radio" name="gender" value="female"> <span>Nữ</span>
                                                                <br><button class="save">Lưu</button>
                                                        </br></div>
                                                </p>
                                        </div>
                                </div>

                <p>G-mail</p>
                <input type = "text" disabled> 
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-gmail" aria-expanded="false" aria-controls="collapseExample">Chỉnh sửa</button>
                <div class="collapse" id="edit-gmail">
                                        <div class="card card-body">
                                                <p> 
                                                        <lable>Thay đổi E-mail (*@gmail.com)<lable>
                                                        <br><input type ="text"></br>
                                                        <br><button class="save">Lưu</button></br>
                                                </p>
                                        </div>
                                </div>
         </form> 
</div>



