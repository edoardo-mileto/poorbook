<?php
  session_start();

  // Se non è definito l'utente torno al login
  if (!array_key_exists("user_id", $_SESSION))
  {
    header("location: login.php");
    exit;
  }

  // Se non è indicato l'amico torno ad index
  if (!array_key_exists("post_delete", $_POST))
  {
      header("location: index.php");
      exit;
  }

  require_once('dataaccess/post.php');
  $p = Post::CaricaPost($_POST['post_delete']); // carico l'amicizia dal database
  $p->delete();

  // Reindirizza sul profilo dell'utente a cui abbiamo richiesto l'amicizia
  header("location: index.php");
?>