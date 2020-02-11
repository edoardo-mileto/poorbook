<?php
    session_start();

    if(array_key_exists("user_id",$_SESSION)){
        echo '{"code":1, "description":"logged in", "username":"' . $_SESSION["username"] . '"}';
        exit;
    }else{
        echo '{"code":0, "description":"not logged in}';
        exit;
    }
?>