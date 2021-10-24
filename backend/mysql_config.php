<?php
    //Cấu hình database:
    CONST HOSTNAME = 'localhost'; // Thêm hostname
    CONST USER     = 'root'; // thêm user
    CONST PASS     = ''; // thêm pass
    CONST DB       = 'chatapp'; // thêm Database name
    function createDataBase(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS);
        $query = "CREATE DATABASE IF NOT EXISTS " . DB;
        $result = mysqli_query($connect, $query);
        mysqli_close($connect);
    }
    function createTableUsers(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $query = "CREATE TABLE IF NOT EXISTS Users(
            id int PRIMARY KEY AUTO_INCREMENT,
            FirstName VARCHAR(100) charset utf8,
            LastName VARCHAR(100) charset utf8,
            BirthDay date,
            Gender int, -- 1 nam 0 nữ
            Email varchar(100),
            Password varchar(100),
            Phone varchar(13),
            TimeCreated DateTime
        );";
        $result = mysqli_query($connect, $query);
        mysqli_close($connect);
    }
    function initDataUsers(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $amountRow = getAmountRowInTable('Users');
        if($amountRow > 0){
            return;
        }
        $password = md5('12345');
        $query = "
            INSERT INTO Users(FirstName, LastName, BirthDay, Gender, Email, Password, Phone, TimeCreated) VALUES(N'B',N'Nguyễn','1997/1/15',1,'B@gmail.com', '{$password}', '08614242451', CURRENT_TIMESTAMP());
            INSERT INTO Users(FirstName, LastName, BirthDay, Gender, Email, Password, Phone, TimeCreated) VALUES(N'C',N'Trần','1999/5/23',0,'C@gmail.com', '{$password}', '08614242451', CURRENT_TIMESTAMP());
            INSERT INTO Users(FirstName, LastName, BirthDay, Gender, Email, Password, Phone, TimeCreated) VALUES(N'G',N'Trần','2001/6/5',0,'G@gmail.com', '{$password}', '08614242451', CURRENT_TIMESTAMP());
            INSERT INTO Users(FirstName, LastName, BirthDay, Gender, Email, Password, Phone, TimeCreated) VALUES(N'A',N'Ngọc','1999/2/16',1,'A@gmail.com', '{$password}', '08614242451', CURRENT_TIMESTAMP());
            INSERT INTO Users(FirstName, LastName, BirthDay, Gender, Email, Password, Phone, TimeCreated) VALUES(N'Z',N'Huỳnh','2005/11/29',0,'Z@gmail.com', '{$password}', '08614242451', CURRENT_TIMESTAMP());
        ";
        $result = mysqli_multi_query($connect, $query);
        mysqli_close($connect);
    }
    function createTableUserActive(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $query = 'CREATE TABLE IF NOT EXISTS UserActive (
            id int,
            ActiveCode varchar(100),
            FOREIGN KEY (id) REFERENCES users(id)           
        )';
        mysqli_query($connect, $query);
        mysqli_close($connect);
    }
    function initDataUserActive(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $amountRow = getAmountRowInTable('UserActive');
        if($amountRow > 0){
            return;
        }
        $query = "
            INSERT INTO UserActive VALUES(3, 'abc');
            INSERT INTO UserActive VALUES(5, '123')
        ";
        mysqli_multi_query($connect, $query);
        mysqli_close($connect);
    }
    function getAmountRowInTable($tableName){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $result = mysqli_query($connect ,"SELECT count(*) as Amount FROM {$tableName}");
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $amount = $data[0]['Amount'];
        echo $amount;
        mysqli_free_result($result);
        mysqli_close($connect);
        return $amount;
    }
    function getDataByQuery($query){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $result = mysqli_query($connect ,$query);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        mysqli_close($connect);
        return $data;
    }
    function excuteQuery($query){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $result = mysqli_query($connect ,$query);
        mysqli_close($connect);
    }
?>