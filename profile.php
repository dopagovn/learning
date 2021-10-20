<?php
        require './backend/web_config.php';
        load_top();
        load_footer();

?>
<link rel="stylesheet" href="./frontend/profile.css">

<div class="container-profile">
        <form class="f-title">
                <h1> Thông tin cá nhân </h1>
                <div class="form-text"><lable>Tên người dùng</lable><br><input type="text" disabled>                       
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-name" aria-expanded="false" aria-controls="collapseExample">
                                Chỉnh sửa</button>                     
                        <div class="collapse" id="edit-name">
                                <div class="card card-body">
                                        <p> 
                                                <lable>Tên Người dùng mới<lable>
                                                <br><input type ="text"></br>
                                                <br><button class="save">Lưu</button></br>
                                        </p>
                                </div>
                        </div>
                </div>

                <div class="form-text"><lable>Mật khẩu</lable><br><input type="text" disabled>                 
                
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-pass" aria-expanded="false" aria-controls="collapseExample">
                        Chỉnh sửa
                        </button>
                
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
                        </div>

                        <div class="form-text"><lable>Số điện thoại</lable><br><input type="text" disabled>                                                    
                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-phone" aria-expanded="false" aria-controls="collapseExample">
                                Chỉnh sửa</button>
                               
                                <div class="collapse" id="edit-phone">
                                        <div class="card card-body">
                                                <p> 
                                                        <lable>Thay đổi số điện thoại (gồm 10 chữ số)<lable><input type ="text">
                                                        <br><button class="save">Lưu</button></br>
                                                </p>
                                        </div>
                                </div>
                        </div>

                        <div class="form-text"><lable>Email</lable><br><input type="text" disabled> 
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-em" aria-expanded="false" aria-controls="collapseExample">
                                Chỉnh sửa</button>
                               
                                <div class="collapse" id="edit-em">
                                        <div class="card card-body">
                                                <p> 
                                                        <lable>Thay đổi E-mail (*@gmail.com)<lable>
                                                        <br><input type ="text"></br>
                                                        <br><button class="save">Lưu</button></br>
                                                </p>
                                        </div>
                                </div>
                        </div>

                        <div class="form-text"><lable>Ngày sinh</lable><br><input type="text" disabled> 
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-born" aria-expanded="false" aria-controls="collapseExample">
                                Chỉnh sửa</button>
                               
                                <div class="collapse" id="edit-born">
                                        <div class="card card-body">
                                                <p> 
                                                        <lable>Thay đổi ngày sinh (dd/mm/yyyy)<lable>
                                                                <input type ="text">
                                                        <br><button class="save">Lưu</button></br>
                                                </p>
                                        </div>
                                </div>
                        </div>

                        <div class="form-text"><lable>Giới tính</lable><br><input type="text" disabled> 
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-sex" aria-expanded="false" aria-controls="collapseExample">
                                Chỉnh sửa</button>
                               
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
                        </div>
         </form> 
</div>



