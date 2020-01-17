<?php
  session_start();

  // Se non è definito l'utente torno al login
  if (!array_key_exists("user_id", $_SESSION))
  {
    header("location: login.php");
    exit;
  }

  // Se non è indicato l'amico torno ad index
  if (!array_key_exists("friend", $_POST))
  {
      header("location: index.php");
      exit;
  }

  require_once('dataaccess/amicizia.php');
  $a = new Amicizia();
  $a->friend_1 = $_SESSION["user_id"];
  $a->friend_2 = $_POST["friend"];
  $a->accepted = 0;
  $a->save();

  // Reindirizza sul profilo dell'utente a cui abbiamo richiesto l'amicizia
  header("location: profile.php?ptr_user=" . $_POST["friend"]);
?>