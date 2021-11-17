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
    function createTableConversation(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $query = 'CREATE TABLE IF NOT EXISTS conversation(
            Id int PRIMARY KEY AUTO_INCREMENT,
            Title varchar(100) charset utf8,
            Creator_Id int,
            Create_at DateTime,
            Update_at DateTime,
            Delete_at DateTime,
            FOREIGN KEY (Creator_Id) REFERENCES users(id)
        )';
        mysqli_query($connect, $query);
        mysqli_close($connect);
    }
    function createTableMessages(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $query = "CREATE TABLE IF NOT EXISTS messages(
            Id int PRIMARY KEY AUTO_INCREMENT,
            Conversation_Id int,
            Sender_Id int,
            Message_Type ENUM('text','file'),
            Message varchar(255) charset utf8,
            Attachment_url varchar(255),
            Create_at DateTime,
            Delete_at DateTime,
            FOREIGN KEY (Conversation_Id) REFERENCES conversation(Id),
            FOREIGN KEY (Sender_Id) REFERENCES users(id)
        )";
        mysqli_query($connect, $query);
        mysqli_close($connect);
    }
    function createTableParticipatants(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $query = 'CREATE TABLE IF NOT EXISTS participatants(
            id int PRIMARY KEY AUTO_INCREMENT,
            Conversation_Id int,
            Users_Id int,
            FOREIGN KEY (Conversation_Id) REFERENCES conversation(Id),
            FOREIGN KEY (Users_Id) REFERENCES users(id)
        )';
        mysqli_query($connect, $query);
        mysqli_close($connect);
    }
    function initDataConversation(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $query = "
            INSERT INTO conversation(Title, Creator_Id, Create_at, Update_at, Delete_at) VALUES (N'Nguyễn B', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL);
            INSERT INTO conversation(Title, Creator_Id, Create_at, Update_at, Delete_at) VALUES (N'Ngọc A', 4, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL);
            INSERT INTO conversation(Title, Creator_Id, Create_at, Update_at, Delete_at) VALUES (N'Trần G', 3, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL);
        ";
        mysqli_multi_query($connect, $query);
        mysqli_close($connect);  
    }
    function initDataParticipatants(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $query = "
            INSERT INTO participatants(Conversation_Id, Users_Id) VALUES (1, 1);
            INSERT INTO participatants(Conversation_Id, Users_Id) VALUES (1, 5);
            INSERT INTO participatants(Conversation_Id, Users_Id) VALUES (2, 4);
            INSERT INTO participatants(Conversation_Id, Users_Id) VALUES (2, 5);
            INSERT INTO participatants(Conversation_Id, Users_Id) VALUES (3, 3);
            INSERT INTO participatants(Conversation_Id, Users_Id) VALUES (3, 5);
        ";
        mysqli_multi_query($connect, $query);
        mysqli_close($connect);
    }
    function initDataMessages(){
        $connect = mysqli_connect(HOSTNAME, USER, PASS, DB);
        $query = "
            INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at) VALUES (1, 1, 'text', N'Xin Chào', NULL, CURRENT_TIMESTAMP);
            INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at) VALUES (1, 5, 'text', N'Chào Bạn', NULL, CURRENT_TIMESTAMP);
            INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at) VALUES (1, 1, 'text', N'Bạn tên gì?', NULL, CURRENT_TIMESTAMP);
            INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at) VALUES (1, 5, 'text', N'Mình tên Z, còn bạn?', NULL, CURRENT_TIMESTAMP);
            INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at) VALUES (2, 5, 'text', N'Xin chào mình tên Z rất vui được gặp bạn!', NULL, CURRENT_TIMESTAMP);
            INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at) VALUES (2, 4, 'text', N'Mình cũng rất vui khi gặp bạn', NULL, CURRENT_TIMESTAMP);
            INSERT INTO messages(Conversation_Id, Sender_Id, Message_Type, Message, Attachment_url, Create_at) VALUES (2, 4, 'text', N'Mình tên Ngọc A', NULL, CURRENT_TIMESTAMP);
        ";
        mysqli_multi_query($connect, $query);
        mysqli_close($connect);
    }

    // tool
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