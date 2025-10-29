<?php
session_start();

$a = isset($_GET['a']) ? intval($_GET['a']) : 0;
$b = isset($_GET['b']) ? intval($_GET['b']) : 1;

$_SESSION['fibo'] = [$a, $b];

echo "<p>Suite de Fibonacci initialisée avec $a et $b.</p>";
echo "<p><a href='fibo_next.php'>Calculer la valeur suivante</a></p>";
echo "<p><a href='fibo_display.php'>Afficher la suite complète</a></p>";