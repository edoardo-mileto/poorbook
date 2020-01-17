<?php
  session_start();

  require_once("dataaccess/profile.php");
  
  if (empty($_POST["testo"])) {
    header("location: index.php?err=1");
  }else{
  $p = new InfoProfilo();
  $p->pr_id = $_POST['pr_id'];
  $p->type = $_POST["type"];
  $p->message = $_POST["testo"];
  $p->pos = $_POST["pos"];
  $p->vis = $_POST["vis"];
  $p->update();

  header("location: profile.php?ptr_user=" . $_SESSION["user_id"]);
}
?>