<?php
  session_start();

  require_once("dataaccess/utente.php");
  
  
  $u = new Utente();
  $u->user_id = $_SESSION["user_id"];
  $u->name = $_POST["name"];
  $u->surname = $_POST["surname"];
  $u->update();

  $newUser = Utente::CaricaUtente($_SESSION["user_id"]);
  $_SESSION['username'] = $newUser->username;

  header("location: profile.php?ptr_user=" . $_SESSION["user_id"]);
?>