<?php
  session_start();

  require_once("dataaccess/post.php");
  
  if (empty($_POST["testo"])) {
    header("location: index.php?err=1");
  }else{
  $p = new Post();
  $p->post_id = $_POST['post_id'];
  $p->message = $_POST["testo"];
  $p->date = new DateTime();
  $p->update();

  header("location: index.php");
}
?>