<?php

session_start(); // Démarre ou reprend la session

// Récupère la valeur passée dans l'URL (ex: ?val=3), sinon 1 par défaut
$val = isset($_GET['val']) ? intval($_GET['val']) : 1;

// Si la variable de session n'existe pas encore
if (!isset($_SESSION['sess_counter'])) {
    $_SESSION['sess_counter'] = $val; // Initialisation avec la valeur passée
    echo "Variable 'sess_counter' créée avec la valeur : {$_SESSION['sess_counter']}";
} else {
    // Sinon, on ajoute la valeur passée
    $_SESSION['sess_counter'] += $val;
    echo "Variable 'sess_counter' incrémentée, nouvelle valeur : {$_SESSION['sess_counter']}";
}

echo "<br><a href='session2.php'>Aller à session2.php</a>";
?>
