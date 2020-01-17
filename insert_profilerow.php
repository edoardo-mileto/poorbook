<?php
  session_start();

  require_once("dataaccess/profile.php");
  
  if (empty($_POST["testo"])) {
    header("location: profile.php?ptr_user=1&err=1");
  }else{
  $p = new InfoProfilo();
  $p->user = $_SESSION["user_id"];
  $p->type = $_POST["type"];
  $p->message = $_POST["testo"];
  $p->pos = $_POST["pos"];
  $p->vis = $_POST["vis"];
  $res = $p->save();

  if ($res)
  {
    header("location: profile.php?ptr_user=" . $_SESSION["user_id"]);
  }
  else
  {
    header("location: profile.php?err=2&err=2");
  }
}
?>