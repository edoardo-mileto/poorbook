<?php
  session_start();

  // Se non è definito l'utente torno al login
  if (!array_key_exists("user_id", $_SESSION))
  {
    header("location: login.php");
    exit;
  }

  // Se non è indicato l'amico torno ad index
  if (!array_key_exists("profilerow_delete", $_POST))
  {
      header("location: index.php");
      exit;
  }

  require_once('dataaccess/profile.php');
  $p = InfoProfilo::CaricaProfileRow($_POST['profilerow_delete']); // carico l'amicizia dal database
  $p->delete();

  // Reindirizza sul profilo dell'utente a cui abbiamo richiesto l'amicizia
  header("location: profile.php?ptr_user=" . $_SESSION["user_id"]);
?>