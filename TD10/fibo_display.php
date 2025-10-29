<?php
session_start();

if (!isset($_SESSION['fibo'])) {
    echo "<p>Veuillez d'abord initialiser la suite avec <a href='fibo_init.php'>fibo_init.php</a></p>";
    exit;
}

$fibo = $_SESSION['fibo'];
echo "<h2>Suite de Fibonacci :</h2>";
echo "Suite de fibonacci: " . json_encode($fibo) . "<br>";
