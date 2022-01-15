<?php
    if(!isset($_COOKIE['setting'])){
        $settingConfig['language'] = 'vi';
        $settingConfig['theme'] = 'light';
        $jsonSettingConfig = json_encode($settingConfig);
    
        $secondInDay = 86400;
        setcookie('setting', $jsonSettingConfig, time() + $secondInDay, '/');
    }
?>