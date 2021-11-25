<?php
    session_start();
    if(!isset($_SESSION['idUser'])){
        header('location: index.php');
    }
    else{
        if(isset($_POST['updateOnline'])){
            $idUser = $_SESSION['idUser'];
            $nowDate = new DateTime('NOW', new DateTimeZone('ASIA/saigon'));
            if(!file_exists('online.txt')){              
                $data = [];
                $data[] = ['idUser' => $idUser, 'time' => $nowDate];
                file_put_contents('online.txt', json_encode($data));
            }
            else{
                $data = file_get_contents('online.txt');
                $data = json_decode($data, true);
                foreach($data as &$userdata){
                    if($userdata['idUser'] == $idUser){
                        $userdata['time'] = $nowDate;
                        file_put_contents('online.txt', json_encode($data));
                        echo 'exist';
                        exit();
                    }
                }
                $data[] = ['idUser' => $idUser, 'time' => $nowDate];
                file_put_contents('online.txt', json_encode($data));
                echo 'not exist';
            } 
        }
        else if(isset($_POST['getStatusParticipant'])){
            if(file_exists('online.txt') && isset($_SESSION['ConversationChosen'])){
                $idUser = $_SESSION['idUser'];
                $idConversationChosen = $_SESSION['ConversationChosen'];

                require_once('backend/mysql_config.php');
                $idParticipants = getDataByQuery("SELECT Users_Id FROM participatants WHERE Conversation_Id = {$idConversationChosen} AND Users_Id != {$idUser}");
                // chat 1 vs 1
                if(count($idParticipants) == 1){
                    $idParticipant = $idParticipants[0]['Users_Id'];
                    $onlineData = file_get_contents('online.txt');
                    $onlineData = json_decode($onlineData, true);
                    foreach($onlineData as $userdata){
                        if($userdata['idUser'] == $idParticipant){
                            $date = new DateTime($userdata['time']['date']);
                            $now = new DateTime('NOW',new DateTimeZone('ASIA/saigon'));

                            if($date->format('y') < $now->format('y')){
                                echo 'Offine';
                            }
                            else if($date->format('m') < $now->format('m')){
                                echo 'Offine';
                            }
                            else if($date->format('d') < $now->format('d')){
                                $d = $now->format('d') - $date->format('d');
                                if($d == 1){
                                    $g = $now->format('H') - $date->format('H');
                                    $g = 24 - ($date->format('H') - $now->format('H'));
                                    if($g >= 24){
                                        echo "Online {$d} ngày trước";
                                    }
                                    else{
                                        echo "Online {$g} giờ trước";
                                    }
                                }
                                else{
                                    echo "Online {$d} ngày trước";
                                }
                            }
                            else if($date->format('H') < $now->format('H')){
                                $g = $now->format('H') - $date->format('H');
                                echo "Online {$g} giờ trước";
                            }                          
                            else if($date->format('i') < $now->format('i')){
                                $m = $now->format('i') - $date->format('i');
                                echo "Online {$m} phút trước";
                            }
                            else{
                                echo "Online";
                            }
                            exit();
                        }
                    }
                }
                echo 'Not Found';
            }
            else{
                echo 'Not Found';
            }
        }
    }
?>