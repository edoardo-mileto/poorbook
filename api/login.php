<?php
session_start();

if (!array_key_exists("username", $_SESSION)){

    if (!array_key_exists("email", $_POST) ||
     !array_key_exists("password", $_POST)) {

        echo '{"code":0,"description":"missing parameter"}';
        exit;
    }

    require_once('../dataaccess/utente.php');

    $users = Utente::CaricaUtenti();

    $check = false;

    foreach ($users as $u) //per ogni elemento di utenti che chiamo u confronto
    {
        if ($u->email == $_POST['email']) {
            if ($u->password == $_POST['password']) {
                $check = true;
                $_SESSION['user_id'] = $u->user_id;
                $_SESSION['username'] = $u->username; //se l'utente c'è
            }
        }
    }

    if (!$check){

        echo '{"code":0,"description":"wrong e-mail or password"}';
        exit;
    }
}

echo '{"code":1,"description":"logged in", "username":"' . $_SESSION["username"] . '"}';

?>

