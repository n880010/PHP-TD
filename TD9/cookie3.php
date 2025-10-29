<?php
require_once 'AlbumTrack.php';
$cookie_name = "compteur";
if (isset($_COOKIE[$cookie_name])) {
    $value = intval($_COOKIE[$cookie_name]) + 1;
} else {
    $value = 1;
}
setcookie($cookie_name, $value, time() + 3600, "/");
echo "Valeur actuelle du cookie compteur : $value";

// avec albumtrack
if (isset($_COOKIE['track'])) {
    $track = unserialize($_COOKIE['track']);
    echo "<br>";
    echo "Track lu depuis le cookie :<br>";
    echo $track->__toString();
} else {
    $track = new AlbumTrack("Imagine", "John Lennon"," John Lennon", 183, "Rock");
    setcookie('track', serialize($track), time() + 3600, "/");
    echo '<br>';
    echo "Création du cookie 'track' avec un objet sérialisé.";
}
// le cookie est local et quand on supprime les cookies via extension ou autre le compteur se réinitialise
?>

