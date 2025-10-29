<?php
$cookie_name = "chocolat";
if (isset($_COOKIE[$cookie_name])) {
    echo "Cookie visible ici : " . $_COOKIE[$cookie_name];
} else {
    echo "Aucun cookie trouvé dans ce répertoire.";
}
?>
