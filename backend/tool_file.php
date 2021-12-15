<?php
    function byteTo($sizeFile){
        // less 1000 byte
        if($sizeFile < 1000){
            return $sizeFile . ' ' .'B';
        }
        $sizeFile = (float)$sizeFile / 1000;
        if($sizeFile < 1000){
            return $sizeFile . ' ' .'KB';
        }
        $sizeFile = (float)$sizeFile / 1000;
        if($sizeFile < 1000){
            return $sizeFile . ' ' .'MB';
        }
        $sizeFile = (float)$sizeFile / 1000;
        if($sizeFile < 1000){
            return $sizeFile . ' ' .'GB';
        }
    }
    function testImageExist($url, &$ext = ''){
        if(file_exists($url . '.png')){
            $ext = 'png';
            return true;
        }
        else if(file_exists($url . '.jpge')){
            $ext = 'jpge';
            return true;
        }
        else if(file_exists($url . '.jpg')){
            $ext = 'jpg';
            return true;
        }
        else if(file_exists($url . '.ico')){
            $ext = 'ico';
            return true;
        }
        return false;
    }
?>