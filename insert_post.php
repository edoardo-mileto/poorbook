<?php
  session_start();

  require_once("dataaccess/post.php");
  
  if (empty($_POST["testo"])) {
    header("location: index.php?err=1");
  }else{
  $p = new Post();
  $p->message = $_POST["testo"];
  $p->date = new DateTime();
  $p->user = $_SESSION["user_id"];
  $res = $p->save();

  if ($res)
  {
    header("location: index.php");
  }
  else
  {
    header("location: index.php?err=2");
  }
}
?>