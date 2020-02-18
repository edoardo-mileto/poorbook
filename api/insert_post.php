<?php
session_start();
require_once("../dataaccess/post.php");

$testo = "Ciao!\nHo giocato a Trivia ed ho fatto " . $_POST['correct'] . " risposte corrette e " . $_POST['wrong'] . " risposte sbagliate\nGioca anche te a trivia! <a href=\"../trivia\">Clicca qui</a>";

echo '{"code":0,"description":"domande corrette: ' . $_POST['correct'] .'"}';
$p = new Post();
$p->message = $testo;
$p->date = new DateTime();
$p->user = $_SESSION["user_id"];
$res = $p->save();
?>