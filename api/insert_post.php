<?php
session_start();
require_once("../dataaccess/post.php");

if (!array_key_exists("correct", $_POST) || !array_key_exists("wrong", $_POST)) {
        echo '{"code":0,"description":"missing parameter"}';
        exit;
    }else{

$testo = "Ciao!\nHo giocato a Trivia ed ho fatto " . $_POST['correct'] . " risposte corrette e " . $_POST['wrong'] . " risposte sbagliate\nGioca anche te a trivia! <a href=\"../trivia\">Clicca qui</a>";

$p = new Post();
$p->message = $testo;
$p->date = new DateTime();
$p->user = $_SESSION["user_id"];
$res = $p->save();

if ($res)
  {
    echo '{"code":1,"description":"Success! Results posted"}';
  }
  else
  {
    echo '{"code":0,"description":"Something went wrong trying to insert your post"}';
  }
}
?>