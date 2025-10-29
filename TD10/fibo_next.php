<?php
session_start();

if (!isset($_SESSION['fibo'])) {
    echo "<p>Veuillez d'abord initialiser la suite avec <a href='fibo_init.php'>fibo_init.php</a></p>";
    exit;
}

$fibo = $_SESSION['fibo'];
$next = $fibo[count($fibo)-1] + $fibo[count($fibo)-2];
$fibo[] = $next;

$_SESSION['fibo'] = $fibo;

echo "<p>Prochaine valeur : $next</p>";
echo "<p><a href='fibo_next.php'>Suivant</a></p>";
echo "<p><a href='fibo_display.php'>Afficher la suite complète</a></p>";