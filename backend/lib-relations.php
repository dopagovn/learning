<?php

    require_once("./backend/mysql_config.php");
    function finduser($email){
            $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);

            $query = "SELECT * FROM `users` WHERE Email = '$email' ";
            $result = mysqli_query($connect , $query);
            $array = mysqli_fetch_assoc($result);
            $array['BirthDay'] = date("d-m-Y", strtotime($array['BirthDay']));

            if(isset($array['Email']) == null){
                echo "Không có ai cả";
            }else{
            echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Họ</th>
                    <th>Email</th>
                    <th>Giới tính</th>
                    <th>Sinh nhật</th>
                    <th>Số điện thoại</th>
                </tr>
                <tr>
                    <td>".$array['id']."</td>"
                    ."<td>".$array['FirstName']."</td>"
                    ."<td>".$array['LastName']."</td>"
                    ."<td>".$array['Email']."</td>"
                    ."<td>".$array['Gender']."</td>"
                    ."<td>".$array['BirthDay']."</td>"
                    ."<td>".$array['Phone']."</td>
                </tr>
            </table>";
            }
        }

    function checkRelations($from, $to){
            $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);

            $query = "SELECT * FROM `relations` WHERE `from` = '$from' AND `to` = '$to' AND `status` = 'P'";
            $result = mysqli_query($connect, $query);

            $row = mysqli_fetch_assoc($result);

            // echo "<pre>";
            // print_r($array);  
            
            // Kiem tra trang thai
            if($row["status"] == "P"){
                echo "Lời mời đã gửi";
            }else{
                echo "Lời mời chưa được gửi";
            }
    }
    
    function sendRequest($from, $to){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $data = "SELECT * FROM `relations` WHERE `from` = '$from' AND `to` = '$to'";
        //$query = "INSERT INTO `relations`(`from` , `to`, `status`) VALUES ('$from','$to','P')";
        
        $result = mysqli_query($connect, $data);
        $array = mysqli_fetch_assoc($result);
        
        // echo "<pre>";
        // print_r($array);

        if($array["status"] == ""){
            $insert = "INSERT INTO `relations` (`from`, `to`, `status`) VALUES ('$from' , '$to', 'P')";
            mysqli_query($connect, $insert);
            echo "Da gui loi moi ket ban";
        }else{
            echo "Dang cho doi phuong chap nhan";
        }

        mysqli_close($connect);
    }
    function acceptRequest($from, $to){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $data = "SELECT * FROM `relations` WHERE `from` = '$from' AND `to` = '$to'";
        $row = mysqli_query($connect, $data);
        $array = mysqli_fetch_assoc($row);

        // echo "<pre>";
        // print_r($array);
        
        
        if($array["status"] == "F"){
            echo "Hai bạn đã là bạn bè";
        }elseif($array["status"] == "P"){
            $update = "UPDATE `relations` SET `status` = 'F' WHERE `from` = $from AND `to` = '$to'";
            mysqli_query($connect, $update);
            echo "Đã đồng ý kết bạn";
        }
        mysqli_close($connect);
    }
?>