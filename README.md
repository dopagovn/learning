# Dự án Webchat
***

####  1. Hướng dẫn clone dự án về máy: 

> git clone https://github.com/dopagovn/learning.git


 Cập nhật code thường xuyên dựa theo commit trong branch: **"master"**

 1. Chuyển sang branch **"master"** bằng cách nhấn vào biểu tượng branch ở góc trái dưới màn hình Visual Studio Code hoặc có thể gõ lệnh dưới:
 
 > git checkout master

 2. Update code từ Git về máy nếu branch **"master"** có sự thay đổi:

> git pull

3. Chuyển về lại branch làm việc của mình tương tự như cách 1 hoặc dùng lệnh:

> git checkout [tên nhánh của mình]

4. Gộp code từ branch **"master"** về branch của mình sau khi đã Update code từ bước 2 bằng cách:

> git merge master

#### 2. Sử dụng top và footer để thêm vào trang web của mình
    <?php
        require './backend/web_config.php';
        load_top();
        load_footer();
    ?>


**_TẠM THỜI TỚI ĐÂY, ĐỂ CHIỀU TỐI HỌP TUI THÊM VÔ TIẾP_**